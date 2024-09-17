<?php
  session_start();

  require '../data/database.php';
  require '../data/user.php';
  require '../data/admin.php';
  require '../controller/userController.php';
  require '../controller/adminController.php';
  require '../View/userView.php';

  $action = $_GET['action'];

  switch($action){
    case 'lister' :
      if($_SESSION['userType'] !== 'admin'){ header("Location:../View/authentification.php");}
      else { 
       $adminController = new adminController;
       $adminController->lister();
      }
      break;
    case 'search':
      if(isset($_POST['user'])){
        $user = (String) trim($_POST['user']);
        $db= new Database;
        $adminController = new adminController;
        $adminController->search($user);
      }
      break;
  }

?>