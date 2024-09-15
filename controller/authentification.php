<?php
    session_start();
    require '../data/config.php';
    require '../data/userData.php';
    require '../utils/functions.php';
    require './userController.php';
    //Maanage the Acess of the page
    $userUrl = '../View/recap.php';
    $adminUrl = '../administration.html ';

    if(isset($_SESSION['USER'])) {
        // Redirect based on the user type
        if($_SESSION['USER'] === 'etud') {
            header("location:$userUrl");
            exit; // Terminate script execution after redirection
        } else if($_SESSION['USER'] === 'admin') {
            header("location:$adminUrl");
            exit; // Terminate script execution after redirection
        }
    }
    else {

    // require "inscription.php";
    // if($_POST){
    //     echo "Working well";
    // }
    
        $userController = new userController(new Database , new user);

        if(isset($_POST['submit'])){
            $login=$_POST['log'];
            $pass=$_POST['mdp'];

            if( $login ==='admin' && $pass ==='admin') {
                $_SESSION['USER'] = 'admin';
                header("Refresh:1; url=../index.php");
                exit();
            }

            else {
                $userController->login($login,$pass);
            }
        }
    }
    
?>