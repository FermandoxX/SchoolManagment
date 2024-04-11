<main id="main" class="main">

    <section class="section">

      <div class="row">
        <div class="col-lg-12" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">

          <div class="card w-100">
            <div class="card-body">
              <div class="d-flex">
                <h3 class="mt-3 mr-5 card-title col-9">Teacher</h3>
                <?php if(isAdmin()): ?>
                  <a class="createButton btn btn-primary text-white mt-4 ml-5 col-2" href="/teacher/create"  style="height:40px; display: flex; justify-content: center; align-items: center; margin-left: 50px;"><i class="bi bi-plus" style="font-size: 21px;"></i>Create Teacher</a>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="container mb-5 d-flex justify-content-end align-items-center w-100">
            <div class="row height d-flex justify-content-end align-items-center w-75">
              <div class="col-md-8 w-50">
                <form class="search" method="get" action=<?php echo isStudent() ? "/student/teacher" : "/teacher"?>>
                   <i class="fa fa-search"></i>
                   <input type="text" name="search" class="form-control" placeholder="Search Now">
                   <button class="btn btn-primary">Search</button>
                </form>         
              </div>        
            </div>
          </div>

          <div class="d-flex row gap-5 justify-content-center align-items-center w-100">
            <?php foreach($teachersData as $teacherData): ?>
                <div class="col-xl-4" style=" width:275px; height:310px">
                  <div class="card w-100 h-100">
                    <div class="card-body profile-card pt-4 d-flex flex-column justify-content-center align-items-center">
                      <img src="/../image/<?php echo $teacherData->image ?? 'Sad photo icon.jpg'; ?>" alt="Profile" class="rounded-circle w-50" width="112" height="112" style="object-fit:cover">
                      <h3><?php echo strlen($teacherData->name.' '.$teacherData->surename) < 15 ? $teacherData->name.' '.$teacherData->surename : substr($teacherData->name.' '.$teacherData->surename,0,12).'...' ?></h3>
                      <h6><?php echo "Email: "; echo strlen($teacherData->email) < 17 ? ucfirst($teacherData->email) : substr($teacherData->email,0,14).'...' ?></h6>
                      <h6><?php echo "Address: ". ucfirst($teacherData->address) ?></h6>
                      <?php if($teacherData->user_id != getUserId()): ?>
                      <div class="d-flex gap-2">
                        <?php if(isAdmin()): ?>
                          <a class="editDeleteButton mb-3 mr-3 bg-success text-white" href="teacher/profile?id=<?php echo $teacherData->user_id;?>">Edit</a>
                          <a class="editDeleteButton mb-3 mr-3 bg-danger text-white"  href="teacher/delete?id=<?php echo $teacherData->user_id;?>">Delete</a>
                        <?php endif; ?>
                      </div>
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
</div>
    </section>

</main>