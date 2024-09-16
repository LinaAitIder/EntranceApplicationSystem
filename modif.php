<?php
session_start();

require_once('./utils/functions.php');
require './data/userData.php';
require './data/config.php';
require './controller/userController.php';
require './View/userView.php';


$user = unserialize($_SESSION['user']);
$db = new Database;
$userLogin = $user->log;



if (isset($_POST['modifier'])) {
  $userController = new userController($user , $db);
  $userController->updateUserInfo($user);

  // Updating Data
  try { 
    $db->updateData($user , $userLogin);

  } catch(Exception $error){
    echo 'Error : '. $error->getMessage();
  };

 $niveau = nameLevel($user->niveau);
 userView::updateRecap($user , $niveau);
  
}

 
?>

