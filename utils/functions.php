<?php

function pageAccess($userUrl , $adminUrl){
  if(isset($_SESSION['userType'])) {
      if($_SESSION['userType'] === 'etud') {
          header("location:$userUrl");
          exit; 
      } else if($_SESSION['userType'] === 'admin') {
          header("location:$adminUrl");
          exit; 
      }
  }
}

function displayErrors($errors){
    if(!empty($errors)){
      foreach($errors as $error){
        echo "<script>alert('.$error.');</script>" ;
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
    echo "<script> console.log('Cv Erreur : $cvError , Photo Erreur : $photoError');</script>";

    $errors=[];
    //Verification type of files
    $validPhotoTypes = ['image/jpg' , 'image/png', 'image/jpeg'];

    if($cvType !=='application/pdf'){
      $errors[] = 'Veuillez entrez un fichier acceptable de type pdf le fichier que vous avez fournit est de type ::'.$cvType;
    }
    if (!in_array($photoType, $validPhotoTypes)){
      $errors[] = 'Veuillez entrez un fichier acceptable de type jpg , png ou jpeg , le fichier que vous avez fournit est de type ::'.$photoType;
    }

    //Limit file size
    $cvMaxSize = 2 * 1024 * 1024;
    $photoMaxSize = 8 * 1024 * 1024;
    if($cvSize > $cvMaxSize ){
      $errors[] = 'Veuillez entrer des fichiers qui ne depasse pas 2Mo ';
    }
    if($photoSize > $photoMaxSize){
      $errors[] = 'Veuillez entrer des fichiers qui ne depasse pas 8Mo ';
    }
    // Display errors if there are any
    if(!empty($errors)){
      displayErrors($errors);
    } else{
      //Create the uploads folder
      $uploadDir = "uploads/";
      // echo $uploadDir;
      // Create upload directory if there is none
      if(!is_dir($uploadDir)){
        mkdir($uploadDir , 0777, true);
      }
  
      $uploadPathCv= $uploadDir . $cvName;
      $uploadPathPhoto= $uploadDir . $photoName;

      //Moving Files Verifivation Path
      // echo "</br> Attempting to move files </br>";
      // echo "</br> cv temporary path : $cvTmpName , photo temporary path : $photoTmpName </br> ";
      // echo "</br>Upload path Cv : $uploadPathCv , Upload path  :Photo $uploadPathPhoto</br>";
      
      if($cvError === UPLOAD_ERR_OK && $photoError === UPLOAD_ERR_OK){
        $uploadCOk = move_uploaded_file($cvTmpName,$uploadPathCv);
        $uploadPOk = move_uploaded_file($photoTmpName, $uploadPathPhoto);
        //Testing 
        if($uploadCOk &&   $uploadPOk){
          echo "<script>console.log('Les fichier ont ete telechargee!')</script>";
        }
        else {
          echo "<script>console.log('les fichiers ne sont pas uploader!')</script>";
        }
        
        $user->cv = $uploadPathCv ;
        $user->photo = $uploadPathPhoto;
      } 
   
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
    echo "<script>console.log('aucun niveau n'a ete selectionne !');</script>";
  }
  return $niveau;
}

function generateCandidateApplication($data , $niveau){
 
  
  $pdf = new Fpdf();
  $pdf->AddPage();
   
  $pdf->Image($data['photo'],10,5,30);
  $pdf->SetFont('Arial','B',15);
  $pdf->Cell(80);
  $pdf->Cell(40, 40, 'Information de Condidature', 0, 1, 'C');
  $pdf->Ln(20);

  // Informations 
  $pdf->SetFont('Arial', '', 12);
  $pdf->Cell(0, 10, 'Identifiant : ' . $data['id'], 0, 1);
  $pdf->Cell(0, 10, 'Nom : ' . $data['nom'], 0, 1);
  $pdf->Cell(0, 10, 'Prénom : ' . $data['prenom'], 0, 1);
  $pdf->Cell(0, 10, 'Date de naissance : ' . $data['naissance'], 0, 1);
  $pdf->Cell(0, 10, 'Diplôme : ' . $data['diplome'] , 0, 1);
  $pdf->Cell(0, 10, 'niveau : ' . $niveau , 0, 1);

  //level required
  $pdf->Cell(0, 10, 'Etablissement : ' . $data['etablissement'], 0, 1);
  $pdf->Cell(0, 10, 'Email : ' . $data['email'], 0, 1);

  // Nom du fichier PDF généré
  $filename = 'Reçu de Condidature' . date('Y-m-d_H-i-s') . '.pdf';


  $pdf->Output($filename , 'D');
  exit;
}

function nameLevel($niveau){
  if($niveau === "3"){
    $niveau ="3ème année";
    return $niveau;
  } 
  else if ($niveau === "4"){
      $niveau ="4ème année";
      return $niveau;
  } 
  else{
      $niveau ="3ème année et 4ème année";
      return $niveau;
  }

}

?>