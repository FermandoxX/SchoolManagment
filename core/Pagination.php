<?php
namespace Core;

class Pagination {
    public $start = 0;
    public $rowsPerPage = 5;

    public Request $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function pages($tableName){
        $numberOfRows = getRowSum($tableName);
        $pages = ceil($numberOfRows/$this->rowsPerPage);

        return $pages;
    }

    public function getDataFromPagination(){
        

        if(isset($_GET['pageNr'])){
            $page = $_GET['pageNr'] - 1;
            
            $this->start = $page * $this->rowsPerPage;
        }

        $data = limit($this->rowsPerPage,$this->start);
        return $data;
    }
}