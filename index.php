<?php 
    require './utils/functions.php';
    session_start();
    $userUrl = './View/recap.php';
    $adminUrl = './administration.html ';
    $homeUrl = './inscription.html';
    pageAccess($userUrl , $adminUrl ,$homeUrl)
?>