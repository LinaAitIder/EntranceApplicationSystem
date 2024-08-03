<?php
function pageAccess(){
  if(isset($_SESSION['USER'])) {
      // Redirect based on the user type
      if($_SESSION['USER'] == 'etud') {
          header("location:recap.php");
          exit; // Terminate script execution after redirection
      } elseif($_SESSION['USER'] == 'admin') {
          header("location:administration.php");
          exit; // Terminate script execution after redirection
      }
  }
}
?>