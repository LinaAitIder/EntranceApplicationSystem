<?php
    session_start();
    require './data/config.php';
    require './data/userData.php';
    require './utils/functions.php';
    require './controller/authController.php';

    //Manage the Acess of the page
    $userUrl = './View/recap.php';
    $adminUrl = './View/administration.html ';
    pageAccess($userUrl , $adminUrl);

    //Authentification process
    if(isset($_POST['submit'])){
        $login=$_POST['log'];
        $pass=$_POST['mdp'];

        if( $login ==='admin' && $pass ==='admin') {
            $_SESSION['userType'] = 'admin';
            header("Location:./View/administration.html");
            exit();
        }

        else {
            $user= @unserialize($_SESSION['user']);
            $authController = new authController(new Database , $user);
            $authController->login($login,$pass);
        }
    }

             
    
?>