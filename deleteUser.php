<?php

  session_start();
  require './data/config.php';
  require './data/userData.php';

  $db = new Database;
  $connexion = $db->connect();
  $user = new User;
  $user->log =$_SESSION['recap_etud']['log'];
  $user->niveau=$_SESSION['recap_etud']['niveau'];
  $user->deleteAccount($connexion , $user->log , $user->niveau);
  $_SESSION['recap_etud']= NULL;
  header("Location:./View/authentification.html");


?>