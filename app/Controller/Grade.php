<?php 

namespace App\Controller;

use App\Model\ClassModel;
use App\Model\GradeModel;
use App\Model\SubjectModel;
use App\Model\UserModel;
use Core\Request;
use Core\Response;
use Core\Validation;

class Grade {

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

        $this->userModel->join = 'inner join classes c on u.class_id = c.class_id
        inner join subjects s on s.class_id = u.class_id';
        $condition = ['role_name'=>'student','subject_id'=>$data['subject_id']];

        $pageSum = $this->userModel->pages($condition);
        $studentsData = $this->userModel->pagination($condition,[],$data);

        return view('grade/grade',['pages'=>$pageSum,'studentsData'=>$studentsData,'data'=>$data]);
    }

    public function subject(){
        $data = $this->request->getBody();

        $pageSum = $this->subjectModel->pages();
        $subjectsData = $this->subjectModel->pagination([],[],$data);
        
        return view('grade/grade_subjects',['pages'=>$pageSum,'subjectsData'=>$subjectsData,'data'=>$data]);
    }

    public function add(){
        $data = $this->request->getBody();

        $this->gradeModel->join = 'inner join subjects s on g.subject_id = s.subject_id';
        $this->subjectModel->join = 'inner join classes c on c.class_id = s.class_id
        inner join users u on s.teacher_id = u.user_id';
        $gradeCondition = ['student_id'=>$data['student_id'],'s.subject_id'=>$data['subject_id']];
        $subjectCondition = ['s.subject_id'=>$data['subject_id']];

        $gradeData = $this->gradeModel->getData($gradeCondition);
        $subjectData = $this->subjectModel->getData($subjectCondition);

        return view('grade/grade_add',['gradeData'=>$gradeData,'subjectData'=>$subjectData,'data'=>$data]);
    }

    public function insert(){

        $data = $this->request->getBody();
        $rules = $this->gradeModel->gradesRule();
        $this->subjectModel->join = 'inner join classes c on c.class_id = s.class_id
        inner join users u on s.teacher_id = u.user_id';

        if($this->validation->validate($data,$rules)){

            if($data['grade_id'] == ""){
                unset($data['grade_id']);

                $grade = $this->gradeCalculate($data['assigment_grade'],$data['midterm_exam_grade'],$data['final_exam_grade']);
                $data['grade'] = $grade;

                $this->gradeModel->insertData($data);
                setFlashMessage('success','Grade inserted successfully');
                redirect('/grade/subject?student_id='.$data['student_id']);
                exit;
            }

            $grade = $this->gradeCalculate($data['assigment_grade'],$data['midterm_exam_grade'],$data['final_exam_grade']);
            $data['grade'] = $grade;

            $this->gradeModel->updateDataById($data['grade_id'],$data);

            setFlashMessage('success','Grade updated successfully');
            redirect('/grade?subject_id='.$data['subject_id']);
            exit;
        }
        
        $gradeData = $this->gradeModel->getData(['student_id'=>$data['student_id'],'subject_id'=>$data['subject_id']]);
        $subjectData = $this->subjectModel->getData(['subject_id'=>$data['subject_id']]);

        return view('grade/grade_add',['gradeData'=>$gradeData,'subjectData'=>$subjectData,'data'=>$data,'validation'=>$this->validation]);
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

