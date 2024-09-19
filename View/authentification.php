<?php 
    session_start();
    
    if(isset($_SESSION['userType'])){
        if($_SESSION['userType'] === 'etud'){
            header('Location:./recap.php');
            exit();
        }
        else if(($_SESSION['userType'] === 'admin')){
            header('Location:./administration.php');
            exit();
        }
    } 
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/StylePage.css">
    <title>Authentification</title>
</head>
<body>
    <div class="container">
        <form method="post" class="form" action="../userActions.php?action=login">
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
                        <a href="./inscription.php" class="Link"> S'inscrire </a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div id="notifError"></div>
</body>
<script src="../scripts/functions.js"></script>
<script>
      const urlParams = new URLSearchParams(window.location.search);
      const error = urlParams.get('error');
    if(error === 'not_existing'){
        message('Vous n\'etes pas inscrit!, Veuillez verifier vos donnees','notifError');
    }
    if(error === 'wrong_password'){
        message('Veuillez verifier vos donnees','notifErrror');
    }
</script>
</html>
