<?php
    session_start();
    require './data/config.php';
    require './data/userData.php';
    require './utils/functions.php';
    require './controller/userController.php';
    require './Token_code.php';
    require './Mail_Handler.php';

    //Manage the Acess of the page
    $userUrl = './View/recap.php';
    $adminUrl = './View/administration.html ';
    if(isset($_SESSION['USER'])) {
        if($_SESSION['USER'] === 'etud') {
            header("location:$userUrl");
            exit;  
        } else if($_SESSION['USER'] === 'admin') {
            header("location:$adminUrl");
            exit; 
        }
    } else {
        $user=new user;
        $userController = new userController($user , new Database);
        //SignIn Process
        if(isset($_POST['signUp'])) {
          $userController->SignIn();
        } else {
          echo "Sign up data not submitted ";
        }
    }

 

?>