<main id="main" class="main">

<div class="pagetitle">
  <h1>Create Class</h1>
</div>

<section class="section profile">
  <div class="row">
    <div class="col-xl-2">
  </div>

    <div class="col-xl-8">

      <div class="card">
        <div class="card-body pt-3">

            <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

              <!-- Profile Edit Form -->
              <form action="/class/create" method="post" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                    <div class="col-md-8 col-lg-9">
                      <div class="pt-2">
                          <label type="submit" for="imageProfile" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload text-white"></i></label>
                          <input class="hidden_input <?php echo isset($params['validation']) && $params['validation']->hasError('class_image') ? ' is-invalid' : ' ';  ?>" type="file" name="class_image" id="imageProfile" style="display:none;">
                          <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('class_image') : ' '?></div>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Class Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="class_name" type="text" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('class_name') ? ' is-invalid' : ' ';  ?>" id="Phone">
                        <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('class_name') : ' '?></div>
                      </div>
                    </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Save</button>
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

