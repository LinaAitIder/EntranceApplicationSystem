<?php 
session_start();
require '../data/config.php';
if($_SESSION['USER']!== 'admin'){ header("Location:Inscriptions.php");}
#how are we going to do with session_id()
include "./../View/candidatsList.html";

$db = new Database;
$connexion= $db->connect();
$html= $db->getAllUsers($connexion);
echo $html;


?>
