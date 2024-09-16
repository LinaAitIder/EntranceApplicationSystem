<?php 

session_start();

require '../../data/config.php';
require '../../data/userData.php';
require '../userController.php';
require '../adminController.php';

require '../../View/userView.php';

// Verify admin

 if($_SESSION['userType'] !== 'admin'){ header("Location:../../View/authentification.html");}
  else { 
   $adminController = new adminController;
   $adminController->lister();
  }
?>
