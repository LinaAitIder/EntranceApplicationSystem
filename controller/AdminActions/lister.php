<?php 

session_start();

require '../../data/config.php';
require '../../data/userData.php';

require '../userController.php';
require '../../View/userView.php';

// Verify admin

if($_SESSION['USER']!== 'admin'){ header("Location:Inscriptions.php");}

$db = new Database;
$connexion= $db->connect();
$userController=new userController($db , $connexion);
$userController->showAllUsers();

?>
