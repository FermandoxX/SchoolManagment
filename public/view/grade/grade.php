<main id="main" class="main">
  <section class="section">

      <div class="row">
        <div class="col-lg-12" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">

          <div class="card w-100">
            <div class="card-body">
              <div class="d-flex">
                <h3 class="mt-3 mr-5 card-title col-9">Grade</h3>
              </div>
            </div>
          </div>

          <div class="d-flex row gap-5 justify-content-center align-items-center w-100">
            <?php foreach($studentsData as $studentData): ?>
                <div class="col-xl-4" style=" width:275px; height:310px">
                  <div class="card w-100 h-100">
                    <div class="card-body profile-card pt-4 d-flex flex-column justify-content-center align-items-center">
                      <img src="/../image/<?php echo $studentData->image ?? 'Sad photo icon.jpg'; ?>" alt="Profile" class="rounded-circle w-50" width="112" height="112" style="object-fit:cover">
                      <h3><?php echo $studentData->name.' '.$studentData->surename?></h3>
                      <h6><?php echo "Class: "; echo strlen($studentData->class_name) < 17 ? ucfirst($studentData->class_name) : substr($studentData->class_name,0,14).'...' ?></h6>
                      <h6><?php echo "Email: "; echo strlen($studentData->email) < 17 ? ucfirst($studentData->email) : substr($studentData->email,0,14).'...' ?></h6>
                      <?php if($studentData->user_id != getUserId()): ?>
                      <div class="d-flex gap-2">
                        <a class="editDeleteButton mb-3 mr-3 bg-primary text-white" href=<?php echo isTeacher() ? "/teacher/grade/subject/add?student_id=$studentData->user_id&subject_id=".$data['subject_id'] : "/grade/subject/add?student_id=$studentData->user_id&subject_id=".$data['subject_id']?>><?php echo  isAdmin() ? "Watch Grade" : "Add Grade" ?></a>
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
