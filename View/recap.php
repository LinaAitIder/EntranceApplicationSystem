
<?php
    session_start();
    require '../controller/userController.php';
    require '../data/database.php';
    require '../data/user.php';
    require '../controller/viewController.php';
    require '../utils/functions.php';

    // Gerer l'acces a la page
    if($_SESSION['userType'] !== 'etud'){
        if(($_SESSION['userType'] === 'admin')){
            header('Location:./administration.php');
        } else{
            header('Location:./authentification.php');
        }
    }
   
    // Affichage des informations de candidature
    $user= @unserialize($_SESSION['user']);
    $db=new Database;
    $userController = new userController($user, $db);
    
    if ($_SESSION['user']) {
        $userController->displayUserInfo();
    } else {
        echo "<script>console.log('Affichage de dnns d'utilisateur :Aucune information de candidature disponible.');</script>";
    }
    
    ?>

