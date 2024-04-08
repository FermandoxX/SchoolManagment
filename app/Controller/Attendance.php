<?php
namespace App\Controller;

use App\Model\AttendanceModel;
use App\Model\SubjectModel;
use App\Model\UserModel;
use Core\Request;
use Core\Response;
use Core\Validation;
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
        $pattern = [];
        $condition = [];

        if(isset($data['search'])){
            $pattern['subject_name'] = $data['search'];
        }

        $pageSum = $this->subjectModel->pages($condition,$pattern);
        $subjectsData = $this->subjectModel->pagination($condition,$pattern,$data);

        return view('attendance/attendance',['pages'=>$pageSum,'subjectsData'=>$subjectsData,'data'=>$data]);
    }

    public function attendanceSubject(){
        $data = $this->request->getBody();
        $this->userModel->join = 'inner join subjects s on u.class_id = s.class_id';
        $year = date('Y') - 2;
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $studentsData = $this->userModel->getData(['role_name'=>'student','subject_id'=>$data['subject_id']]);
        return view('attendance/attendance_subject',['studentsData'=>$studentsData, 'year'=>$year, 'months'=>$months, 'data'=>$data]);
    }

    public function showAttendance(){
        $data = $this->request->getBody();

        $date = strtotime($data['month'].' '.$data['year']);
        $monthByNumber = date_parse($data['month'])['month'];
        $formattedDate = date('Y-m', $date);

        $attendanceCondition = ['subject_id'=>$data['subject_id']];
        $attendancesStudent = [];
        $year = date('Y') - 2;
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $rules = $this->attendanceModel->attendanceRules();

        if($data['student_id'] != ""){
            $attendanceCondition['student_id'] = $data['student_id'];
        }

        $this->userModel->join = 'inner join subjects s on u.class_id = s.class_id';
        $studentsData = $this->userModel->getData(['role_name'=>'student','subject_id'=>$data['subject_id']]);

        if($this->validation->validate($data,$rules)){
            $days = [];
            $day = cal_days_in_month(CAL_GREGORIAN, $monthByNumber, $data['year']); 

            for($i = 1;$i <= $day;$i ++){
                $days[]=$i;
            }

            $this->attendanceModel->join = 'inner join users u on u.user_id = a.student_id';
            $attendancesData = $this->attendanceModel->getData($attendanceCondition,['attendance_date'=>$formattedDate]);
            foreach($attendancesData as $attendanceData){
                $attendancesStudent[$attendanceData->name.' '.$attendanceData->surename][] = (int)date("d", strtotime($attendanceData->attendance_date));
            }
            return view('attendance/attendance_subject',['attendancesStudent'=>$attendancesStudent,'studentsData'=>$studentsData, 'year'=>$year, 'months'=>$months, 'days'=>$days, 'data'=>$data]);
        }
        return view('attendance/attendance_subject',['validation'=>$this->validation,'studentsData'=>$studentsData, 'year'=>$year, 'months'=>$months, 'data'=>$data]);
    }


    public function addAttendance(){
        $data = $this->request->getBody();
        $this->userModel->join = 'inner join subjects s on u.class_id = s.class_id';

        $studentsData = $this->userModel->getData(['subject_id'=>$data['subject_id']],[],[],false);

        return view('attendance/attendance_add',['data'=>$data,'studentsData'=>$studentsData]);
    }

    public function insertAttendance(){
        $data = $this->request->getBody();
        $rules = $this->attendanceModel->attendanceRules();
        $this->userModel->join = 'inner join subjects s on u.class_id = s.class_id';
        $studentsData = $this->userModel->getData(['subject_id'=>$data['subject_id']]);

        if(!isset($data['checkbox'])){
            setFlashMessage('error','Choose a student to add a attendance');
            redirect("/attendance/add?subject_id=".$data['subject_id']);
            exit;
        }

        if($this->validation->validate($data,$rules)){ 

            $checkbox = $this->attendanceModel->existAttendance($data);
            foreach($checkbox as $studentId){
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
        return view('attendance/attendance_add',['validation'=>$this->validation,'data'=>$data,'studentsData'=>$studentsData]);
    }

    public function removeAttendance(){
        $data = $this->request->getBody();
        $this->attendanceModel->join = 'inner join users u on u.user_id = a.student_id';
        $condition = ['subject_id'=>$data['subject_id']];
        $pattern = [];

        if(isset($data['search'])){
            $pattern['name'] = $data['search'];
            $pattern['surename'] = $data['search'];
            $pattern['attendance_date'] = $data['search'];
        }

        $pageSum = $this->attendanceModel->pages($condition,$pattern);
        $attendancesData = $this->attendanceModel->pagination($condition,$pattern,$data);

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

        $this->attendanceModel->deleteData($data['attendance_id']);
        setFlashMessage('success','Attendance deleted successfully');
        redirect("/attendance/remove?subject_id=".$data['subject_id']);

    }

}