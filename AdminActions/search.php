<?php

session_start();
require '../data/config.php';
require '../data/userData.php';
require '../data/adminData.php';
require '../controller/userController.php';
require '../controller/adminController.php';
require '../View/userView.php';

if(isset($_POST['user'])){
  $user = (String) trim($_POST['user']);
  $db= new Database;
  $adminController = new adminController;
  $adminController->search($user);
}

?>