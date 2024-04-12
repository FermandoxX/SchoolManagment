<main id="main" class="main">

    <section class="section">

      <div class="row">
        <div class="col-lg-12" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">

          <div class="card w-100">
            <div class="card-body">
              <div class="d-flex">
                <h3 class="mt-3 mr-5 card-title col-9">Student</h3>
                <?php if(isAdmin()): ?>
                  <a class="createButton btn btn-primary text-white mt-4 ml-5 col-2" href="/student/create"  style="height:40px; display: flex; justify-content: center; align-items: center; margin-left: 50px;"><i class="bi bi-plus" style="font-size: 21px;"></i>Create Student</a>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="container mb-5 d-flex justify-content-end align-items-center w-100">
            <div class="row height d-flex justify-content-end align-items-center w-75">
              <div class="col-md-8 w-50">
                <form class="search" method="get" action=<?php echo isAdmin() ? "/student" : "/teacher/student"?>>
                   <i class="fa fa-search"></i>
                   <input type="text" name="search" class="form-control" placeholder="Search Now">
                   <button class="btn btn-primary">Search</button>
                </form>         
              </div>        
            </div>
          </div>

          <div class="d-flex row gap-5 justify-content-center align-items-center w-100">
            <?php foreach($studentsData as $studentData): ?>
                <div class="col-xl-4" style=" width:275px; height:310px">
                  <div class="card w-100 h-100">
                    <div class="card-body profile-card pt-4 d-flex flex-column justify-content-center align-items-center">
                      <img src="/../image/<?php echo $studentData->image ?? 'Sad photo icon.jpg'; ?>" alt="Profile" class="rounded-circle w-50" width="112" height="112" style="object-fit:cover">
                      <h3><?php echo strlen($studentData->name.' '.$studentData->surename) < 15 ? $studentData->name.' '.$studentData->surename : substr($studentData->name.' '.$studentData->surename,0,12).'...' ?></h3>
                      <h6><?php echo "Email: "; echo strlen($studentData->email) < 20 ? ucfirst($studentData->email) : substr($studentData->email,0,17).'...' ?></h6>
                      <h6><?php echo "Class: "; echo strlen($studentData->class_name) < 20 ? ucfirst($studentData->class_name) : substr($studentData->class_name,0,17).'...' ?></h6>
                      <h6><?php echo "Address: ". $studentData->address ?></h6>
                      <?php if(isAdmin()): ?>
                      <?php if($studentData->user_id != getUserId()): ?>
                      <div class="d-flex gap-2">
                        <a class="editDeleteButton mb-3 mr-3 bg-success text-white" href="student/profile?id=<?php echo $studentData->user_id;?>">Edit</a>
                        <a class="editDeleteButton mb-3 mr-3 bg-danger text-white"  href="student/delete?id=<?php echo $studentData->user_id;?>">Delete</a>
                      </div>
                      <?php endif; ?> 
                      <?php endif; ?> 
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
              <?php if($params['pages']): ?>
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
              <?php endif; ?>
            </div>
  </div>
    </section>

</main>