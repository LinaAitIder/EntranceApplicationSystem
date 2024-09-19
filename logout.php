<?php
  session_start();
  session_destroy();
  header('./View/authentification.php');
?>