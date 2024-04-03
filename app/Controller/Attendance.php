<?php
namespace App\Controller;

use App\Model\AttendanceModel;
use App\Model\SubjectModel;
use App\Model\UserModel;
use Core\Request;
use Core\Response;
use Core\Validation;
use PDO;

class Attendance {

    public Request $request;
    public Response $response;
    public Validation $validation;
    public SubjectModel $subjectModel;
    public UserModel $userModel;
    public AttendanceModel $attendanceModel;

    public function __construct(Request $request, Response $response, Validation $validation, SubjectModel $subjectModel, UserModel $userModel, AttendanceModel $attendanceModel){
        $this->request = $request;
        $this->response = $response;
        $this->validation = $validation;
        $this->subjectModel = $subjectModel;
        $this->userModel = $userModel;
        $this->attendanceModel = $attendanceModel;
    }

    public function index(){
        $data = $this->request->getBody();
        $rowPerPage = 3;
        $offset = 0;
        $pattern = [];
        $condition = [];
        $query = null;

        if(isset($data['search'])){
            $pattern['subject_name'] = $data['search'];
        }

        if(isTeacher()){
            $condition['teacher_id'] = getUserId();
        }
        
        if(isStudent()){
            $query = 'inner join users u on s.class_id = u.class_id';
            $condition['user_id'] = getUserId();
        }

        $pageSum = $this->subjectModel->pages($condition,$rowPerPage,$pattern,$query);
        $subjectsData = $this->subjectModel->pagination($condition,$rowPerPage,$offset,$pattern,$data,$query);

        return view('attendance/attendance',['pages'=>$pageSum,'subjectsData'=>$subjectsData,'data'=>$data]);
    }

    public function attendanceSubject(){
        $data = $this->request->getBody();
        $query = 'inner join subjects s on u.class_id = s.class_id';
        $year = date('Y') - 2;
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        if(isTeacher()){
            $teacherSubjectsId = $this->subjectModel->teacherSubjectsId(getUserId());

            if(!in_array($data['subject_id'],$teacherSubjectsId)){
                setFlashMessage('error','You do not have permission to view attendance at subjects who are not assigned to you');
                redirect('/attendance');
                exit;
            }
        }

        if(isStudent()){
            $studentSubjects = $this->subjectModel->studentSubjectsId(getUserId());

            if(!in_array($data['subject_id'],$studentSubjects)){
                setFlashMessage('error','You do not have permission to view attendance to other subjects that arent assigned to you');
                redirect('/attendance');
                exit;
            }
        }

        $studentsData = $this->userModel->getData(['role_name'=>'student','subject_id'=>$data['subject_id']],[],[],false,$query);
      
        return view('attendance/attendance_subject',['studentsData'=>$studentsData, 'year'=>$year, 'months'=>$months, 'data'=>$data]);
    }

    public function showAttendance(){
        $data = $this->request->getBody();

        $date = strtotime($data['month'].' '.$data['year']);
        $monthByNumber = date_parse($data['month'])['month'];
        $formattedDate = date('Y-m', $date);
        
        $attendanceCondition = ['subject_id'=>$data['subject_id']];
        $attendancesQuery = 'inner join users u on u.user_id = a.student_id';
        $attendancesStudent = [];
        $studentsQuery = 'inner join subjects s on u.class_id = s.class_id';
        $year = date('Y') - 2;
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $getRules = $this->attendanceModel->attendanceRules();

        if(!empty($data['student_id'])){
            $attendanceCondition['student_id'] = $data['student_id'];
        }

        if(isStudent()){
            $attendanceCondition['student_id'] = getUserId();
        }

        $studentsData = $this->userModel->getData(['role_name'=>'student','subject_id'=>$data['subject_id']],[],[],false,$studentsQuery);

        if($this->validation->validate($data,$getRules)){
            $days = [];
            $day = cal_days_in_month(CAL_GREGORIAN, $monthByNumber, $data['year']); 

            for($i = 1;$i <= $day;$i ++){
                $days[]=$i;
            }

            $attendancesData = $this->attendanceModel->getData($attendanceCondition,['attendance_date'=>$formattedDate],[],false,$attendancesQuery);
            foreach($attendancesData as $attendanceData){
                $attendancesStudent[$attendanceData->name.' '.$attendanceData->surename][] = (int)date("d", strtotime($attendanceData->attendance_date));
            }
            return view('attendance/attendance_subject',['attendancesStudent'=>$attendancesStudent,'studentsData'=>$studentsData, 'year'=>$year, 'months'=>$months, 'days'=>$days, 'data'=>$data]);
        }
        return view('attendance/attendance_subject',['validation'=>$this->validation,'studentsData'=>$studentsData, 'year'=>$year, 'months'=>$months, 'data'=>$data]);
    }


