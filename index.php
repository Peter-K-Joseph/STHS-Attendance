<?php
// session_start();
// if ($_SESSION["user"] != ""){
//   header("location: ./attendace.php");
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>School Attendance</title>
  <link rel="stylesheet" href="./style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="https://unpkg.com/notie/dist/notie.min.css">
  <meta name="description" content="Unoffical Attendance System for St Theresa's High School">
</head>

<body>
  <!-- partial:index.partial.html -->
  <div class="wrapper fadeInDown">
    <div id="formContent">
      <!-- Tabs Titles -->
      <h2 class="active"> Sign In </h2>
      <!-- Icon -->
      <div class="fadeIn first">
        <!-- <img src="./logo.jpg" height="10%" id="icon" alt="User Icon" /> -->
        <h3>St Theresa's High School</h3>
      </div>

      <!-- Login Form -->
      <form action="./verify.php" method="POST">
        <input type="text" id="login" class="fadeIn second" name="id" placeholder="Login ID">
        <input type="text" id="password" class="fadeIn third" name="password" placeholder="Login Password">
        <input type="submit" type="password" class="fadeIn fourth" value="Log In">
      </form>

      <!-- Remind Passowrd -->
      <div id="formFooter">
        &copy; 2021 | All Rights Reserved
      </div>

    </div>
  </div>
  <!-- partial -->
</body>
<script src="https://unpkg.com/notie"></script>
<script>
  <?php
  if ($_GET["err"] == "true") {
    echo "notie.alert({ type: 2, text: 'Incorrect Credentials!'});";
  }
  ?>
</script>

</html>