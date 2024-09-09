<?php

session_start();
require '../../data/config.php';
require '../../data/userData.php';
require '../../View/userView.php';
require '../userController.php';

if(isset($_POST['user'])){
  $user = (String) trim($_POST['user']);
  $db= new Database;
  userController::SearchUser($user , $db);
}

?>