<?php
namespace App\Controller\Student;

use App\Model\AttendanceModel;
use App\Model\SubjectModel;
use App\Model\UserModel;
use Core\Request;
use Core\Response;
use Core\Validation;

class StudentAttendance {

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
        $condition = ['user_id'=>getUserId()];
        $this->subjectModel->join = 'inner join users u on s.class_id = u.class_id';

        if(isset($data['search'])){
            $pattern['subject_name'] = $data['search'];
        }    

        $pageSum = $this->subjectModel->pages($condition,$pattern);
        $subjectsData = $this->subjectModel->pagination($condition,$pattern,$data);

        return view('attendance/attendance',['pages'=>$pageSum,'subjectsData'=>$subjectsData,'data'=>$data]);
    }

    public function attendanceSubject(){
        $data = $this->request->getBody();
        $studentSubjects = $this->subjectModel->studentSubjectsId(getUserId());

        if(!in_array($data['subject_id'],$studentSubjects)){
            setFlashMessage('error','You do not have permission to view attendance to other subjects that arent assigned to you');
            redirect('/attendance');
            exit;
        }

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
        
        $attendanceCondition = ['subject_id'=>$data['subject_id'],'student_id'=>getUserId()];
        $attendancesStudent = [];
        $year = date('Y') - 2;
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $rules = $this->attendanceModel->attendanceRules();

        if(!empty($data['student_id'])){
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
            $attendancesData = $this->attendanceModel->getData($attendanceCondition,['attendance_date'=>$formattedDate],[],false);
            foreach($attendancesData as $attendanceData){
                $attendancesStudent[$attendanceData->name.' '.$attendanceData->surename][] = (int)date("d", strtotime($attendanceData->attendance_date));
            }
            return view('attendance/attendance_subject',['attendancesStudent'=>$attendancesStudent,'studentsData'=>$studentsData, 'year'=>$year, 'months'=>$months, 'days'=>$days, 'data'=>$data]);
        }
        return view('attendance/attendance_subject',['validation'=>$this->validation,'studentsData'=>$studentsData, 'year'=>$year, 'months'=>$months, 'data'=>$data]);
    }

}