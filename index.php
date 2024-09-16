<?php 
    session_start();

    require './utils/functions.php';

    $userUrl = './View/recap.php';
    $adminUrl = './View/administration.html ';
    if($_SESSION['userType']){
        pageAccess($userUrl , $adminUrl);
    } else {
        header('Location:./View/authentification.html');
    }
    

?>