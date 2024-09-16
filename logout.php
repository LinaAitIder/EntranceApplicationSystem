<?php 
session_start();
session_destroy();
      header('Location:./View/authentification.html');
// session_start();
// echo '<pre>';
// print_r($_SESSION); // Print out session data for debugging
// echo '</pre>';

?>