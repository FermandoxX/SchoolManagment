<main id="main" class="main">

<div class="pagetitle">
  <h1>Profile</h1>
</div><!-- End Page Title -->

<section class="section profile">
  <div class="row">
    <div class="col-xl-4">

      <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
          <img src="/../image/<?php echo $params['classData']->class_image ?>" alt="Profile" class="w-100">
          <h2><?php echo $params['classData']->class_name ?></h2>
        </div>
      </div>

    </div>

    <div class="col-xl-8">

      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">
            <li class="nav-item">
              <a class="nav-link active">Edit Class</a>
            </li>
          </ul>

            <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

              <!-- Profile Edit Form -->
              <form action="/class/update" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                  <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                  <div class="col-md-8 col-lg-9">
                    <div class="pt-2"> 

                      <label type="submit" for="imageProfile" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload text-white"></i></label>
                      <input class="hidden_input <?php echo isset($params['validation']) && $params['validation']->hasError('image') ? ' is-invalid' : ' ';  ?>" type="file" name="image" id="imageProfile" style="display:none;">
                      <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('image') : ' '?></div>

                    </div>
                  </div>
                </div>
                    <div class="row mb-3">
                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Class Name</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="class_name" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('class_name') ? ' is-invalid' : ' ';  ?>" id="Phone" value="<?= $params['classData']->class_name ?>">
                          <input name="classId" type="text" class="form-control" id="class_id" value="<?= $params['classData']->class_id ?>" style='display:none'>
                          <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('class_name') : ' '?></div>
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

