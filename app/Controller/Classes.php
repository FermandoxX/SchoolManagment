<?php 

namespace App\Controller;

use App\Model\ClassModel;
use App\Model\SubjectModel;
use App\Model\UserModel;
use Core\Request;
use Core\Response;
use Core\Validation;

class Classes {

    public Request $request;
    public Response $response;
    public Validation $validation;
    public ClassModel $classModel;
    public SubjectModel $subjectModel;
    public UserModel $userModel;


    public function __construct(Request $request,Response $response,Validation $validation,ClassModel $classModel,SubjectModel $subjectModel,UserModel $userModel)
    {
        $this->request = $request;
        $this->response = $response;
        $this->validation = $validation;
        $this->classModel = $classModel;
        $this->subjectModel = $subjectModel;
        $this->subjectModel = $subjectModel;
        $this->userModel = $userModel;
    }

    public function index(){
        $data = $this->request->getBody();
        $pattern = [];

        if(isset($data['search'])){
            $pattern['class_name'] = $data['search'];
        }

        $pageSum = $this->classModel->pages([],$pattern);
        $classesData = $this->classModel->pagination([],$data,$pattern);

        return view('class/class',['pages'=>$pageSum,'classesData'=>$classesData,'data'=>$data]);
    }

    public function add(){
        return view('class/class_create');
    }

    public function edit(){
        $data = $this->request->getBody();
        $classData = $this->classModel->getDataById($data['id']);

        if(!$classData){
            setFlashMessage('error','Class dont exist');
            redirect('/class');
            exit;
        }

        return view('class/class_update',['classData'=>$classData]);
    }

    public function create(){
        $data = $this->request->getBody();
        $rules = $this->classModel->classRules();
        $image = $data['class_image'];

        if($this->validation->validate($data,$rules,$this->classModel)){
            unset($data['class_image']);
            if(isset($image['name']) && $image['name'] != ""){
                moveUploadedImage($image);
                $data['class_image'] = $image['name'];
            }

            $this->classModel->insertData($data);
            setFlashMessage('success','Class created successfully');
            redirect('/class');
            exit;
        }

        return view('class/class_create',['validation'=>$this->validation]);
    }

    public function update(){
        $data = $this->request->getBody();
        $rules = $this->classModel->classRules();
        $image = $data['image'];
        $classId = $data['classId'];

        if($this->validation->validate($data,$rules,$this->classModel,$classId)){
            unset($data['image']);
            unset($data['classId']);

            if(isset($image['name']) && $image['name'] != ""){
                moveUploadedImage($image);
                $data['class_image'] = $image['name'];
            }

            $this->classModel->updateDataById($classId,$data);
            setFlashMessage('success','Class updated successfully');
            redirect('/class');
            exit;
        }
        
        $classData = $this->classModel->getDataById($classId);

        return view('class/class_update',['validation'=>$this->validation,'classData'=>$classData]);
    }

    public function delete(){
        $data = $this->request->getBody();
        $checkingClass = $this->classModel->getDataById($data['id']);

        if(!$checkingClass){
            setFlashMessage('error','Class dont exist');
            redirect('/class');
            exit;
        }

        $this->subjectModel->updateData(['class_id'=>$data['id']],['class_id'=>null]);
        $this->userModel->updateData(['class_id'=>$data['id']],['class_id'=>null]);
        $this->classModel->deleteData($data['id']);
        setFlashMessage('success','Class deleted successfully');
        redirect('/class');
        exit;
    }

}

?>