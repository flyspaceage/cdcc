<?php # index.php
session_start();
if (!isset($_SESSION['Username'])){
  // Redirect:
  header("Location:login.php");
  exit();
}else if ($_SESSION['UserClass'] <> 'ADMIN') {
    echo "<p align='center'>You are not authorized to access this page.</p>";
    echo "<p align='center'><a href='index.php'>Click to return to home.</a></p>";
    } else {
  ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CD | CC</title>

  <!-- STYLESHEETs -->
  <link rel="stylesheet" href="css/foundation.css">
  <link rel="stylesheet" href="css/app.css">

  <!-- FONTS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Arsenal" rel="stylesheet">
</head>
<!-- BODY CONTENT BELOW -->
<body>

<?php include('includes/header.html'); ?>
<?php include('includes/hero.html'); ?>

<div class="row" id="reports" style="width:95%; padding-left:15px;">
  <div class="large-24 columns">
  <h3>Administrative Options</h3>
  <a href="#">View/Modify Existing Users</a><br />
  <a href="#">Add User</a><br />
  <a href="#">Delete User</a><br />
    <br/>
  </div>
</div>

<?php include('includes/footer.html'); ?>

<!-- JAVASCRIPT -->
<script src="js/vendor/jquery.js"></script>
<script src="js/vendor/what-input.js"></script>
<script src="js/vendor/foundation.js"></script>
<script src="js/app.js"></script>

</body>
</html>
<?php
}
?>