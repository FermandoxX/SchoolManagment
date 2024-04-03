<main id="main" class="main">

<div class="pagetitle">
  <h1>Profile</h1>
</div><!-- End Page Title -->

<section class="section profile">
  <div class="row">
    <div class="col-xl-4">

      <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

          <img src="/../image/<?php echo $teacherData->image ?>" alt="Profile" class="rounded-circle" width="125" height="125" style="object-fit:cover">
          <h2><?php echo $teacherData->name.' '.$teacherData->surename?></h2>
          <h3><?php echo ucfirst($teacherData->role_name) ?></h3>
      
        </div>
      </div>

    </div>

    <div class="col-xl-8">

      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">

            <li class="nav-item">
              <a class="nav-link active" href="/teacher/profile?id=<?= $teacherData->user_id ?>">Edit Profile</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/teacher/password?id=<?= $teacherData->user_id ?>">Change Password</a>
            </li>

          </ul>

            <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

              <!-- Profile Edit Form -->
              <form action="/teacher/profile/update" method="post" enctype="multipart/form-data">
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
                  <label for="Name" class="col-md-4 col-lg-3 col-form-label">Name</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="name" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('name') ? ' is-invalid' : ' ';  ?>" id="Name" value="<?php echo $teacherData->name?>" >
                    <input name="userId" type="text" class="form-control" id="userId" value="<?php echo $teacherData->user_id?>" style="display:none">
                    <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('name') : ' '?></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Surename" class="col-md-4 col-lg-3 col-form-label">Surename</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="surename" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('surename') ? ' is-invalid' : ' ';  ?>" id="Surename" value="<?php echo $teacherData->surename?>" >
                    <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('surename') : ' '?></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="address" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('address') ? ' is-invalid' : ' ';  ?>" id="Address" value="<?php echo $teacherData->address?>" >
                    <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('address') : ' '?></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone number</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="phone_number" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('phone_number') ? ' is-invalid' : ' ';  ?>" id="Phone" value="<?php echo $teacherData->phone_number?>" >
                    <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('phone_number') : ' '?></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="email" type="email" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('email') ? ' is-invalid' : ' ';  ?>" id="Email" value="<?php echo $teacherData->email?>" >
                    <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('email') : ' '?></div>
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

