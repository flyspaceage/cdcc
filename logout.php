<?php # logout.php

session_start();

// remove all session variables
session_unset();

// destroy the session
session_destroy();

// Redirect:
header("Location:login.php");
exit();

?>
