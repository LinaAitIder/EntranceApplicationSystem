<?php
    session_start();
    require '../data/config.php';
    require '../data/userData.php';
    require '../utils/functions.php';
    require './userController.php';

    //Manage the Acess of the page
    $userUrl = '../View/recap.php';
    $adminUrl = '../administration.html ';
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
        $userController = new userController(new Database , $user);
        //SignIn Process
        if(isset($_POST['signUp'])) {
          $userController->SignIn($user);
        } else {
          echo "Sign up data not submitted ";
        }
    }

 

?>