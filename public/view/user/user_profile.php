<main id="main" class="main">

<div class="pagetitle">
  <h1>Profile</h1>
</div><!-- End Page Title -->

<section class="section profile">
  <div class="row">
    <div class="col-xl-4">

      <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

          <img src="/../image/<?php echo getImage(); ?>" alt="Profile" class="rounded-circle">
          <h2><?php echo getName().' '.getSurename()?></h2>
          <h3><?php echo ucfirst(getRole()) ?></h3>
        </div>
      </div>

    </div>

    <div class="col-xl-8">

      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">

            <li class="nav-item">
              <a class="nav-link" href="/user">Overview</a>
            </li>

            <li class="nav-item">
              <a class="nav-link active" href="/user/update/profile">Edit Profile</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/user/update/password">Change Password</a>
            </li>

          </ul>

            <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

              <!-- Profile Edit Form -->
              <form action="/user/update/profile" method="post" enctype="multipart/form-data">
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
                    <input name="name" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('name') ? ' is-invalid' : ' ';  ?>" id="Name" value=<?php echo getName()?> >
                    <input name="userId" type="text" class="form-control" id="userId" style="display: none;" value=<?php echo getUserId()?> >
                    <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('name') : ' '?></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Surename" class="col-md-4 col-lg-3 col-form-label">Surename</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="surename" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('surename') ? ' is-invalid' : ' ';  ?>" id="Surename" value=<?php echo getSurename()?> >
                    <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('surename') : ' '?></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="address" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('address') ? ' is-invalid' : ' ';  ?>" id="Address" value=<?php echo getAddress()?> >
                    <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('address') : ' '?></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone number</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="phone_number" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('phone_number') ? ' is-invalid' : ' ';  ?>" id="Phone" value=<?php echo getPhoneNumber()?> >
                    <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('phone_number') : ' '?></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="email" type="email" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('email') ? ' is-invalid' : ' ';  ?>" id="Email" value=<?php echo getEmail()?> >
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

