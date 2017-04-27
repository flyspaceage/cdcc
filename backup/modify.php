<?php # modify.php
session_start();
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

<!-- HEADER -->
<header class="desktop-navigation">
<div class="title-bar" data-responsive-toggle="main-menu" data-hide-for="medium">
  <button class="menu-icon" type="button" data-toggle></button>
  <div class="title-bar-title">Menu</div>
</div>
  <!-- MENU -->
  <nav class="desktop-navigation">
    <div class="top-bar" id="main-menu">
      <div class="top-bar-left">
        <ul class="dropdown menu" data-dropdown-menu>
          <li class="menu-text">City Dome & Convention Center</li>
        </ul>
      </div>
      <div class="top-bar-right">
        <ul class="menu" data-responsive-menu="drilldown medium-dropdown">
          <li class="has-submenu">
            <a href="#">Add New</a>
            <ul class="submenu menu vertical" data-submenu>
              <li><a href="#newCustomer">Customer</a></li>
              <li><a href="#newCaterer">Caterer</a></li>
              <li><a href="#newVenue">Venue</a></li>
              <li><a href="#newBooking">Booking</a></li>
            </ul>
          </li>
          <li><a href="#">View Reports</a>
            <ul class="submenu menu vertical" data-submenu>
              <li><a href="report.php?type=customers">Customers</a></li>
              <li><a href="report.php?type=active">Active Bookings</a></li>
              <li><a href="report.php?type=cancelled">Canceled Bookings</a></li>
              <li><a href="report.php?type=all">View All</a></li>
            </ul>
          </li>
          <li><a href="#">Options</a>
            <ul class="submenu menu vertical" data-submenu>
              <li><a href="#usersPage">Users</i></a></li>
              <li><a href="#settingsPage">Settings</i></a></li>
              <li><a href="#logOut">Log Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="top-bar-right">
        <ul class="search menu" data-dropdown-menu>
            <li><a href="#searchMenu"><i class="fa fa-search" aria-hidden="true"></i></a></li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<!-- HERO -->
<section class="hero">
    <div class="welcome">
        <h1>CD|CC<br>Information System</h1>
        <a href="report.php?type=active" class="small button">Active Bookings Report</a>
        <a href="report.php?type=cancelled" class="small button">Cancelled Bookings Report</a>
        <a href="report.php?type=all" class="small button">Active & Cancelled Bookings Report</a>
        <a href="report.php?type=customers" class="small button">Customer List</a>
    </div>
</section>

<!-- FORMS -->
<?php include 'forms/ubooking.php'; ?>



<!-- FOOTER -->
<footer>
  <div class="wrap row small-up-1 medium-up-3">
    <div class="column">
      <h4><a href="#">User Settings</a></h4>
      <hr>
        <a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
        <a href="#"><i class="fa fa-users" aria-hidden="true"></i></a>
        <a href="#"><i class="fa fa-phone" aria-hidden="true"></i></a>
        <a href="#"><i class="fa fa-power-off" aria-hidden="true"></i></a>
      </div>
    <div class="column">
      <h4><a href="#">Add New</a></h4>
      <hr>
        <a href="#newCustomer" class="footer-navigation">Customer</a>
        <a href="#newCaterer" class="footer-navigation">Caterer</a>
        <a href="#newVenue" class="footer-navigation">Venue</a>
        <a href="#newBooking" class="footer-navigation">Booking</a>
    </div>
    <div class="column">
      <h4><a href="#">Search Directory</a></h4>
      <hr>
        <input type="text" placeholder="Search" />
    </div>
  </div>
</footer>

<!-- JAVASCRIPT -->
  <script src="js/vendor/jquery.js"></script>
  <script src="js/vendor/what-input.js"></script>
  <script src="js/vendor/foundation.js"></script>
  <script src="js/app.js"></script>

  </body>
</html>
