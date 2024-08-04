<?php  
require 'utils/functions.php';
require 'data/ConnectFunc.php';
require 'data/userData.php';
require 'Token_code.php';
require 'Mail_Handler.php';
session_start();
pageAccess();

$db = new Database;
$user = new User ;
if (isset($_POST['submit'])) {
  $user->nom = $_POST['nom'];
  $user->prenom = $_POST['prenom'];
  $user->$login = $_POST['log'];
  $user->$email = $_POST['email'];
  $user->$pass = crypt($_POST['mdp'],'blowfish');
  $user->$date = $_POST['naissance'];
  $user->$diplome = $_POST['diplome'];
  // $user->$nv3 = isset($_POST['niveau3']) ;
  // $user->$nv4 = isset($_POST['niveau4']) ;
  $user->$etab = $_POST['etablissement'];
 
  uploadFiles($_FILES['photo'], $_FILES['cv'] , $user);
}
//email Verification with token
insertData($user , $db);







  

    
    // if ($nv3 && !$nv4) { 
    //     $niveau = 'nv3';
    // } elseif ($nv4 && !$nv3) { 
    //     $niveau = 'nv4';
    // } elseif (!$nv3 && !$nv4) { 
    //     echo "<script>alert('Choisissez un seul niveau!');</script>";
    //     header("refresh:5;url=Inscription.php");
    //     return; 
    // }

    // // Random value for token 
    // $randomNumber = rand(1, 9999);
    // $token =  $randomNumber;

    // Level input Verification + Insertion to database
    // if ( $diplome && $nv3 && $nv4) {
    //     if ($diplome=='Bac+3') echo "<script>alert('Vous ne pouvez pas choisir les deux niveaux en tant que Candidat de BAC+3')</script>";
    //     elseif ($diplome=='Bac+2') {
    //             // Insertion into etud3a : Candidature 3eme annees
    //             $niveau = 'nv3';
    //             try{
    //             $sql = "INSERT INTO etud3a (nom, prenom, email, naissance, diplome, niveau, etablissement, photo, cv, log, mdp, token) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    //             $stmt = $connexion->prepare($sql);
    //             $reg1= $stmt->execute([$nom, $prenom, $email, $date, $diplome, $niveau, $etab, $photoPath, $cvPath, $login, $pass, $token]) ;
    //             // Verification de l'insertion
    
    //             // Insertion into etud3a : Candidature 4eme annees
    //             $niveau = 'nv4';
    //             $sql = "INSERT INTO etud4a (nom, prenom, email, naissance, diplome, niveau, etablissement, photo, cv, log, mdp, token) VALUES (?,? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    //             $stmt = $connexion->prepare($sql);
    //             $reg2 =$stmt->execute([$nom, $prenom, $email, $date, $diplome, $niveau, $etab, $photoPath, $cvPath, $login , $pass , $token]);
    //             } catch (PDOException $e) {
    //                 if ($e->errorInfo[1] === 1062) { 
    //                     echo '<script>alert("Vous etes deja inscrit!");</script>';
    //                     header("Refresh:5; url=authen.php");
    //                 } else {  
    //                     echo "Une erreur est survenue : " . $e->getMessage(); 
    //                 }
    //             }
    //             if($reg1 && $reg2) {
    //                 echo "<script>alert('Inscription enregistree!');</script>";    
    //                 $Tpdf=CreatefpdfToken($token);
    //                 if(sendmail($nom , $prenom ,$email , $Tpdf)){
    //                     header("Refresh:5; url=Verify_account.php?code=$token");
    //                     exit();
    //                 }
    //                 else {
    //                     echo "<script>alert('Erreur : Email pas envoye!')</script>";
    //                 }
    //             }
    //       // Verification de l'insertion
    //  }}
    // elseif ($diplome && ($nv3 || $nv4)) {
    //     $table = $niveau === 'nv3' ? 'etud3a' : 'etud4a';
    //     try {
    //         $sql = "INSERT INTO $table (nom, prenom, email, naissance, diplome, niveau, etablissement, photo, cv, log , mdp, token) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    //         $stmt = $connexion->prepare($sql);
    //         if ($stmt->execute([$nom, $prenom, $email, $date, $diplome, $niveau, $etab,  $photoPath, $cvPath, $login, $pass, $token])) {
    //             echo "<script>alert('Inscription enregistree');</script>";    
    //             $Tpdf=CreatefpdfToken($token);
    //             if(sendmail($nom , $prenom ,$email , $Tpdf)){
    //                 echo '<script>alert("Message envoye!");</script>';
    //                 header("Refresh:5; url=Verify_account.php?code=$token");
    //                 exit();
    //             }
    //             else {
    //                 echo "<script>alert('Erreur : Email pas envoye!')</script>";
    //             }
    //         }
    //     } catch (PDOException $e) {
    //         // Check if the error is related to a unique constraint violation
    //         if ($e->errorInfo[1] === 1062) {     
    //              echo "<script>alert('Vous etes deja inscrit!')</script>";
    //         } else {
    //             // If it's another type of error, you can handle it differently
    //             echo "Une erreur est survenu: " . $e->getMessage();
    //         }
    //     }
    // }




?>