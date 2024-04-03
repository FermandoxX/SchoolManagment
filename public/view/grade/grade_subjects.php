<main id="main" class="main">
  
    <section class="section">

      <div class="row">
        <div class="col-lg-12" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">

          <div class="card w-100">
            <div class="card-body">
              <div class="d-flex">
                <h3 class="mt-3 mr-5 card-title col-9">Subject</h3>
                <?php if(isAdmin() || isStudent()): ?>
                <h3 class="mt-3 mr-5 card-title col-9">Average Grade: <?php echo isset($data['averageGrade']) ? $data['averageGrade'] : 0 ?></h3>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="container mb-5 d-flex justify-content-end align-items-center w-100">
            <div class="row height d-flex justify-content-end align-items-center w-75">
              <div class="col-md-8 w-50">
                <form class="search" method="get" action="/subject">
                   <i class="fa fa-search"></i>
                   <input type="text" name="search" class="form-control" placeholder="Search Now">
                   <button class="btn btn-primary">Search</button>
                </form>         
              </div>        
            </div>
          </div>

          <div class="d-flex row gap-5 justify-content-center align-items-center w-100">
            <?php foreach($subjectsData as $subjectData): ?>
                <a class="col-xl-4" style=" width:325px; height:180px" href=<?php echo isTeacher() ? "/grade?subject_id=$subjectData->subject_id" : "/grade/supject/add?student_id=$subjectData->user_id&subject_id=$subjectData->subject_id"?>>
                  <div class="card w-100 h-100 ">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center mt-2">
                      <img src="/../image/<?php echo $subjectData->subject_image ?? 'Sad photo icon.jpg'; ?>" alt="Profile" class="w-100 rounded"  height="70" style="object-fit:cover">
                      <h3 class="mt-3"><?php echo "Name: "; echo strlen($subjectData->subject_name) < 12 ? ucfirst($subjectData->subject_name) : substr($subjectData->subject_name,0,9).'...' ?></h3>
                    </div>
                  </div>
                </a>
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