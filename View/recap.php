
<?php
    session_start();

    if($_SESSION['userType'] !== 'etud'){
        if(($_SESSION['userType'] === 'admin')){
            header('Location:./administration.php');
        } else{
            header('Location:./authentification.php');
        }
    }
   

    require '../data/database.php';
    require '../data/user.php';
    require '../controller/userController.php';
    require '../utils/functions.php';
    require '../View/userView.php';

    /*
        echo '<pre>';
        print_r($_SESSION);  //rint out session data for debugging
        echo '</pre>';
    */

    $user= @unserialize($_SESSION['user']);

    $db=new Database;
    $userController = new userController($user, $db);
    
    if ($_SESSION['user']) {
        $userController->displayUserInfo();
    } else {
        echo "<p>Aucune information de candidature disponible.</p>";
    }
    
    ?>

