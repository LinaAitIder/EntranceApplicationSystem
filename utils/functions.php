<?php
function pageAccess(){
  if(isset($_SESSION['USER'])) {
      // Redirect based on the user type
      if($_SESSION['USER'] == 'etud') {
          header("location:recap.php");
          exit; // Terminate script execution after redirection
      } elseif($_SESSION['USER'] == 'admin') {
          header("location:administration.php");
          exit; // Terminate script execution after redirection
      }
  }
}
function dislayErrors($errors){
    if(!empty($errors)){
      foreach($errors as $error){
        echo '<alert>' .$error.'</alert>' ;
      }
    }
  };
  function uploadFiles($photo , $cv , $user){
    //Manage Image
    $photoName = $photo['name'];
    $photoTmpName = $photo['tmp_name'];
    $photoSize = $photo['size'];
    $photoError = $photo['error'];
    $photoType=$photo['type'];
  
    // Manage cv
    $cvName = $cv['name'];
    $cvTmpName = $cv['tmp_name'];
    $cvSize = $cv['size'];
    $cvError = $cv['error'];
    $cvType=$cv['type'];
  
    //Verification type of files
    $validPhotoTypes = ['jpg' , 'png', 'jpeg'];
    if($cvType !=='pdf'){
      $errors[] = 'Veuillez entrez un fichier acceptable de type pdf';
    }
    if (!in_array($photoType, $validPhotoTypes)){
      $errors[] = 'Veuillez entrez un fichier acceptable de type jpg , png ou jpeg';
    }
    //Limit file size
    $cvMaxSize = 2 * 1024 * 1024;
    $photoMaxSize = 8 * 1024 * 1024;
    if($cvSize > $cvMaxSize || $photoSize > $photoMaxSize){
      $errors[] = 'Veuillez entrer des fichiers de taille acceptable';
    }
    // Display errors if there are any
    if(!empty($errors)){
      dislayErrors($errors);
    } else{
      //Create the uploads folder
      $uploadDir = 'uploads/';
      if(!is_dir($uploadDir)){
        mkdir($uploadDir , 0777, true);
      }
  
      $uploadPathCv= $uploadDir . $cvName;
      $uploadPathPhoto= $uploadDir . $photoName;
  
      $uploadCOk = move_uploaded_file($cvTmpName, $uploadPathCv);
      $uploadPOk = move_uploaded_file($photoTmpName, $uploadPathPhoto);
      // Just to test
      if($uploadCOk &&   $uploadPOk){
        echo "<alert> Les fichier sont bien telecharge</alert>";
      }
      $user->cv = $uploadPathCv ;
      $user->photo = $uploadPathPhoto;
      ;
    }
}
// }
// function retrieveFormData($postData , $fileData){
//     if (isset($submit)) {
//       $nom = $_POST['nom'];
//       $prenom = $_POST['prenom'];
//       $login = $_POST['log'];
//       $email = $_POST['email'];
//       $pass = crypt($_POST['mdp'],'blowfish');
//       $date = $_POST['naissance'];
//       $diplome = $_POST['diplome'];
//       $nv3 = isset($_POST['niveau3']) ;
//       $nv4 = isset($_POST['niveau4']) ;
//       $etab = $_POST['etablissement'];
//       uploadFiles($_FILES['photo'], $_FILES['cv']);
//     }
//   };
?>