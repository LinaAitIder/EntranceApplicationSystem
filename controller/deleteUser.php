<?php

  session_start();
  require '../data/config.php';

  $userLogin = $_SESSION['recap_etud']['log'];
  $niveau = $_SESSION['recap_etud']['niveau'];
  $db = new Database;
  $db->deleteUserData( $userLogin , $niveau);
  $_SESSION['recap_etud']= NULL;
  header("Location:../View/authen.html");


?>