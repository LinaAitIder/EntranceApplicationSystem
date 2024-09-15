<?php 

session_start();

require '../../data/config.php';
require '../../data/userData.php';

require '../userController.php';
require '../../View/userView.php';

// Verify admin

 if($_SESSION['userType'] !== 'admin'){ header("Location:../../View/authentification.html");}
  else { 
    $db = new Database;
    $user=@unserialize($_SESSION['user']);
    $userController=new userController($user , $db);
    $userController->showAllUsers();
  }
?>
