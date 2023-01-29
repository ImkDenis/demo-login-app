<?php

/**
 * @package Demo application
 *
 * @author Kaslik Denisz
 *
 */

require_once 'connection.php';
include 'User.php';

const MSG_INVALID_ERROR = 'You must enter Email or Username!';
const MSG_PASSWORD_ERROR = 'You must enter password!';
const MSG_WRONG_CREDS_ERROR = 'Wrong email or password';
const MSG_LOGIN_SUCCESS = 'You are now logged in to the system!';

session_start();

if (isset($_SESSION['user'])) {
  header("location: home.php");
}

$user = new User();
if (isset($_REQUEST['login_btn'])) {

  $emailName = htmlspecialchars(strtolower($_REQUEST['emailName']));
  $password = strip_tags($_REQUEST['password']);

  if (empty($emailName)) {
    $errMsgs[] = MSG_INVALID_ERROR;
  } else if (empty($password)) {
    $errMsgs[] = MSG_PASSWORD_ERROR;
  } else {
    $user->setEmail($emailName);
    $user->setUsername($emailName);
    $user->setPassword($password);
    $login = $user->login();

    if ($login) {
      $_SESSION['msg'] = MSG_LOGIN_SUCCESS;
      header("location: home.php");
    } else {
      $errMsgs[] = MSG_WRONG_CREDS_ERROR;
    }
  }
}

?>

<html lang="en">

<head>
  <title>Demo login app</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/resources/css/style.css">
</head>

<body>

  <section class="form my-5 mx-2"></section>
  <div class="container">
    <div class="row g-0">
      <div class="col-lg-5">
        <img src="/resources/img/stock.jpg" class="img-fluid"></img>
      </div>
      <div class="login-section col-lg-5 pt-5 px-4 mx-auto">
        <?php
        if (isset($_REQUEST['msg'])) {
          echo "<p class='error success'>" . $_REQUEST['msg'] . "</p>";
        }
        ?>
        <svg class="mx-auto my-2" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
          class="bi bi-person-square" viewBox="0 0 16 16">
          <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
          <path
            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
        </svg>
        <div class="h4">Sign into your account</div>
        <form action="index.php" method="post">

          <div class="form-row">
            <input type="text" class="form-control my-4 py-2" name="emailName" placeholder="Username/Email">
          </div>
          <div class="form-row">
            <input type="password" class="form-control my-4 py-2" name="password" placeholder="Password">
          </div>
          <?php
          if (isset($errMsgs)) {
            foreach ($errMsgs as $errMsg) {
              echo "<p class='alert alert-danger'>" . $errMsg . "</p>";
            }
          }
          ?>
          <div class="form-row">
            <button type="submit" name="login_btn" class="login_btn">Login</button>
          </div>
          <p class="no-acc mt-5 mb-6">Don't have an account? <a href="register.php">Register</a></p>

        </form>
      </div>
    </div>
  </div>

</body>
<?php include 'footer.php'; ?>

</html>