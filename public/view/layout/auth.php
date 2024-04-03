<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="main.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" >
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8Y+ua7CNiGoA8m6p6D6vuIfq2ZjGfExE5RUg25I2RTepWJz2a9MTGToXbJYO" crossorigin="anonymous"></script>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

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

<script>
$(document).ready(function(){
    $(".success").fadeOut(2500);
    $(".failed").fadeOut(2500);
});
</script>

</head>
<body class="text-center">
{{content}}
<?php if(getFlashMessage('success')):?>
<div class="success alert alert-success alert-white rounded w-25 align-items-center justify-content-center gap-2" style="position: absolute; right: 3%; top: 10%;">
    <div class="icon">
        <i class="fa fa-check"></i>
    </div>
    <strong>Success!</strong> 
    <?php echo getFlashMessage('success') ?>
</div>
<?php endif; ?>

<?php if(getFlashMessage('error')):?>
<div class="failed alert alert-danger alert-white rounded w-25 align-items-center justify-content-center gap-2" style="position: absolute; right: 3%; top: 10%; ">
    <div class="icon">
        <i class="fa fa-times-circle"></i>
    </div>
    <strong>Error!</strong> 
    <?php echo getFlashMessage('error');?>
</div>
<?php endif; ?> 
</body>
</html>