<?php

require_once('../utils/functions.php');
require_once('./../View/recap.php');


$userLogin =$_SESSION['recap_etud']['log'];
echo $userLogin;
$user = new User();


if (isset($_POST['confirmer'])) {
   
    // Retrieving data form 
    $user->nom = $_POST['nom'];
    $user->prenom = $_POST['prenom'];
    $user->log = $_POST['log'];
    $user->email = $_POST['email'];
    $user->mdp = password_hash($_POST['mdp'] , PASSWORD_DEFAULT); // securite
    $user->naissance = $_POST['naissance'];
    $user->diplome = $_POST['diplome'];
    $user->etab = $_POST['etab'];
    
    // Updating level [In DB]
    // Call function Verifylevel()
    $niveau3=$_POST['niveau3'];
    $niveau4=$_POST['niveau4'];
    $niveau = verifyLevel($niveau3 , $niveau4);  
    $user->niveau = $niveau;
    echo "<br> le niveau d'user :" . $user->niveau . "</br>" ;

    // Uploading Files
    uploadFiles($_FILES['photo'], $_FILES['cv'] , $user);
    if($user->log !== $_SESSION['recap_etud']['log']){
      //Verify if log already exists in database 
      $_SESSION['recap_etud']['log'] = $user->log;
    }
    // SERIALIZE THE USER OBJECT IN THE SESSION
    $_SESSION['user'] = serialize($user);
 

    // Updating Data

     try { 
        $db->updateData($user , $connexion, $userLogin);
        header("refresh:8; url='../View/recap.php'");
      } catch(Exception $error){
        echo 'Error : '. $error->getMessage();
      };
    
   
    //email Verification with token

  
}

 
?>

