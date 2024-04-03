<main id="main" class="main">

<div class="pagetitle">
  <h1>Profile</h1>
</div><!-- End Page Title -->

<section class="section profile">
  <div class="row">

      <div class="col-xl-4">
        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <img src="/../image/<?php echo $subjectData[0]->subject_image ?? "" ?>" alt="Profile" class="w-100">
            <h2><?php echo $subjectData[0]->subject_name ?? "" ?></h2>
            <h6><?php echo isset($subjectData[0]->class_name) ? "Class: ". $subjectData[0]->class_name : "" ?></h6>
            <h6><?php echo isset($subjectData[0]->name) ? "Teacher: ". $subjectData[0]->name." ".$subjectData[0]->surename : ""?></h6>
            <h6><?php echo  isset($gradeData[0]->grade) ? "Grade: ".$gradeData[0]->grade : ""  ?></h6>
          </div>
        </div>

      </div>

    <div class="col-xl-8">

      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">
            <li class="nav-item">
              <a class="nav-link active">Grade</a>
            </li>
          </ul>

            <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

              <!-- Profile Edit Form -->
              <form action="/grade/insert<?php echo isset($data['student_id'],$data['subject_id']) ? '?student_id='.$data['student_id'].'&subject_id='.$data['subject_id'] : '?student_id='.$data['student_id'].'&subject_id='.$subjectData[0]->subject_id ?>" method="post" enctype="multipart/form-data">

                    <div class="row mb-3">
                        <label class="col-md-4 col-lg-3 col-form-label">Assigment</label>
                        <div class="col-md-8 col-lg-9">
                          <?php if(isStudent()): ?>
                          <input name="assigment_grade" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('assigment_grade') ? ' is-invalid' : ' ';  ?>" value="<?= isset($gradeData[0]->assigment_grade) ? $gradeData[0]->assigment_grade : '' ?>" disabled>
                          <?php else:?>
                          <input name="assigment_grade" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('assigment_grade') ? ' is-invalid' : ' ';  ?>" value="<?= isset($gradeData[0]->assigment_grade) ? $gradeData[0]->assigment_grade : '' ?>">
                          <?php endif; ?>
                          <input name="grade_id" type="text" class="form-control" id="grade_id" style='display:none' value=<?= isset($gradeData[0]->grade_id) ? $gradeData[0]->grade_id : '' ?>>
                          <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('assigment_grade') : ' '?></div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label class="col-md-4 col-lg-3 col-form-label">Midterm Exam</label>
                            <div class="col-md-8 col-lg-9">
                              <?php if(isStudent()): ?>
                                <input name="midterm_exam_grade" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('midterm_exam_grade') ? ' is-invalid' : ' ';  ?>" value="<?= isset($gradeData[0]->midterm_exam_grade) ? $gradeData[0]->midterm_exam_grade : '' ?>" disabled>
                              <?php else:?>
                                <input name="midterm_exam_grade" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('midterm_exam_grade') ? ' is-invalid' : ' ';  ?>" value="<?= isset($gradeData[0]->midterm_exam_grade) ? $gradeData[0]->midterm_exam_grade : '' ?>">                            
                              <?php endif; ?>
                              <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('midterm_exam_grade') : ' '?></div>
                            </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-lg-3 col-form-label">Final Exam</label>
                            <div class="col-md-8 col-lg-9">
                              <?php if(isStudent()): ?>
                                <input name="final_exam_grade" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('final_exam_grade') ? ' is-invalid' : ' ';  ?>" value="<?= isset($gradeData[0]->final_exam_grade) ? $gradeData[0]->final_exam_grade : ''?>" disabled>
                              <?php else:?>
                                <input name="final_exam_grade" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('final_exam_grade') ? ' is-invalid' : ' ';  ?>" value="<?= isset($gradeData[0]->final_exam_grade) ? $gradeData[0]->final_exam_grade : '' ?>">                           
                              <?php endif; ?>
                              <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('final_exam_grade') : ' '?></div>
                            </div>
                    </div>

                    
                <?php if(isTeacher() || isAdmin()):?>                
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
                <?php endif; ?>
              </form><!-- End Profile Edit Form -->
            </div>
          </div><!-- End Bordered Tabs -->
        </div>
      </div>

    </div>
  </div>
</section>

</main>

