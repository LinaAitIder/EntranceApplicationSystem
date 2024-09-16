<?php

  session_start();
  require './data/config.php';
  require './data/userData.php';

  $db = new Database;
  $connexion = $db->connect();
  $user = unserialize($_SESSION['user']);
  $user->deleteAccount($connexion , $user->log , $user->niveau);
  header("Refresh:2;url=./View/authentification.html");


?>