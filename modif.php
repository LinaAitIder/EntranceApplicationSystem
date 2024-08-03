<?php
session_start();

require_once('ConnectFunc.php');

if (isset($_POST['confirmer'])) {
    // Retrieving data form 
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $new_login = $_POST['log'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['mdp'] , PASSWORD_DEFAULT); // securite
    $date = $_POST['naissance'];
    $diplome = $_POST['diplome'];
    $nv3 = isset($_POST['niveau3']) ;
    $nv4 = isset($_POST['niveau4']) ;
    $etab = $_POST['etablissement'];
}

$recap=$_SESSION['recap_etud'];
$login=$recap['log'];
$niveau=$recap['niveau'];

try {

$con = connect();

if (isset($nv3)){$table = 'etud3a'; $niv="nv3";} 
else {$table = 'etud4a'; $niv="nv4";}

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


$query="UPDATE $table 
        SET nom = :nom, prenom = :prenom, email = :email, naissance = :date, diplome = :diplome, niveau = :niveau, etablissement = :etab, photo = :photo, cv = :cv, log = :new_login, mdp = :pass 
        WHERE log = :login";


$stmt = $con->prepare($query);

 // Liaison des valeurs aux paramètres de la requête
 $stmt->bindParam(':nom', $nom);
 $stmt->bindParam(':prenom', $prenom);
 $stmt->bindParam(':email', $email);
 $stmt->bindParam(':date', $date);
 $stmt->bindParam(':diplome', $diplome);
 $stmt->bindParam(':niveau', $niv);
 $stmt->bindParam(':etab', $etab);
 $stmt->bindParam(':photo ', $photo);
 $stmt->bindParam(':cv ', $cv);
 $stmt->bindParam(':new_login', $new_login);
 $stmt->bindParam(':pass', $pass);
 $stmt->bindParam(':login', $login);
$stmt->execute();

echo '<script>alert("Les données ont été mises à jour avec succès !  !");</script>';
header("location:recap.php");
exit;
} 
catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script>
    function reconnecter() {
        window.location.href = 'authen.php';
    }
    </script>
    <link rel="stylesheet" href="Styles_h.css">
</head>
<body>

<form method="post" action="" enctype="multipart/form-data">
                <div class="formElements">
                    <input type="text" placeholder="nom" name="nom" required>
                    <input type="text" placeholder="prénom" name="prenom" required>
                    <input type="text" placeholder="Username" name="log" required>
                    <input type="email" placeholder="Email" name="email" required>
                    <input type="text" placeholder="Votre mot de passe" name="mdp" required>
                    <input type="date" placeholder="Date de naissance" name="naissance" required>
                    <select name="diplome" required>
                        <option value="Bac+2">Bac+2</option>
                        <option value="Bac+3">Bac+3</option>
                    </select> 
                    <input type="file" name="photo" ><br>
                    <input type="file" name="cv" > <br>
                    <p>
                    <div class="checkbox-group">
                        <input type="checkbox" id="niveau3" name="niveau3" value="nv3">
                        <label for="niveau3">3ème année</label>
                        <input type="checkbox" id="niveau4" name="niveau4" value="nv4">
                        <label for="niveau4">4ème année</label>
                    </div><br>
                    <input type="text" placeholder="Établissement" name="etablissement" required><br>
                    <input type="submit" name="confirmer" value="Confirmer"><br>
                    
                </div>
</form>

<button type="button" onclick=reconnecter() >Se Reconnecter</button>
    
</body>
</html>
