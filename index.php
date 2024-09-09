<?php 
    require './utils/functions.php';
    session_start();
    $userUrl = './View/recap.php';
    $adminUrl = './administration.html ';
    $home = './View/inscription.html';
    pageAccess($userUrl , $adminUrl ,$home)
?>