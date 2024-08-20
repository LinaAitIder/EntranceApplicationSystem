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
function displayErrors($errors){
    if(!empty($errors)){
      foreach($errors as $error){
        echo $error.'</br>' ;
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

    // Track Any Errors
    echo "Cv Error : $cvError , Photo Error : $photoError";

    $errors=[];
    //Verification type of files
    $validPhotoTypes = ['image/jpg' , 'image/png', 'image/jpeg'];
    if($cvType !=='application/pdf'){
      $errors[] = 'Veuillez entrez un fichier acceptable de type pdf the file you uploaded is of type :'.$cvType;
    }
    if (!in_array($photoType, $validPhotoTypes)){
      $errors[] = 'Veuillez entrez un fichier acceptable de type jpg , png ou jpeg , the file you uploaded is of type :'.$photoType;
    }

    //Limit file size
    $cvMaxSize = 2 * 1024 * 1024;
    $photoMaxSize = 8 * 1024 * 1024;
    if($cvSize > $cvMaxSize || $photoSize > $photoMaxSize){
      $errors[] = 'Veuillez entrer des fichiers de taille acceptable';
    }

    // Display errors if there are any
    if(!empty($errors)){
      displayErrors($errors);
    } else{
      //Create the uploads folder
      $uploadDir = "../uploads/";
      echo $uploadDir;
      if(!is_dir($uploadDir)){
        mkdir($uploadDir , 0777, true);
      }
  
      $uploadPathCv= $uploadDir . $cvName;
      $uploadPathPhoto= $uploadDir . $photoName;

      //Moving Files Verifivation Path
      echo "</br> Attempting to move files </br>";
      echo "</br> cv temporary path : $cvTmpName , photo temporary path : $photoTmpName </br> ";
      echo "</br>Upload path Cv : $uploadPathCv , Upload path  :Photo $uploadPathPhoto</br>";
      
      //Ensure there are no errors before moving the files
      if($cvError === UPLOAD_ERR_OK && $photoError === UPLOAD_ERR_OK){
        $uploadCOk = move_uploaded_file($cvTmpName,$uploadPathCv);
        $uploadPOk = move_uploaded_file($photoTmpName, $uploadPathPhoto);
        if($uploadCOk &&   $uploadPOk){
          echo " Les fichier sont bien telecharge";
        }
        else {
          echo 'les fichiers ne sont pas uploader!';
        }
        $user->cv = $uploadPathCv ;
        $user->photo = $uploadPathPhoto;
      } else {
        echo "File upload errors prevented moving files.";
      }
   
    
    
      // Just to test
     
      
    
      ;
    }
}
function verifyLevel($niveau3 , $niveau4){
  if(isset($niveau3) && isset($niveau4)) {
    $niveau = '3 et 4';
  } else if(isset($niveau3) || isset($niveau4)){
    if(isset($niveau4)){
      $niveau = '4';
    } else if(isset($niveau3)){
      $niveau = '3';
    }
  } else{
    echo "Aucun iveau n'a ete selectionne !";
  }
  return $niveau;
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