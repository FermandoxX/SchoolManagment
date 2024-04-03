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
              <a class="nav-link active" href="/user">Overview</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/user/update/profile">Edit Profile</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/user/update/password">Change Password</a>
            </li>

          </ul>
          <div class="tab-content pt-2">

            <div class="tab-pane fade show active profile-overview" id="profile-overview">
              <h5 class="card-title">Profile Details</h5>

              <div class="row">
                <div class="col-lg-3 col-md-4 label ">Full Name</div>
                <div class="col-lg-9 col-md-8"><?php echo getName().' '.getSurename()?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Role</div>
                <div class="col-lg-9 col-md-8"><?php echo ucfirst(getRole()) ?></div>
              </div>


              <div class="row">
                <div class="col-lg-3 col-md-4 label">Address</div>
                <div class="col-lg-9 col-md-8"><?php echo getAddress()?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Phone Number</div>
                <div class="col-lg-9 col-md-8"><?php echo getPhoneNumber()?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Email</div>
                <div class="col-lg-9 col-md-8"><?php echo getEmail()?></div>
              </div>

            </div>

          </div><!-- End Bordered Tabs -->

        </div>
      </div>

    </div>
  </div>
</section>

</main>

