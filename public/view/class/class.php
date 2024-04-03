<main id="main" class="main">
  
    <section class="section">

      <div class="row">
        <div class="col-lg-12" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">

          <div class="card w-100">
            <div class="card-body">
              <div class="d-flex">
                <h3 class="mt-3 mr-5 card-title col-9">Class</h3>
                <a class="createButton btn btn-primary text-white mt-4 ml-5 col-2" href="/class/create"  style="height:40px; display: flex; justify-content: center; align-items: center; margin-left: 50px;"><i class="bi bi-plus" style="font-size: 21px;"></i>Create Class</a>
              </div>
            </div>
          </div>

          <div class="container mb-5 d-flex justify-content-end align-items-center w-100">
            <div class="row height d-flex justify-content-end align-items-center w-75">
              <div class="col-md-8 w-50">
                <form class="search" method="get" action="/class">
                   <i class="fa fa-search"></i>
                   <input type="text" name="search" class="form-control" placeholder="Search Now">
                   <button class="btn btn-primary">Search</button>
                </form>         
              </div>        
            </div>
          </div>

          <div class="d-flex row gap-5 justify-content-center align-items-center w-100"> 
            <?php foreach($params['classesData'] as $classData): ?>
                <div class="col-xl-4" style=" width:350px; height:342px">
                  <div class="card w-100 h-75">
                    <div class="card-body profile-card pt-4 d-flex flex-column justify-content-center align-items-center">
                      <img src="/../image/<?php echo $classData->class_image?>" alt="Profile" class="w-100 rounded" height="70" style="object-fit:cover">
                      
                      <?php if(strlen($classData->class_name) > 20): ?>
                        <h3 class="mt-3"><?php echo substr($classData->class_name,0,17).'...'?></h3>
                      <?php else: ?>
                        <h3 class="mt-3"><?php echo $classData->class_name ?></h3>
                      <?php endif; ?>

                      <div class="d-flex gap-2 mt-3">
                        <a class="editDeleteButton mb-3 mr-3 bg-success text-white" href="/class/update?id=<?= $classData->class_id ?>">Edit</a>
                        <a class="editDeleteButton mb-3 mr-3 bg-danger text-white"  href="/class/delete?id=<?= $classData->class_id ?>">Delete</a>
                     </div>
                    </div>
                  </div>
                </div>
            <?php endforeach; ?>
          </div>
          <?php
                $currentPage = isset($data['pageNr']) ? $data['pageNr'] : 1 ;
                unset($data['pageNr']);
                $url = false;
                if (count($data) > 0) {
                  $url =  '&' . http_build_query($data);
                }
          ?>
          <div class="mt-5">
                  <nav class="pagination-outer" aria-label="Page navigation">
                    <ul class="pagination">
                      <?php if($currentPage > 1): ?>
                        <li class="page-item">
                          <a href="?pageNr=<?= $currentPage - 1?><?= $url ?? ''?>" class="page-link" aria-label="Previous">
                            <span aria-hidden="true">Prev</span>
                          </a>
                        </li>  
                      <?php endif; ?>  
                      
                      <?php for($i = 1;$i <= $params['pages'];$i++): ?>
                          <li class="page-item"><a class="page-link" href="?pageNr=<?=$i?><?= $url ?? ''?>"><?= $i ?></a></li>
                      <?php endfor; ?>
                      
                      <?php if($params['pages'] > $currentPage): ?>
                        <li class="page-item">
                          <a href="?pageNr=<?=$currentPage + 1?><?= $url ?? ''?>" class="page-link" aria-label="Previous">
                            <span aria-hidden="true">Next</span>
                          </a>
                        </li>  
                      <?php endif; ?>        
                    </ul>
                  </nav>
                </div>
      </div>
    </section>

</html>