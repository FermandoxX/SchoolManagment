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
</head>
<body class="text-center">
  <form class="mt-5" method="POST">
    <img class="mb-4" src="Image/logo-light.png" alt="" width="92" height="77">
    <h1 class="h3 mb-3 fw-normal">Sign in</h1>

    <div class="d-flex justify-content-center  align-items-center flex-column gap-2" style="height:200px">
    <div class="form-floating w-25">
      <input type="email" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('email') ? ' is-invalid' : ' '; ?>" id="floatingInput" placeholder="name@example.com" name="email">
      <label for="floatingInput">Email Address</label>
      <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('email') : ''?></div>
    </div>

    <div class="form-floating w-25">
      <input type="password" class="form-control <?php echo isset($params['validation']) && $params['validation']->hasError('password') ? ' is-invalid' : ' '; ?> " id="floatingPassword" placeholder="Password" name="password">
      <label for="floatingPassword">Password</label>
      <div class = "invalid-feedback"><?php echo isset($params['validation']) ? $params['validation']->getFirstError('password') : ''?></div>
    </div>
    </div>

    <button class="w-25 btn btn-lg btn-primary" type="submit">Sign in</button>
  </form>
</body>
</html>
