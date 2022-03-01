<?php
//include constant.php for SITEURL
 include('../config/constants.php');
//1. destry the session and redirect to lodin page
session_destroy();

//2. redirect to login page
header('location:'.SITEURL.'admin/login.php');
?>