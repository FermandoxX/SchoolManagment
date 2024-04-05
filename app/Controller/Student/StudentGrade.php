<?php 

namespace App\Controller\Student;

use App\Model\ClassModel;
use App\Model\GradeModel;
use App\Model\SubjectModel;
use App\Model\UserModel;
use Core\Request;
use Core\Response;
use Core\Validation;

class StudentGrade {

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

    public function subject(){
        $data = $this->request->getBody();
        $pattern = [];
        $condition = ['user_id'=>getUserId()];
        $this->userModel->join = 'inner join subjects s on s.class_id = u.class_id';

        $averageGrade = $this->gradeAverageCalculate(getUserId());
        $data['averageGrade'] = $averageGrade;

        if(isset($data['search'])){
            $pattern['subject_name'] = $data['search'];
        }

        $pageSum = $this->userModel->pages($condition,$pattern);
        $subjectsData = $this->userModel->pagination($condition,$pattern,$data);
// dd($subjectsData);
        return view('grade/grade_subjects',['pages'=>$pageSum,'subjectsData'=>$subjectsData,'data'=>$data]);
    }

    public function add(){
        $data = $this->request->getBody();
        $studentSubjects = $this->subjectModel->studentSubjectsId(getUserId());

        if(!in_array($data['subject_id'],$studentSubjects)){
            setFlashMessage('error','You do not have permission to view grades assigned to other subjects');
            redirect('/grade/supject?student_id='.getUserId());
            exit;
        }

        $this->gradeModel->join = 'inner join subjects s on g.subject_id = s.subject_id';
        $this->subjectModel->join = 'inner join classes c on c.class_id = s.class_id
        inner join users u on s.teacher_id = u.user_id';
        $gradeCondition = ['student_id'=>getUserId(),'s.subject_id'=>$data['subject_id']];
        $subjectCondition = ['s.subject_id'=>$data['subject_id']];

        $gradeData = $this->gradeModel->getData($gradeCondition);
        $subjectData = $this->subjectModel->getData($subjectCondition);

        return view('grade/grade_add',['gradeData'=>$gradeData,'subjectData'=>$subjectData,'data'=>$data]);
    }

    public function gradeCalculate($assigmentGrade,$midtermExamGrade,$finalExamGrade){
        $assigmentGrade = $assigmentGrade * 0.2;
        $midtermExamGrade = $midtermExamGrade * 0.3;
        $finalExamGrade = $finalExamGrade * 0.5;

        $grade = $assigmentGrade + $midtermExamGrade + $finalExamGrade;

        return $grade;
    }

    public function gradeAverageCalculate($studentId){
        $gradesNumber = 0;
        $totalGrade = 0;
        $averageGrade = 0;

        $gradesData = $this->gradeModel->getData(['student_id'=>$studentId]);

        foreach($gradesData as $gradeData){
            $gradesNumber ++;
            $totalGrade += $gradeData->grade;
        }

        if($gradesNumber > 0){
            $averageGrade = $totalGrade/$gradesNumber;
        }

        return round($averageGrade,2);
    }

}

