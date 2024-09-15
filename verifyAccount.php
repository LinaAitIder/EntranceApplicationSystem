<?php
require "./utils/functions.php";
require "./controller/authController.php";
require "./data/config.php";
require "./data/userData.php";



session_start();

if(isset($_POST['verify'])){
    if(isset($_SESSION['user'])){
        $user = unserialize($_SESSION['user']);
        $authController = new authController(new Database , $user);
        $authController->verifyAccount();
      
    } else {
      echo "user session not working";
      echo'<pre>';
      print_r($_SESSION);
      echo'</pre>';

}
   
} else {
        echo "verify data not submitted";
}

?>