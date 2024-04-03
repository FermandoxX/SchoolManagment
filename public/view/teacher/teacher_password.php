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
              <a class="nav-link" href="/teacher/profile?id=<?= $teacherData->user_id ?>">Edit Profile</a>
            </li>

            <li class="nav-item">
              <a class="nav-link active" href="/teacher/password?id=<?= $teacherData->user_id ?>">Change Password</a>
            </li>

          </ul>
          <div class="tab-content pt-2">

            <div class="tab-pane fade show active pt-3" id="profile-change-password">
              <!-- Change Password Form -->
              <form action="/teacher/password/update" method="post">

              <input name="userId" type="text" class="form-control" id="userId" value=<?php echo $teacherData->user_id?> style="display:none">

                <div class="row mb-3">
                  <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="password" type="password" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('password') ? ' is-invalid' : ' ';  ?>" id="password">
                    <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('password') : ''?></div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="newpassword" type="password" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('newpassword') ? ' is-invalid' : ' ';  ?>" id="newPassword">
                    <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('newpassword') : '' ?></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="renewpassword" type="password" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('renewpassword') ? ' is-invalid' : ' ';  ?>" id="renewPassword">
                    <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('renewpassword') : ''?></div>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
              </form><!-- End Change Password Form -->

            </div>

          </div><!-- End Bordered Tabs -->

        </div>
      </div>

    </div>
  </div>
</section>

</main>