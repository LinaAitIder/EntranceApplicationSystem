<?php

session_start();

$recap=$_SESSION['recap_etud'];
$login=$recap['log'];
$niveau=$recap['niveau'];

require_once('ConnectFunc.php');
$con = connect();

if($niveau==$nv3) $query="DELETE FROM etud3a WHERE log = :login";
else $query="DELETE FROM etud4a WHERE log = :login";

$stmt = $con->prepare($query);
$stmt->execute(['login' => $login]);

// Vérification du nombre de lignes affectées (pour confirmer la suppression)
$deleted_rows = $stmt->rowCount();
if ($deleted_rows > 0) {
    echo "<script>alert('le compte est supprimé !')</script>";
} else {
    echo "<script>alert('le Compte n\'est pas supprimé !</script>";
}

session_destroy();
header("location:inscription.php"); //retour à la page d'inscription
exit; 


?>