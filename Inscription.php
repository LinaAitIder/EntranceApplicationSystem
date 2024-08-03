<?php  
require 'utils/functions.php';
require 'ConnectFunc.php';
require 'Token_code.php';
require 'Mail_Handler.php';
session_start();
pageAccess();

$connexion= connect();

if (isset($_POST['submit'])) {
    // Retrieving data form 
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $login = $_POST['log'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['mdp'] , PASSWORD_DEFAULT); // securite
    $date = $_POST['naissance'];
    $diplome = $_POST['diplome'];
    $nv3 = isset($_POST['niveau3']) ;
    $nv4 = isset($_POST['niveau4']) ;
    $etab = $_POST['etablissement'];
   // Giving value to $niveau depending on the user input 
    if ($nv3 && !$nv4) { 
        // clicked on level 3
        $niveau = 'nv3';
    
    } elseif ($nv4 && !$nv3) { 
        // clicked on level 4
        $niveau = 'nv4';
    } elseif (!$nv3 && !$nv4) { 
        // error : pas no level selected
        echo "<script>alert('Choisissez un seul niveau!');</script>";
        header("refresh:5;url=Inscription.php");
        return; 
    }

    // Random value for token 
    $randomNumber = rand(1, 9999);
    $token =  $randomNumber;
 
   
    if (isset($_FILES['photo']) && isset($_FILES['cv'])) {
            $errors = [];
    
            // Gestion de la photo
            $photo = $_FILES['photo'];
            $photoName = $photo['name'];
            $photoTmpName = $photo['tmp_name'];
            $photoSize = $photo['size'];
            $photoError = $photo['error'];
            
            // Gestion du CV
            $cv = $_FILES['cv'];
            $cvName = $cv['name'];
            $cvTmpName = $cv['tmp_name'];
            $cvSize = $cv['size'];
            $cvError = $cv['error'];
    
            // Valider les types de fichiers
            $allowedPhotoTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $allowedCvTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    
            if (!in_array($photo['type'], $allowedPhotoTypes) || !in_array($cv['type'], $allowedCvTypes)) {
                $errors[] = "Types de fichiers non autorisés. Assurez-vous d'envoyer une photo (JPG/PNG/GIF) et un CV (PDF/DOCX).";
            }
    
            // Valider la taille des fichiers
            $maxPhotoSize = 2 * 1024 * 1024; // 2 Mo
            $maxCvSize = 5 * 1024 * 1024; // 5 Mo
    
            if ($photoSize > $maxPhotoSize || $cvSize > $maxCvSize) {
                $errors[] = "La taille des fichiers dépasse la limite autorisée.";
            }
    
            // Gestion des erreurs
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo $error . "<br>";
                }
            } else {
                // Enregistrer les fichiers dans un dossier sur le serveur
                $uploadDir = 'uploads/';
                $photoPath = $uploadDir . $photoName;
                $cvPath = $uploadDir . $cvName;

                 move_uploaded_file($photoTmpName, $photoPath);
                 move_uploaded_file($cvTmpName, $cvPath);
                
           }
        }
    // Level input Verification + Insertion to database
    if ( $diplome && $nv3 && $nv4) {
        if ($diplome=='Bac+3') echo "<script>alert('Vous ne pouvez pas choisir les deux niveaux en tant que Candidat de BAC+3')</script>";
        elseif ($diplome=='Bac+2') {
                // Insertion into etud3a : Candidature 3eme annees
                $niveau = 'nv3';
                try{
                $sql = "INSERT INTO etud3a (nom, prenom, email, naissance, diplome, niveau, etablissement, photo, cv, log, mdp, token) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $connexion->prepare($sql);
                $reg1= $stmt->execute([$nom, $prenom, $email, $date, $diplome, $niveau, $etab, $photoPath, $cvPath, $login, $pass, $token]) ;
                // Verification de l'insertion
    
                // Insertion into etud3a : Candidature 4eme annees
                $niveau = 'nv4';
                $sql = "INSERT INTO etud4a (nom, prenom, email, naissance, diplome, niveau, etablissement, photo, cv, log, mdp, token) VALUES (?,? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $connexion->prepare($sql);
                $reg2 =$stmt->execute([$nom, $prenom, $email, $date, $diplome, $niveau, $etab, $photoPath, $cvPath, $login , $pass , $token]);
                } catch (PDOException $e) {
                    if ($e->errorInfo[1] === 1062) { 
                        echo '<script>alert("Vous etes deja inscrit!");</script>';
                        header("Refresh:5; url=authen.php");
                    } else {  
                        echo "Une erreur est survenue : " . $e->getMessage(); 
                    }
                }
                if($reg1 && $reg2) {
                    echo "<script>alert('Inscription enregistree!');</script>";    
                    $Tpdf=CreatefpdfToken($token);
                    if(sendmail($nom , $prenom ,$email , $Tpdf)){
                        header("Refresh:5; url=Verify_account.php?code=$token");
                        exit();
                    }
                    else {
                        echo "<script>alert('Erreur : Email pas envoye!')</script>";
                    }
                }
          // Verification de l'insertion
     }}
    elseif ($diplome && ($nv3 || $nv4)) {
        $table = $niveau === 'nv3' ? 'etud3a' : 'etud4a';
        try {
            $sql = "INSERT INTO $table (nom, prenom, email, naissance, diplome, niveau, etablissement, photo, cv, log , mdp, token) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connexion->prepare($sql);
            if ($stmt->execute([$nom, $prenom, $email, $date, $diplome, $niveau, $etab,  $photoPath, $cvPath, $login, $pass, $token])) {
                echo "<script>alert('Inscription enregistree');</script>";    
                $Tpdf=CreatefpdfToken($token);
                if(sendmail($nom , $prenom ,$email , $Tpdf)){
                    echo '<script>alert("Message envoye!");</script>';
                    header("Refresh:5; url=Verify_account.php?code=$token");
                    exit();
                }
                else {
                    echo "<script>alert('Erreur : Email pas envoye!')</script>";
                }
            }
        } catch (PDOException $e) {
            // Check if the error is related to a unique constraint violation
            if ($e->errorInfo[1] === 1062) {     
                 echo "<script>alert('Vous etes deja inscrit!')</script>";
            } else {
                // If it's another type of error, you can handle it differently
                echo "Une erreur est survenu: " . $e->getMessage();
            }
        }
    }
}



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StylePage.css">
    <title>Inscription</title>
</head>
<body>
        <div class="container">
            <form method="post" action="" enctype="multipart/form-data" class="form">
                <table>
                    <legend>
                        <p style="font-family: arial;font-size: 20px; font-weight:bold; text-align:center; color:black; margin-bottom:10px; ">Admission au concours d'accès:</p>
                    </legend>
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
                        <td><input type="text" placeholder="Établissement" name="etablissement" required></td> 
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
                            <input type="radio" name="niveau4" value="nv4"> 4ème année
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="niveau3" value="nv3"> 3ème année
                        </td>

                    </tr>
                    <tr>
                        <td> <input type="submit" name="submit" value="S'inscrire"></td>
                    </tr>
                    <tr>
                        <td class="Link-align"> <a href="authen.php" class="Link">S'authentifier</a></td>
                    </tr>
                </table>
            </form>
      
    </div>
</body>
</html>

