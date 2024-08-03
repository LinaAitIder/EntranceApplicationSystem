<?php 
session_start();
session_destroy();
header('location:Inscription.php');
?>