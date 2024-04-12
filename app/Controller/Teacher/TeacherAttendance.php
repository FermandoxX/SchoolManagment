<?php
namespace App\Controller\Teacher;

use App\Model\AttendanceModel;
use App\Model\SubjectModel;
use App\Model\UserModel;
use Core\Request;
use Core\Response;
use Core\Validation;

class TeacherAttendance {

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
        $condition = ['teacher_id'=>getUserId()];

        $pageSum = $this->subjectModel->pages($condition);
        $subjectsData = $this->subjectModel->pagination($condition,[],$data);

        return view('attendance/attendance',['pages'=>$pageSum,'subjectsData'=>$subjectsData,'data'=>$data]);
    }

    public function attendanceSubject(){
        $data = $this->request->getBody();
        $teacherSubjectsId = $this->subjectModel->teacherSubjectsId(getUserId());

        if(!in_array($data['subject_id'],$teacherSubjectsId)){
            setFlashMessage('error','You do not have permission to view attendance at subjects who are not assigned to you');
            redirect('/teacher/attendance');
            exit;
        }

        $this->userModel->join = 'inner join subjects s on u.class_id = s.class_id';
        $year = date('Y') - 2;
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $studentsData = $this->userModel->getData(['role_name'=>'student','subject_id'=>$data['subject_id']]);
        
        return view('attendance/attendance_subject',['studentsData'=>$studentsData, 'year'=>$year, 'months'=>$months, 'data'=>$data]);
    }


    public function addAttendance(){
        $data = $this->request->getBody();
        $teacherSubjectsId = $this->subjectModel->teacherSubjectsId(getUserId());

        if(!in_array($data['subject_id'],$teacherSubjectsId)){
            setFlashMessage('error','You do not have permission to add attendance at subjects who are not assigned to you');
            redirect('/teacher/attendance');
            exit;
        }
    
        $this->userModel->join = 'inner join subjects s on u.class_id = s.class_id';
        $studentsData = $this->userModel->getData(['subject_id'=>$data['subject_id']]);

        return view('attendance/attendance_add',['data'=>$data,'studentsData'=>$studentsData]);
    }

    public function removeAttendance(){
        $data = $this->request->getBody();
        $teacherSubjectsId = $this->subjectModel->teacherSubjectsId(getUserId());

        if(!in_array($data['subject_id'],$teacherSubjectsId)){
            setFlashMessage('error','You do not have permission to view attendance at subjects who are not assigned to you');
            redirect('/teacher/attendance');
            exit;
        }

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
        $teacherSubjectsId = $this->subjectModel->teacherSubjectsId(getUserId());

        if(!$checkingAttendance){
            setFlashMessage('error','Attendance dont exist');
            redirect('/teacher/attendance/remove?subject_id='.$data['subject_id']);
            exit;
        }

        if(!in_array($data['subject_id'],$teacherSubjectsId)){
            setFlashMessage('error','You do not have permission to delete attendance at subjects who are not assigned to you');
            redirect('/teacher/attendance');
            exit;
        }

        $this->attendanceModel->delete($data['attendance_id']);
        setFlashMessage('success','Attendance deleted successfully');
        redirect("/teacher/attendance/remove?subject_id=".$data['subject_id']);
    }

}