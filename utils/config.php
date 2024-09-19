<?php

 // Start session if not already started
 if (session_status() == PHP_SESSION_NONE) {
     session_start();
 }
 
 // Include necessary classes
 require_once 'functions.php';  // Common utility functions

 
 // Add any database connections or other global settings here
 require '../data/database.php';
 require '../data/user.php';
 require '../data/admin.php';

 //controllers
 require '../controller/userController.php';
 require '../controller/viewController.php';
 require '../controller/authController.php';



?>