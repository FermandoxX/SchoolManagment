<main id="main" class="main">

<div class="pagetitle">
  <h1>Attendance</h1>
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
              <form action="/attendance/insert?subject_id=<?= $data['subject_id'] ?>" method="POST">

                <div class="row mb-3">
                    <label class="col-md-4 col-lg-3 col-form-label">Attendance</label>
                    <div class="col-lg-9">
                        <div id="students_input" class="form-control d-flex flex-row-reverse" style="height: 41px;"><i class="bi bi-caret-down-fill pb-5"></i></div>
                        <div id='students_checkbox' style="display:none; padding-left: 15px; border-style: none solid solid; border-width: thin; border-color: rgb(214, 214, 214); background-color: rgb(249, 249, 249); overflow-y: auto; height: 80px;">
                        <?php foreach($studentsData as $studentData): ?>
                          <input type="checkbox" name="checkbox[]" value="<?= $studentData->user_id ?>"><?php echo $studentData->name . ' ' . $studentData->surename ?></input><br>
                        <?php endforeach; ?> 
                        </div>
                        <div class="invalid-feedback">
                            <?php echo isset($params['validation']) ? $params['validation']->getFirstError('class_id') : ' '?>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="datepicker" class="col-md-4 col-lg-3 col-form-label">Date</label>
                    <div class="col-md-8 col-lg-9">
                        <input type="text" name="attendance_date" id="datepicker" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('attendance_date') ? ' is-invalid' : ' ';  ?>" readonly>
                        <div class="invalid-feedback">
                            <?php echo isset($params['validation']) ? $params['validation']->getFirstError('attendance_date') : ' '?>
                        </div>
                    </div>

                </div>
                
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
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

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#datepicker').datepicker({
        format: "mm/dd/yyyy",
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom",
        endDate: "today"      
      });
    });

    $(document).ready(function(){
      $("#students_input").click(function(){
        $("#students_checkbox").slideToggle("slow");
      });
    });
</script>