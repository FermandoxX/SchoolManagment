
<main id="main" class="main">
  
    <section class="section">

      <div class="row">
        <div class="col-lg-12" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">

          <div class="card w-100">
            <div class="card-body">
              <div class="d-flex">
                <h3 class="mt-3 mr-5 card-title col-9">Attendance</h3>
              </div>
            </div>
          </div>

          <div class="container mb-5 d-flex justify-content-end align-items-center w-100">
            <div class="row height d-flex justify-content-end align-items-center w-75">
              <div class="col-md-8 w-50">
                <form class="search" method="get" action="/teacher/attendance/remove?subject_id=<?=$data['subject_id']?>">
                   <i class="fa fa-search"></i>
                   <input type="text" name="search" class="form-control" placeholder="Search Now">
                   <input type="text" name="subject_id" class="form-control" placeholder="Search Now" value=<?=$data['subject_id']?> style="display: none;">
                   <button class="btn btn-primary">Search</button>
                </form>         
              </div>        
            </div>
          </div>

          <div class="container mb-5 w-100">
            <div class="row w-100">
              <div class="col-md-8 w-100">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="text-center" scope="col">Name Surename</th>
                    <th class="text-center" scope="col">Date</th>
                    <th class="text-center" scope="col">Remove</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach($attendancesData as $attendanceData): ?>
                        <tr>
                          <td class="text-center"><?=$attendanceData->name.' '.$attendanceData->surename?></td>
                          <td class="text-center"><?=$attendanceData->attendance_date?></td>
                          <td class="text-center"><a href=<?php echo isAdmin() ? "/attendance/delete?attendance_id=".$attendanceData->attendance_id."&subject_id=".$attendanceData->subject_id : "/teacher/attendance/delete?attendance_id=".$attendanceData->attendance_id."&subject_id=".$attendanceData->subject_id ?>><i class="bi bi-trash3-fill text-danger"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
              </table>
              <?php
                $currentPage = isset($data['pageNr']) ? $data['pageNr'] : 1 ;
                unset($data['pageNr']);
                $url = false;
                if (count($data) > 0) {
                  $url =  '&' . http_build_query($data);
                }
          ?>
          <div class="mt-5 d-flex justify-content-center">
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
            </div>
          </div>
      </div>
    </section>

</html>