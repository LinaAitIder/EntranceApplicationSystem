<?php 
    session_start();
    if($_SESSION['userType'] !== 'admin'){
        if($_SESSION['userType'] === 'etud'){
            header('Location:./recap.php');
        } else {
            header('Location:./authentification.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/StylePage.css">
    <title>Inscription</title>
</head>
<body>
        <div class="container">
            <form method="post" action="../userActions.php?action=signIn" enctype="multipart/form-data" class="form">
                <table>
                    <legend>
                        <p style="font-family: arial;font-size: 20px; font-weight:bold; text-align:center; color:black; margin-bottom:10px; ">Admission au concours d'accès:</p>
                    </legend>
                    <tr class="message"></tr>
                    <tr>
                        <td>
                            <input type="text" placeholder="Nom" name="nom" required>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                        <input type="text" placeholder="Prénom" name="prenom" required>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                        <input type="text" placeholder="Username" name="log" required>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <input type="email" placeholder="Email" name="email" required>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <input type="password" placeholder="Votre mot de passe" name="mdp" required>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <input type="date" placeholder="Date de naissance" name="naissance" required>
                        </td>
                    </tr>
                    <tr>  
                        <td><input type="text" placeholder="Établissement" name="etab" required></td> 
                    </tr>
                    <tr>
                        <td> 
                            <select name="diplome" class="select-class" required>
                                <option value="Bac+2">Bac+2</option>
                                <option value="Bac+3">Bac+3</option>
                            </select>
                        </td> 
                    </tr>
                    <tr>
                        <td><label for="photo">Importer une photo</label><input type="file" name="photo" value="Importer une photo" src="ImageIcon.png" ></td>
                    </tr>
                    <tr>
                         <td><label for="cv">Importer un cv</label><input type="file" name="cv"  value="Importer un CV" src="ImageIcon.png"> </td>
                    </tr>
                    
                    <tr>
                         <td> <strong>Votre niveau d'études:</strong></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="niveau4" > 4ème année
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="niveau3" >3ème année 
                        </td>

                    </tr>
                    <tr>
                        <td> <input type="submit" name="signUp" value="S'inscrire"></td>
                    </tr>
                    <tr>
                        <td class="Link-align"> <a href="./authentification.php" class="Link">S'authentifier</a></td>
                    </tr>
                </table>
            </form>
      
    </div>
</body>
</html>