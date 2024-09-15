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
    }
    else {
        $user=new user;
        $userController = new userController(new Database , $user);

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
                $userController->login($login,$pass);
            }
        }

       
        // VerificationAccount Process
        if(isset($_POST['verify'])){
            if(isset($_SESSION['user'])){
                $user = unserialize($_SESSION['user']);
                ECHO "name of user :" .$user->nom;
                $code = trim($_POST['tokenCode']);
                $token_ver = trim($db->getToken($user, $connexion));
                echo "Entered Code: " . htmlspecialchars($code) . "<br>";
                echo "Token from DB: " . htmlspecialchars($token_ver) . "<br>";
                if($code === $token_ver ){
                    $user->verifStatus = true;
                    $user->token = $code;
                    //Creating an update function
                    $db->updateVerifStatus($user , $connexion);
                    $_SESSION['USER'] == 'etud';
                    echo "I guess the problem is in the header";
                    header("Location: ../View/authen.html");
                    exit();
                }
                else {
                    echo "<script src='errorMessage.js'></script>";
                    echo "<script>CodeVerifError();</script>";
                    echo " pas le mm code";
            
                }
            }
            else{
                echo "verify data not submitted";
            }
        }
    }
  
    
      //User Verification form 
    
    
     
       
    
?>