    public function addAttendance(){
        $data = $this->request->getBody();

        if(isTeacher()){
            $teacherSubjectsId = $this->subjectModel->teacherSubjectsId(getUserId());

            if(!in_array($data['subject_id'],$teacherSubjectsId)){
                setFlashMessage('error','You do not have permission to add attendance at subjects who are not assigned to you');
                redirect('/attendance');
                exit;
            }
        }

        $query = 'inner join subjects s on u.class_id = s.class_id';
        $studentsData = $this->userModel->getData(['subject_id'=>$data['subject_id']],[],[],false,$query);

        return view('attendance/attendance_add',['data'=>$data,'studentsData'=>$studentsData]);
    }

    public function insertAttendance(){
        $data = $this->request->getBody();
        $getRules = $this->attendanceModel->attendanceRules();
        $query = 'inner join subjects s on u.class_id = s.class_id';
        $studentsData = $this->userModel->getData(['subject_id'=>$data['subject_id']],[],[],false,$query);

        if(!isset($data['checkbox'])){
            setFlashMessage('error','Choose a student to add a attendance');
            redirect("/attendance/add?subject_id=".$data['subject_id']);
            exit;
        }

        if($this->validation->validate($data,$getRules)){ 

            if($this->attendanceModel->existAttendance($data,$data['subject_id'])['value']){
                foreach($data['checkbox'] as $studentId){
                    $date = strtotime($data['attendance_date']);
                    $date = date('Y-m-d', $date);
                    $data['attendance_date'] = $date;
                    $data['student_id'] = $studentId;
                    unset($data['checkbox']);
                    $this->attendanceModel->insertData($data);
                }
                setFlashMessage('success','Attendance inserted successfully');
                redirect("/attendance/add?subject_id=".$data['subject_id']);
                exit;
            }
            $studentId = $this->attendanceModel->existAttendance($data,$data['subject_id'])['studentId'];
            $studentData = $this->userModel->getDataById($studentId);
            $studentName = $studentData->name .' '. $studentData->surename;
            setFlashMessage('error',"Attendance already exists for this date at student $studentName");
            redirect("/attendance/add?subject_id=".$data['subject_id']);
            exit;
        }
        return view('attendance/attendance_add',['validation'=>$this->validation,'data'=>$data,'studentsData'=>$studentsData]);
    }

    public function removeAttendance(){
        $data = $this->request->getBody();
        $rowPerPage = 5;
        $offset = 0;
        $query = 'inner join users u on u.user_id = a.student_id';
        $condition = ['subject_id'=>$data['subject_id']];
        $pattern = [];

        if(isTeacher()){
            $teacherSubjectsId = $this->subjectModel->teacherSubjectsId(getUserId());

            if(!in_array($data['subject_id'],$teacherSubjectsId)){
                setFlashMessage('error','You do not have permission to view attendance at subjects who are not assigned to you');
                redirect('/attendance');
                exit;
            }
        }

        if(isset($data['search'])){
            $pattern['name'] = $data['search'];
            $pattern['surename'] = $data['search'];
            $pattern['attendance_date'] = $data['search'];
        }

        $pageSum = $this->attendanceModel->pages($condition,$rowPerPage,$pattern,$query);
        $attendancesData = $this->attendanceModel->pagination($condition,$rowPerPage,$offset,$pattern,$data,$query);

        return view('attendance/attendance_remove',['pages'=>$pageSum,'attendancesData'=>$attendancesData,'data'=>$data]);
    }

    public function deleteAttendance(){
        $data = $this->request->getBody();
        $checkingAttendance = $this->attendanceModel->getDataById($data['attendance_id']);

        if(!$checkingAttendance){
            setFlashMessage('error','Attendance dont exist');
            redirect('/attendance/remove?subject_id='.$data['subject_id']);
            exit;
        }
        
        if(isTeacher()){
            $teacherSubjectsId = $this->subjectModel->teacherSubjectsId(getUserId());

            if(!in_array($data['subject_id'],$teacherSubjectsId)){
                setFlashMessage('error','You do not have permission to delete attendance at subjects who are not assigned to you');
                redirect('/attendance');
                exit;
            }
        }

        $this->attendanceModel->deleteData($data['attendance_id']);
        setFlashMessage('success','Attendance deleted successfully');
        redirect("/attendance/remove?subject_id=".$data['subject_id']);

    }

}