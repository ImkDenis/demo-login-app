<?php

/**
 * @package Demo application
 *
 * @author Kaslik Denisz
 *
 */

require_once 'connection.php';
include 'user.php';

session_start();

if (!isset($_SESSION['user'])) {
  header('location:index.php');
} else {
  $userId = $_SESSION['user']['id'];
}

$user = new User();
if (isset($_POST['logout_btn'])) {
  $user->logout();
  header("location:index.php");
}

if (isset($_SESSION['msg'])) {
  $msg = $_SESSION['msg'];
}

$userData = $user->getUserData($userId);

?>

<html lang="en">

<head>
  <title>Welcome</title>
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
        <img src="/resources/img/avatar.jpeg" class="img-fluid"></img>
      </div>
      <div class="home-section col-lg-5 pt-5 px-4 mx-auto">
        <form action="home.php" method="post">
          <?php
          if (isset($msg)) {
            echo
              "<div class='error success'><p>" . $msg . "</p></div>";
            unset($_SESSION['msg']);
          }
          ?>
          <div class="h4">User data</div>
          <table class="table">
            <thead>
              <tr>
                <th scope="col"></th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              echo "<tr>";
              echo "<td>" . "Username" . "</td>";
              echo "<td>" . $userData['username'] . "</td>";
              echo "</tr>";
              echo "<tr>";
              echo "<td>" . "First name" . "</td>";
              echo "<td>" . $userData['first_name'] . "</td>";
              echo "</tr>";
              echo "<tr>";
              echo "<td>" . "Last Name" . "</td>";
              echo "<td>" . $userData['last_name'] . "</td>";
              echo "</tr>";
              echo "<tr>";
              echo "<td>" . "Mobile No." . "</td>";
              echo "<td>" . $userData['mobile_no'] . "</td>";
              echo "</tr>";
              echo "<tr>";
              echo "<td>" . "E-mail" . "</td>";
              echo "<td>" . $userData['email'] . "</td>";
              echo "</tr>";
              ?>

            </tbody>
          </table>
          <div class="form-row">
            <button type="submit" name="logout_btn" class="login_btn mb-5">Logout</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>
</body>
<?php include 'footer.php'; ?>

</html>