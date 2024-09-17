<?php 
    session_start();

    require './utils/functions.php';

    $userUrl = './View/recap.php';
    $adminUrl = './View/administration.php ';
    if($_SESSION['userType']){
        pageAccess($userUrl , $adminUrl);
    } else {
        header('Location:./View/authentification.php');
    }
    

?>