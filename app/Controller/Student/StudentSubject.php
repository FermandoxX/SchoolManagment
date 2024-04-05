<?php
namespace App\Controller\Student;

use App\Model\SubjectModel;
use Core\Request;

class StudentSubject {

    public Request $request;
    public SubjectModel $subjectModel;

    public function __construct(Request $request,SubjectModel $subjectModel)
    {
        $this->request = $request;
        $this->subjectModel = $subjectModel;
    }

    public function index(){
        
        $data = $this->request->getBody();
        $pattern = [];
        $condition['s.class_id'] = getUserData('class_id');
        $this->subjectModel->join = 'left join classes c on c.class_id = s.class_id
        left join users u on s.teacher_id = u.user_id';

        if(isset($data['search'])){
            $pattern['subject_name'] = $data['search'];
        }

        $pageSum = $this->subjectModel->pages($condition,$pattern);
        $subjectData = $this->subjectModel->pagination($condition,$pattern,$data);

        return view('subject/subject',['pages'=>$pageSum,'subjectsData'=>$subjectData, 'data'=>$data]);
    }
}


?>