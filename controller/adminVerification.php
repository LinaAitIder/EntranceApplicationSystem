<?php session_start();
 if($_SESSION['USER'] != 'admin'){
   echo "hi";
    header("location:../Inscription.html"); 
 } else {
  header('Location:../administration.html');

 }

echo " Hello , there!";

?>