<main id="main" class="main">

<div class="pagetitle">
  <h1>Profile</h1>
</div><!-- End Page Title -->

<section class="section profile">
  <div class="row">
    <div class="col-xl-4">

      <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
          <img src="/../image/<?php echo $subjectData[0]->subject_image ?>" alt="Profile" class="w-100">
          <h2><?php echo $subjectData[0]->subject_name ?></h2>
          <h6><?php echo "Class: ". $subjectData[0]->class_name ?></h6>
          <h6><?php echo "Teacher: ". $subjectData[0]->name." ".$subjectData[0]->surename ?></h6>

        </div>
      </div>

    </div>

    <div class="col-xl-8">

      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">
            <li class="nav-item">
              <a class="nav-link active">Edit Subject</a>
            </li>
          </ul>

            <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

              <!-- Profile Edit Form -->
              <form action="/subject/update" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                  <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                  <div class="col-md-8 col-lg-9">
                    <div class="pt-2"> 

                      <label type="submit" for="imageProfile" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload text-white"></i></label>
                      <input class="hidden_input <?php echo isset($params['validation']) && $params['validation']->hasError('image') ? ' is-invalid' : ' ';  ?>" type="file" name="subject_image" id="imageProfile" style="display:none;">
                      <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('image') : ' '?></div>

                    </div>
                  </div>
                </div>
                    <div class="row mb-3">
                        <label class="col-md-4 col-lg-3 col-form-label">Subject Name</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="subject_name" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('subject_name') ? ' is-invalid' : ' ';  ?>" value="<?= $subjectData[0]->subject_name ?>">
                          <input name="subject_id" type="text" class="form-control" id="subject_id" value=<?= $subjectData[0]->subject_id ?> style='display:none'>
                          <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('subject_name') : ' '?></div>
                        </div>
                    </div>
                
                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Teacher</label>
                      <div class="col-md-8 col-lg-9">
                          <select name='teacher_id' class="form-select <?php echo isset($params['validation']) && $params['validation']->hasError('teacher_id') ? ' is-invalid' : ' ';  ?>" id="floatingSelect">
                              <option selected=""></option>
                              <?php foreach($teachersData as $teacherData): ?>
                                  <option value=<?=$teacherData->user_id?>>
                                      <?=$teacherData->name." ".$teacherData->surename?>
                                  </option>
                                  <?php endforeach; ?>
                          </select>
                          <div class="invalid-feedback">
                              <?php echo isset($params['validation']) ? $params['validation']->getFirstError('teacher_id') : ' '?>
                          </div>
                      </div>
                    </div>

                    

                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
              </form><!-- End Profile Edit Form -->
            </div>
          </div><!-- End Bordered Tabs -->
        </div>
      </div>

    </div>
  </div>
</section>

</main>

