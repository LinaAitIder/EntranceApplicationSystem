<?php
require "./utils/functions.php";

pageAccess('./View/recap.php','./View/administration.html');

if(isset($_POST['verify'])){
  if(isset($_SESSION['user'])){
      $user = unserialize($_SESSION['user']);
      $authController = new authController(new Database , $user);
      $authController->verifyAccount();
     
  }
  else{
      echo "verify data not submitted";
  }
}
?>