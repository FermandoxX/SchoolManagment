<?php
namespace App\Controller;

use App\Model\ClassModel;
use App\Model\GradeModel;
use App\Model\SubjectModel;
use App\Model\UserModel;
use Core\Request;
use Core\Response;
use Core\Validation;

class Subject {

    public Request $request;
    public Response $response;
    public Validation $validation;
    public SubjectModel $subjectModel;
    public ClassModel $classModel;
    public UserModel $userModel;
    public GradeModel $gradeModel;

    public function __construct(Request $request,Response $response,Validation $validation,SubjectModel $subjectModel,ClassModel $classModel,UserModel $userModel,GradeModel $gradeModel)
    {
        $this->request = $request;
        $this->response = $response;
        $this->validation = $validation;
        $this->subjectModel = $subjectModel;
        $this->classModel = $classModel;
        $this->userModel = $userModel;
        $this->gradeModel = $gradeModel;
    }

    public function index(){
        
        $data = $this->request->getBody();
        $rowPerPage = 3;
        $offset = 0;
        $pattern = [];
        $condition = [];
        $this->subjectModel->join = 'left join classes c on c.class_id = s.class_id
        left join users u on s.teacher_id = u.user_id';

        if(isset($data['search'])){
            $pattern['subject_name'] = $data['search'];
        }

        if(isStudent()){
            $condition['s.class_id'] = getUserData('class_id');
        }

        $pageSum = $this->subjectModel->pages($condition,$rowPerPage,$pattern);
        $subjectData = $this->subjectModel->pagination($condition,$rowPerPage,$offset,$pattern,$data);

        return view('subject/subject',['pages'=>$pageSum,'subjectsData'=>$subjectData, 'data'=>$data]);
    }

    public function add(){
        
        $classesData = $this->classModel->getData();      
        $teachersData = $this->userModel->getData(['role_name'=>'teacher']);

        return view('subject/subject_create',['classesData'=>$classesData,'teachersData'=>$teachersData]);
    }

    public function edit(){
        
        $data = $this->request->getBody();
        $query = 'left join classes c on c.class_id = s.class_id
        left join users u on s.teacher_id = u.user_id';

        $subjectData = $this->subjectModel->getData(['subject_id'=>$data['id']],[],[],false,$query);
        $teachersData = $this->userModel->getData(['role_name'=>'teacher']);

        if(!$subjectData){
            setFlashMessage('error','Subject dont exist');
            redirect('/subject');
            exit;
        }

        return view('subject/subject_update',['subjectData'=>$subjectData,'teachersData'=>$teachersData]);
    }


    public function create(){
        $data = $this->request->getBody();
        $getRules = $this->subjectModel->subjectRules();
        $image = $data['subject_image'];

        if($this->validation->validate($data,$getRules)){
            unset($data['subject_image']);
            if(isset($image['name']) && $image['name'] != ""){
                moveUploadedImage($image);
                $data['subject_image'] = $image['name'];
            }

            $this->subjectModel->insertData($data);    

            redirect('/subject');
            setFlashMessage('success','Subject created successfully');
            exit;
        }

        $classesData = $this->classModel->getData();           
        $teachersData = $this->userModel->getData(['role_name'=>'teacher']);

        return view('subject/subject_create',['validation'=>$this->validation,'classesData'=>$classesData,'teachersData'=>$teachersData]);
    }

    public function update(){
        $subjectData = $this->request->getBody();
        $getRules = $this->subjectModel->subjectRulesUpdate();
        $image = $subjectData['subject_image'];
        $subjectId = $subjectData['subject_id'];
        $query = 'left join classes c on c.class_id = s.class_id
        left join users u on s.teacher_id = u.user_id';

        if($this->validation->validate($subjectData,$getRules)){
            unset($subjectData['subject_image']);
            if(isset($image['name']) && $image['name'] != ""){
                moveUploadedImage($image);
                $subjectData['subject_image'] = $image['name'];
            }
            
            if($subjectData['class_id'] == ""){
                unset($subjectData['class_id']);
            }

            if($subjectData['teacher_id'] == ""){
                unset($subjectData['teacher_id']);
            }

            $this->subjectModel->updateDataById($subjectId,$subjectData);
            
            setFlashMessage('success','Subject updated successfully');
            redirect('/subject');
            exit;
        }

        $classesData = $this->classModel->getData();           
        $subjectData = $this->subjectModel->getData(['subject_id'=>$subjectData['subject_id']],[],[],false,$query);

        return view('subject/subject_update',['validation'=>$this->validation,'classesData'=>$classesData,'subjectData'=>$subjectData]);
    }

    public function delete(){
        $data = $this->request->getBody();
        $checkingSubject = $this->subjectModel->getDataById($data['id']);

        if(!$checkingSubject){
            setFlashMessage('error','Subject doesnt exist');
            redirect('/subject');
            exit;
        }

        $this->subjectModel->deleteData($data['id']);
        setFlashMessage('success','Subject deleted successfully');
        redirect('/subject');
        exit;
    }


}


?>