<?php

/**
 * @package Demo application
 *
 * @author Kaslik Denisz
 *
 */

require_once "connection.php";
include 'User.php';

const MSG_EMAIL_EXISTS = 'Email address already exists!';
const MSG_ACC_CREATE_SUCCESS = 'Congratulations, your account has been successfully created.!';

session_start();

if (isset($_SESSION['user'])) {
  header("location: home.php");
}

$user = new User();

if (isset($_REQUEST['reg_btn'])) {
  $isDataEmpty = false;

  $username = htmlspecialchars($_REQUEST['username']);
  $firstName = htmlspecialchars($_REQUEST['first_name']);
  $lastName = htmlspecialchars($_REQUEST['last_name']);
  $phoneNo = filter_var($_REQUEST['mobile_no'], FILTER_SANITIZE_NUMBER_INT);
  $email = filter_var(strtolower($_REQUEST['email']), FILTER_SANITIZE_EMAIL);
  $password = strip_tags($_REQUEST['password']);

  if (empty($username)) {
    $isDataEmpty = true;
  } else if (empty($firstName)) {
    $isDataEmpty = true;
  } else if (empty($lastName)) {
    $isDataEmpty = true;
  } else if (empty($phoneNo)) {
    $isDataEmpty = true;
  } else if (empty($email)) {
    $isDataEmpty = true;
  } else if (empty($password)) {
    $isDataEmpty = true;
  }

  if (!$isDataEmpty) {
    try {

      $user->setUsername($username);
      $user->setEmail($email);

      $isUserExists = $user->checkExistingUser();

      if ($isUserExists) {
        $errMsgs[] = MSG_EMAIL_EXISTS;
      } else {

        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setMobileNo($phoneNo);
        $user->setPassword($password);
        $register = $user->registration();

        if ($register) {
          header("location: index.php?msg=" . urlencode(MSG_ACC_CREATE_SUCCESS));
        }
      }
    } catch (PDOException $ex) {
      $pdoEx = $ex->getMessage();
    }
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
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
      <div class="register-section col-lg-5 pt-5 px-4 mx-auto">
        <svg class="mx-auto my-3" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
          class="bi bi-person-square" viewBox="0 0 16 16">
          <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
          <path
            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
        </svg>
        <div class="h4">Register new account</div>
        <form action="register.php" method="post">
          <div class="form-row">
            <input type="email" class="form-control my-4 py-2" name="email" aria-describedby="emailHelp"
              placeholder="E-mail" required>
          </div>
          <div class="form-row">
            <input type="text" class="form-control my-4 py-2" name="username" placeholder="Username" required>
          </div>
          <div class="form-row">
            <input type="text" class="form-control my-4 py-2" name="first_name" placeholder="First Name" required>
          </div>
          <div class="form-row">
            <input type="text" class="form-control my-4 py-2" name="last_name" placeholder="Last Name" required>
          </div>
          <div class="form-row">
            <input type="tel" class="form-control my-4 py-2" name="mobile_no" placeholder="Mobile Number" required>
          </div>
          <div class="form-row">
            <input type="password" class="form-control my-4 py-2" name="password" placeholder="Password" required>
          </div>
          <?php
          if (isset($errMsgs)) {
            foreach ($errMsgs as $errMsg) {
              echo "<p class='alert alert-danger'>" . $errMsg . "</p>";
            }
          }
          ?>
          <button type="submit" class="login_btn " name="reg_btn">Register</button>
          <p class="mt-4">Already having an account? <a href="index.php">Login here!</a></p>
        </form>
      </div>
    </div>
  </div>
</body>
<?php include 'footer.php'; ?>

</html>