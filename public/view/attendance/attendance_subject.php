
<main id="main" class="main">
  
    <section class="section">

      <div class="row">
        <div class="col-lg-12" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">

          <div class="card w-100">
            <div class="card-body">
              <div class="d-flex">
                <h3 class="mt-3 mr-5 card-title col-7">Attendance</h3>
                <?php if(isTeacher()): ?>
                    <a class="createButton btn btn-primary text-white mt-4 col-2" href=<?php echo "/teacher/attendance/remove?subject_id=".$data['subject_id']?>  style="height:40px; display: flex; justify-content: center; align-items: center; margin-left: 50px;">Delete Attendance</a>
                    <a class="createButton btn btn-primary text-white mt-4 col-2" href=<?php echo "/teacher/attendance/add?subject_id=".$data['subject_id']?>  style="height:40px; display: flex; justify-content: center; align-items: center; margin-left: 50px;">Take Attendance</a>
                <?php endif; ?>

              </div>
            </div>
          </div>

          <div class="container mb-5 w-100">
            <div class="row w-100">
              <div class="col-md-8 w-100">
                <form class="d-flex gap-5" method="post" action=<?php echo isStudent() ? "/student/attendance/show?subject_id=".$data['subject_id'] : "/attendance/show?subject_id=".$data['subject_id'] ?>>
                    <div class="form-floating w-25">
                        <select name='year' class="form-select <?php echo isset($params['validation']) && $params['validation']->hasError('year') ? ' is-invalid' : ' ';  ?>" id="floatingSelect">
                            <option selected=""></option>
                            <?php for($i = 0; $i < 3; $i++): ?>
                                <option value=<?=$year + $i?>><?=$year + $i?></option>
                            <?php endfor; ?>
                        </select>
                        <label for="floatingSelect">Year</label>
                        <div class="invalid-feedback">
                            <?php echo isset($params['validation']) ? $params['validation']->getFirstError('year') : ' '?>
                        </div>
                    </div>

                    <div class="form-floating w-25">
                        <select name='month' class="form-select <?php echo isset($params['validation']) && $params['validation']->hasError('month') ? ' is-invalid' : ' ';  ?>" id="floatingSelect">
                            <option selected=""></option>
                            <?php foreach($months as $month): ?>
                                <option value=<?=$month?>><?=$month?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="floatingSelect">Month</label>
                        <div class="invalid-feedback">
                            <?php echo isset($params['validation']) ? $params['validation']->getFirstError('month') : ' '?>
                        </div>
                    </div>

                    <?php if(isAdmin() || isTeacher()): ?>
                    <div class="form-floating w-25">
                        <select name='student_id' class="form-select" id="floatingSelect">
                            <option selected=""></option>
                            <?php foreach($studentsData as $studentData): ?>
                                <option value=<?=$studentData->user_id?>><?=$studentData->name?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="floatingSelect">Student</label>
                    </div>
                    <?php endif; ?>
                  
                   <button class="btn btn-primary h-50 mt-2">Filter</button>
                </form>   

                <?php if(isset($attendancesStudent)): ?>
                    <table class="table table-bordered mt-5">
                        <thead>
                            <tr>
                                <th scope="col">Students</th>
                                <?php foreach($days as $day): ?>
                                    <th scope="col"><?=$day?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($attendancesStudent as $key => $values):?>
                                <tr>
                                    <th scope="row" style="width: 88px;"><?=$key?></th>
                                    <?php foreach($days as $day): ?>
                                        <?php $present = false;?>

                                        <?php if(in_array((int)$day,$values)): ?>
                                            <?php $present = true;?>
                                        <?php endif; ?>
                                            
                                          <td><?= $present ? '<i class="bi bi-bookmark-x-fill text-danger"></i>' : '' ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif;?>

              </div>        
            </div>
          </div>
      </div>
    </section>

</html>