<?php 
session_start();
session_destroy();

header('Location:../Inscription.html');
?>