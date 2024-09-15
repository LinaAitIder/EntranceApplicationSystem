<?php
    session_start();
    require '../data/config.php';
    require '../data/userData.php';
    require '../utils/functions.php';
    require './accountController.php';

    //Manage the Acess of the page
    $userUrl = '../View/recap.php';
    $adminUrl = '../administration.html ';
    if(isset($_SESSION['userType'])) {
        if($_SESSION['userType'] === 'etud') {
            header("location:$userUrl");
            exit;  
        } else if($_SESSION['userType'] === 'admin') {
            header("location:$adminUrl");
            exit; 
        }
    }
    else {
        $user=new user;
        $authController = new authController(new Database , $user);

        //Authentification process
        if(isset($_POST['submit'])){
            $login=$_POST['log'];
            $pass=$_POST['mdp'];

            if( $login ==='admin' && $pass ==='admin') {
                $_SESSION['USER'] = 'admin';
                header("Refresh:1; url=../index.php");
                exit();
            }

            else {
                $accountController->login($login,$pass);
            }
        }

       
        // VerificationAccount Process
       
    }
  
    
      //User Verification form 
    
    
     
       
    
?>