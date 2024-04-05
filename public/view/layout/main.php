<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../Image/logo-light.png" rel="icon">
  <link href="/../view/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="/../view/button/css/style.css">
  <link rel="stylesheet" href="/../view/button/css/classic.css">
  <link rel="stylesheet" href="/../view/button/css/classic.date.css">



  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/../view/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/../view/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/../view/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/../view/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="/../view/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="/../view/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/../view/assets/vendor/simple-datatables/style.css" rel="stylesheet">


  <link href="/../view/assets/css/style.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8Y+ua7CNiGoA8m6p6D6vuIfq2ZjGfExE5RUg25I2RTepWJz2a9MTGToXbJYO" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">

<script>
$(document).ready(function(){
    $("#success").fadeOut(5500);
    $("#failed").fadeOut(5500);
});

</script>

 <style>
.alert {
  border-radius: 0;
  -webkit-border-radius: 0;
  box-shadow: 0 1px 2px rgba(0,0,0,0.11);
  display: table;
  width: 100%;
}

.alert-white {
  background-image: linear-gradient(to bottom, #fff, #f9f9f9);
  border-top-color: #d8d8d8;
  border-bottom-color: #bdbdbd;
  border-left-color: #cacaca;
  border-right-color: #cacaca;
  color: #404040;
  padding-left: 61px;
  position: relative;
}

.alert-white.rounded {
  border-radius: 3px;
  -webkit-border-radius: 3px;
}

.alert-white.rounded .icon {
  border-radius: 3px 0 0 3px;
  -webkit-border-radius: 3px 0 0 3px;
}

.alert-white .icon {
  text-align: center;
  width: 45px;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  border: 1px solid #bdbdbd;
  padding-top: 15px;
}


.alert-white .icon:after {
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
  display: block;
  content: '';
  width: 10px;
  height: 10px;
  border: 1px solid #bdbdbd;
  position: absolute;
  border-left: 0;
  border-bottom: 0;
  top: 50%;
  right: -6px;
  margin-top: -3px;
  background: #fff;
}

.alert-white .icon i {
  font-size: 20px;
  color: #fff;
  left: 12px;
  margin-top: -10px;
  position: absolute;
  top: 50%;
}
/*============ colors ========*/
.alert-success {
  color: #3c763d;
  background-color: #dff0d8;
  border-color: #d6e9c6;
}

.alert-white.alert-success .icon, 
.alert-white.alert-success .icon:after {
  border-color: #54a754;
  background: #60c060;
}

.alert-info {
  background-color: #d9edf7;
  border-color: #98cce6;
  color: #3a87ad;
}

.alert-white.alert-info .icon, 
.alert-white.alert-info .icon:after {
  border-color: #3a8ace;
  background: #4d90fd;
}


.alert-white.alert-warning .icon, 
.alert-white.alert-warning .icon:after {
  border-color: #d68000;
  background: #fc9700;
}

.alert-warning {
  background-color: #fcf8e3;
  border-color: #f1daab;
  color: #c09853;
}

.alert-danger {
  background-color: #f2dede;
  border-color: #e0b1b8;
  color: #b94a48;
}

.alert-white.alert-danger .icon, 
.alert-white.alert-danger .icon:after {
  border-color: #ca452e;
  background: #da4932;
}
  </style>

</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/main" class="logo d-flex align-items-center" style="width: 125px;">
        <img src="../Image/logo-light.png" alt="">
        <span class="d-none d-lg-block"><?php echo ucfirst(getRole()) ?></span>
      </a>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="/../image/<?php echo getImage() ?? 'Sad photo icon.jpg';?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo mb_substr(getName(), 0, 1) .'.'. getSurename()?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo getName() .' '. getSurename() ?></h6>
              <span><?php echo ucfirst(getRole()) ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/user">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header>

  {{content}}

     <!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <?php if(isAdmin()): ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="/main">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
    <?php endif; ?>
  
    <?php if(isAdmin()): ?>
      <li class="nav-item">
        <a class="admin nav-link collapsed" href="/admin">
          <i class="bi bi-person-fill"></i>
          <span>Admin</span>
        </a>
      </li>
    <?php endif; ?>

    <li class="nav-item">
      <a class="admin nav-link collapsed" href=<?php echo isStudent() ? "/student/teacher" : "/teacher"?>>
        <i class="bi bi-person-video3"></i>
        <span>Teachers</span>
      </a>
    </li>

    <?php if(isAdmin() || isTeacher()): ?>
      <li class="nav-item">
        <a class="admin nav-link collapsed" href=<?php echo isAdmin() ? "/student" : "/teacher/student"?>>
          <i class="bi bi-people-fill"></i>
          <span>Student</span>
        </a>
      </li>
    <?php endif; ?>

    <li class="nav-item">
      <a class="admin nav-link collapsed" href=<?php echo isStudent() ? "/student/subject" : "/subject"?>>
        <i class="bi bi-book-fill"></i>
        <span>Subject</span>
      </a>
    </li>

    <?php if(isAdmin()): ?>
      <li class="nav-item">
        <a class="admin nav-link collapsed" href="/class">
          <i class="bi bi-plus-circle-fill"></i>
          <span>Class</span>
        </a>
      </li>
    <?php endif; ?>

    <li class="nav-item">
      <?php if(isStudent()):?>
        <a class="admin nav-link collapsed" href=<?php echo "/student/grade/supject"?>>
        <i class="bi bi-clipboard-check-fill"></i>
        <span>Grade</span>
      <?php elseif(isTeacher()): ?>
        <a class="admin nav-link collapsed" href=<?php echo "/grade/supject"?>>
        <i class="bi bi-clipboard-check-fill"></i>
        <span>Grade</span>
      <?php endif; ?>
      </a>
    </li>

    <li class="nav-item">
      <?php if(isAdmin()): ?>
        <a class="admin nav-link collapsed" href="/attendance">
      <?php elseif(isTeacher()): ?>
        <a class="admin nav-link collapsed" href='/teacher/attendance'>
      <?php else: ?>
        <a class="admin nav-link collapsed" href="/student/attendance">
      <?php endif;?>    
        <i class="bi bi-calendar-event-fill"></i>
        <span>Attendance</span>
      </a>
    </li>

</aside><!-- End Sidebar-->

<?php if(getFlashMessage('success')):?>
<div class="success alert alert-success alert-white rounded w-25 align-items-center justify-content-center gap-2" id="success" style="position: absolute; right: 3%; top: 10%;">
    <div class="icon">
        <i class="fa fa-check"></i>
    </div>
    <strong>Success!</strong> 
    <?php echo getFlashMessage('success') ?>
</div>
<?php endif; ?>

<?php if(getFlashMessage('error')):?>
<div class="failed alert alert-danger alert-white rounded w-25 align-items-center justify-content-center gap-2" id="failed" style="position: absolute; right: 3%; top: 10%; ">
    <div class="icon">
        <i class="fa fa-times-circle"></i>
    </div>
    <strong>Error!</strong> 
    <?php echo getFlashMessage('error');?>
</div>
<?php endif; ?> 

  <!-- Vendor JS Files -->
  <script src="/../view/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="/../view/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/../view/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="/../view/assets/vendor/echarts/echarts.min.js"></script>
  <script src="/../view/assets/vendor/quill/quill.min.js"></script>
  <script src="/../view/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="/../view/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="/../view/assets/vendor/php-email-form/validate.js"></script>
  <script src="/../view/assets/js/main.js"></script>
  
  <script src="/../view/button/js/jquery-3.3.1.min.js"></script>
  <script src="/../view/button/js/bootstrap.min.js"></script>

  <!-- Bootstrap Datepicker JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

</body>
</html>
