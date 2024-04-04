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
        $condition = ['role_name'=>'student'];
        $rowPerPage = 5;
        $offset = 0;
        $pattern = [];
        $this->userModel->join = 'inner join classes c on u.class_id = c.class_id';
        
        if(isset($data['search'])){
            $pattern['email'] = $data['search'];
        }

        if(isTeacher()){
            $teacherSubjectsId = $this->subjectModel->teacherSubjectsId(getUserId());

            if(!in_array($data['subject_id'],$teacherSubjectsId)){
                setFlashMessage('error','You do not have permission to view students assigned to other teachers');
                redirect('/grade/supject?teacher_id='.getUserId());
                exit;
            }

            $this->userModel->join .= ' inner join subjects s on s.class_id = u.class_id';
            $condition['subject_id'] = $data['subject_id'];
        }

        $pageSum = $this->userModel->pages($condition,$rowPerPage,$pattern);
        $studentsData = $this->userModel->pagination($condition,$rowPerPage,$offset,$pattern,$data);

        return view('grade/grade',['pages'=>$pageSum,'studentsData'=>$studentsData,'data'=>$data]);
    }

    public function subject(){
        $data = $this->request->getBody();
        $rowPerPage = 3;
        $offset = 0;
        $pattern = [];
        $this->userModel->join = 'inner join subjects s on s.class_id = u.class_id';
        if(isset($data['student_id'])){
            $condition = ['user_id'=>$data['student_id']];
        }

        if(isset($data['search'])){
            $pattern['subject_name'] = $data['search'];
        }

        if(isStudent()){
            if(getUserId() != $data['student_id']){
                setFlashMessage('error','You do not have permission to view subjects assigned to other students');
                redirect('/grade/supject?student_id='.getUserId());
                exit;
            }
        }

        if(isTeacher()){
            if(getUserId() != $data['teacher_id']){
                setFlashMessage('error','You do not have permission to view subjects assigned to other teachers');
                redirect('/grade/supject?teacher_id='.getUserId());
                exit;
            }

            $this->userModel->join = 'inner join subjects s on s.teacher_id = u.user_id';
            $condition = ['user_id'=>$data['teacher_id']];
        }

        $pageSum = $this->userModel->pages($condition,$rowPerPage,$pattern);
        $subjectsData = $this->userModel->pagination($condition,$rowPerPage,$offset,$pattern,$data);
// dd($subjectsData);
        // if(!$subjectsData){
        //     setFlashMessage('error','Student dont exist');
        //     redirect('/grade');
        //     exit;
        // }

        if(isset($data['student_id'])){
            $averageGrade = $this->gradeAverageCalculate($data['student_id']);
            $data['averageGrade'] = $averageGrade;
        }
        return view('grade/grade_subjects',['pages'=>$pageSum,'subjectsData'=>$subjectsData,'data'=>$data]);
    }

    public function add(){
        $data = $this->request->getBody();
        $this->gradeModel->join = 'inner join subjects s on g.subject_id = s.subject_id';
        $this->subjectModel->join = 'inner join classes c on c.class_id = s.class_id
        inner join users u on s.teacher_id = u.user_id';
        $gradeCondition = isset($data['subject_id']) ? ['student_id'=>$data['student_id'],'s.subject_id'=>$data['subject_id']] : [];
        $subjectCondition = isset($data['subject_id']) ? ['s.subject_id'=>$data['subject_id']] : [];

        if(isTeacher()){
            $teacherSubjectsId = $this->subjectModel->teacherSubjectsId(getUserId());

            if(!in_array($data['subject_id'],$teacherSubjectsId)){
                setFlashMessage('error','You do not have permission to add grades at subjects who are not assigned to you');
                redirect('/grade/supject?teacher_id='.getUserId());
                exit;
            }

            if(getUserId() != $data['teacher_id']){
                setFlashMessage('error','You do not have permission to add grades for other teachers');
                redirect('/grade/supject?teacher_id='.getUserId());
                exit;
            }   

            $teacherStudentsId = $this->subjectModel->teacherStudentsId(getUserId(),$data['subject_id']);

            if(!in_array($data['student_id'],$teacherStudentsId)){
                setFlashMessage('error','You do not have permission to grade students who are not assigned to you or arent in this class');
                redirect('/grade/supject?teacher_id='.getUserId());
                exit;
            }
        }

        if(isStudent()){
            if(getUserId() != $data['student_id']){
                setFlashMessage('error','You do not have permission to view grades assigned to other students');
                redirect('/grade/supject?student_id='.getUserId());
                exit;
            }

            $studentSubjects = $this->subjectModel->studentSubjectsId(getUserId());

            if(!in_array($data['subject_id'],$studentSubjects)){
                setFlashMessage('error','You do not have permission to view grades assigned to other subjects');
                redirect('/grade/supject?student_id='.getUserId());
                exit;
            }
        }

        $gradeData = $this->gradeModel->getData($gradeCondition,[],[],false);
        $subjectData = $this->subjectModel->getData($subjectCondition,[],[],false);

        return view('grade/grade_add',['gradeData'=>$gradeData,'subjectData'=>$subjectData,'data'=>$data]);
    }

    public function insert(){

        $data = $this->request->getBody();
        $getRules = $this->gradeModel->gradesRule();
        $this->subjectModel->join = 'inner join classes c on c.class_id = s.class_id
        inner join users u on s.teacher_id = u.user_id';
        $studentId = $data['student_id'];

        if($this->validation->validate($data,$getRules)){
            unset($data['student_id']);
            $data['student_id'] = $studentId;

            if($data['grade_id'] == ""){
                unset($data['grade_id']);

                $grade = $this->gradeCalculate($data['assigment_grade'],$data['midterm_exam_grade'],$data['final_exam_grade']);
                $data['grade'] = $grade;

                $this->gradeModel->insertData($data);
                setFlashMessage('success','Grade inserted successfully');
                if(isTeacher()){
                    redirect('/grade/supject?teacher_id='.getUserId());
                    exit;
                }
                redirect('/grade/supject?student_id='.$studentId);
                exit;
            }

            $grade = $this->gradeCalculate($data['assigment_grade'],$data['midterm_exam_grade'],$data['final_exam_grade']);
            $data['grade'] = $grade;

            $this->gradeModel->updateDataById($data['grade_id'],$data);

            if(isTeacher()){
                setFlashMessage('success','Grade updated successfully');
                redirect('/grade?subject_id='.$data['subject_id']);
                exit;
            }

            setFlashMessage('success','Grade updated successfully');
            redirect('/grade/supject?student_id='.$studentId);
            exit;
        }
        
        $gradeData = $this->gradeModel->getData(['student_id'=>$data['student_id'],'subject_id'=>$data['subject_id']]);
        $subjectData = $this->subjectModel->getData(['subject_id'=>$data['subject_id']],[],[],false);

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

