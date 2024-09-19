<?php
  session_start();


  

  $action = $_GET['action'];

  switch($action){
    case 'lister' :
      require 'controller/adminController.php';
      require 'data/admin.php';
      require 'data/database.php';
      require 'controller/viewController.php';

      if($_SESSION['userType'] !== 'admin'){ header("Location:../View/authentification.php");}
      else { 
       $adminController = new adminController;
       $adminController->lister();
      }
      break;

    case 'search':
      require 'data/database.php';
      require 'data/admin.php';
      require 'data/user.php';
      require 'controller/viewController.php';
      require 'controller/adminController.php';

      if(isset($_POST['user'])){
        $user = (String) trim($_POST['user']);
        $db= new Database;
        $adminController = new adminController;
        $adminController->search($user);
      }
      break;
      
    case 'logout':
      session_destroy();
      header('Location:./View/authentification.php');
      break;
  }

?>