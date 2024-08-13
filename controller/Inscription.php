<?php  
require '../utils/functions.php';
include_once '../data/userData.php';
require '../data/config.php';
require './Token_code.php';


session_start();
pageAccess();

$db = new Database;
$user = new User ;

if (isset($_POST['signUp'])) {
  //Manual Testing
  echo "Data submitted </br> </br>";
  $user->token = rand(0000,9999);
  //For testing
  echo "<script>console.log(".$user->token.")</script>";
  $user->verifStatus = false;
  $user->nom = $_POST['nom'];
  $user->prenom = $_POST['prenom'];
  $user->log = $_POST['log'];
  $user->email = $_POST['email'];
  $user->mdp = crypt($_POST['mdp'],'blowfish');
  $user->naissance = $_POST['naissance'];
  $user->diplome = $_POST['diplome'];
  $user->etab = $_POST['etab'];

  // Call function Verifylevel()
  $niveau3=$_POST['niveau3'];
  $niveau4=$_POST['niveau4'];
  $niveau = verifyLevel($niveau3 , $niveau4);  
  $user->niveau = $niveau;
  echo "<br> le niveau d'user :" . $user->niveau . "</br>" ;

  // Uploading Files
  uploadFiles($_FILES['photo'], $_FILES['cv'] , $user);

  // Connecting to DB & Manual Testing
  $connexion= $db->connect();
  if($connexion) echo '</br> </br> Connexion is Working </br>';
  // tokenpdf
  $tokenpdf = CreatefpdfToken($user->token);
  //just For testing
  if($tokenpdf){
    echo "pdf is created";
  }
  else{
    echo "There is a problem with the pdf";
  }
  // Inserting Depending on the Application
  if($user->niveau==='3'){
    $db->insertData($user , $connexion, 'etud3a');
    if(sendMail($user->nom , $user->prenom , $user->email , $tokenpdf)){
      header('Verify_account.php');
    };
  } else if($user->niveau==='4'){
    $db->insertData($user , $connexion , 'etud4a');
    if(sendMail($user->nom , $user->prenom , $user->email , $tokenpdf)){
      header('Verify_account.php');
    };
  } else if($user->niveau === '3 et 4'){
    // Constraint : The user should have a diplome of bac+3 and have an application for both the 3thrd year and the 4th year
    if($user->diplome === 'Bac+2'){
      $db->insertData($user , $connexion , 'etud3a');
      $db->insertData($user , $connexion , 'etud4a');
      if(sendMail($user->nom , $user->prenom , $user->email , $tokenpdf)){
        header('Verify_account.php');
      };
    }else{
      echo '<alert>Un etudiant Bac+3  peut pas présenter sa candidature en 3ème et 4ème année en même temps.</alert>';
    }
  }
  //email Verification with token

}
else {
  echo "Data not submitted ";
}
 

//User Verification form 

if(isset($_POST['verify'])){
  $code=$_POST['tokenCode'];
  //$code_ver should be taken from the DB
  $token_ver = $db->getToken($user, $connexion);
  if($code === $token_ver ){
      $user->verifStatus = true;
      $user->token = $code;
      //Creating an update function
      $db->updateVerifStatus($user , $connexion);
      header("location: authen.php");
      exit();
  }
  else {
      echo "<script src='errorMessage.js'></script>";
      echo "<script>CodeVerifError();</script>";

  }
}

?>