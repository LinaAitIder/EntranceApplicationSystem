<?php 
    require './utils/functions.php';
    session_start();
    $userUrl = './View/recap.php';
    $adminUrl = './administration.html ';
    if($_SESSION['userType'] === "admin" && $_SESSION['userType'] === "etud"){
        pageAccess($userUrl , $adminUrl);
    } else {
        header('Location:./View/authentification.html');
    }
    

?>