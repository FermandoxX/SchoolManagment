<?php 

namespace App\Controller\Teacher;

use App\Model\ClassModel;
use App\Model\GradeModel;
use App\Model\SubjectModel;
use App\Model\UserModel;
use Core\Request;
use Core\Response;
use Core\Validation;

class TeacherGrade {

    public Request $request;
    public Response $response;
    public Validation $validation;
    public GradeModel $gradeModel;
    public UserModel $userModel;
    public ClassModel $classModel;
    public SubjectModel $subjectModel;

    public function __construct(Request $request,Response $response,Validation $validation,GradeModel $gradeModel,UserModel $userModel,ClassModel $classModel,SubjectModel $subjectModel)
    {
        $this->request = $request;
        $this->response = $response;
        $this->validation = $validation;
        $this->gradeModel = $gradeModel;
        $this->userModel = $userModel;   
        $this->classModel = $classModel;
        $this->subjectModel = $subjectModel;
    }

    public function index(){
        $data = $this->request->getBody();
        $teacherSubjectsId = $this->subjectModel->teacherSubjectsId(getUserId());

        if(!in_array($data['subject_id'],$teacherSubjectsId)){
            setFlashMessage('error','You do not have permission to view students assigned to other teachers');
            redirect('/grade/subject?teacher_id='.getUserId());
            exit;
        }

        $this->userModel->join = 'inner join classes c on u.class_id = c.class_id
        inner join subjects s on s.class_id = u.class_id';
        $condition = ['role_name'=>'student','subject_id'=>$data['subject_id']];

        $pageSum = $this->userModel->pages($condition);
        $studentsData = $this->userModel->pagination($condition,[],$data);

        return view('grade/grade',['pages'=>$pageSum,'studentsData'=>$studentsData,'data'=>$data]);
    }

    public function subject(){
        $data = $this->request->getBody();
        $this->userModel->join = 'inner join subjects s on s.teacher_id = u.user_id';
        $condition = ['user_id'=>getUserId()];
        
        $pageSum = $this->userModel->pages($condition);
        $subjectsData = $this->userModel->pagination($condition,[],$data);

        return view('grade/grade_subjects',['pages'=>$pageSum,'subjectsData'=>$subjectsData,'data'=>$data]);
    }

    public function add(){
        $data = $this->request->getBody();
        $teacherSubjectsId = $this->subjectModel->teacherSubjectsId(getUserId());

        if(!in_array($data['subject_id'],$teacherSubjectsId)){
            setFlashMessage('error','You do not have permission to add grades at subjects who are not assigned to you');
            redirect('/grade/subject?teacher_id='.getUserId());
            exit;
        }

        $teacherStudentsId = $this->subjectModel->teacherStudentsId(getUserId(),$data['subject_id']);

        if(!in_array($data['student_id'],$teacherStudentsId)){
            setFlashMessage('error','You do not have permission to grade students who are not assigned to you or arent in this class');
            redirect('/grade/subject?teacher_id='.getUserId());
            exit;
        }

        $this->gradeModel->join = 'inner join subjects s on g.subject_id = s.subject_id';
        $this->subjectModel->join = 'inner join classes c on c.class_id = s.class_id
        inner join users u on s.teacher_id = u.user_id';
        $gradeCondition = ['student_id'=>$data['student_id'],'s.subject_id'=>$data['subject_id']];
        $subjectCondition = ['s.subject_id'=>$data['subject_id']];

        $gradeData = $this->gradeModel->getData($gradeCondition);
        $subjectData = $this->subjectModel->getData($subjectCondition);

        return view('grade/grade_add',['gradeData'=>$gradeData,'subjectData'=>$subjectData,'data'=>$data]);
    }


}

