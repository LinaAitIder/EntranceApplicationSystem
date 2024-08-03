<?php 
session_start();
// si authentifie , ne pas avoir la possibilite de returner a cette page jusqu'a deconnexion
if(isset($_SESSION['USER'])) {
    if($_SESSION['USER'] == 'etud') {
        header("location:recap.php");
        exit; 
    } elseif($_SESSION['USER'] == 'admin') {
        header("location:administration.php");
        exit; 
    }
}
require_once('ConnectFunc.php');
$con = connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StylePage.css">
    <title>Authentification</title>
</head>
<body>
    <div class="container">
        <form method="post" class="form">
            <table>
                <legend>
                        <p style="font-family: arial;font-size: 20px; font-weight:bold; text-align:center; color:black; margin-bottom:10px; ">Authentification</p>
                </legend>
                <tr>
                    <td><input type="text" placeholder="Login" name="log" required></td>
                </tr>
                <tr>
                    <td>
                    <input type="password" placeholder="Mot de passe" name="mdp" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="submit" value="S'authentifier">
                    </td>
                </tr>
                <tr>
                    <td class="Link-align" >
                        <a href="Inscription.php" class="Link"> S'inscrire </a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
<?php
    if(isset($_POST['submit'])){
        $login=$_POST['log'];
        $pass=$_POST['mdp'];
        if( $login=='admin' && $pass=='admin') {
            $_SESSION['USER']='admin';
            header("location:administration.php");
        }
        else {
            //Verification de l'existence d'etudiant dans Bd
            $query="SELECT log FROM etud3a WHERE log = :login Union SELECT log FROM etud4a WHERE log = :login";
            $stmt = $con->prepare($query);
            $stmt->execute(['login' => $login]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($result) {
                $query="SELECT * FROM etud3a WHERE log = :login Union SELECT * FROM etud4a WHERE log = :login";
                $stmt = $con->prepare($query);
                $stmt->execute(['login' => $login]); 
                $result = $stmt->fetch(PDO::FETCH_ASSOC); 
                $_SESSION['recap_etud']=$result;
                $_SESSION['USER'] = 'etud';
                header("Location: recap.php?login=" . $login);
            } else {
                echo "<script>alert('Vous n'êtes pas inscrit, Veuillez vous reinscrire !');</script>";
            }}
            
        }
?>
</html>