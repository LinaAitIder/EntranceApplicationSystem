<?php

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  require 'pdf.php';

  $action = $_GET['action'];
  

  function CreatefpdfToken($token){
      $pdf = new PDF;
      $pdf->headerTitle = 'Code de Verification';
      $pdf->AliasNbPages();
      $pdf->AddPage();
      $pdf->SetFont('Times','',12);
      $pdf->Cell(0,10,"Votre code de verification : $token",0,1);
      #return $pdf;
      $filename='./uploads/CodeConfirmation.pdf';
      $pdf->Output('F', $filename);  // Save to a file
      return $filename;
  }

  function CreateRecap(){
    require '../data/user.php';
    require '../utils/functions.php';
    $pdf = new PDF;
    $pdf->headerTitle = 'Information de Candidature :';
    if(isset($_SESSION['user'])){
      $data = unserialize($_SESSION['user']);
      $pdf->AddPage();
    
    
      $photo = '../'.$data->photo;
      $niveau = nameLevel($data->niveau);
    
      // Informations 
      $pdf->SetFont('Times', '', 14);
      // $pdf->Cell(0, 10, 'Identifiant : ' . $data->id, 0, 1);
      $pdf->Cell(0, 10, 'Nom : ' . $data->nom, 0, 1);
      $pdf->Cell(0, 10, 'Prenom : ' . $data->prenom, 0, 1);
      $pdf->Cell(0, 10, 'Date de naissance : ' . $data->naissance, 0, 1);
      $pdf->Cell(0, 10, 'Diplome : ' . $data->diplome , 0, 1);
      $pdf->Cell(0, 10, 'niveau : ' .$niveau , 0, 1);
    
      //level required
      $pdf->Cell(0, 10, 'Etablissement : ' . $data->etab, 0, 1);
      $pdf->Cell(0, 10, 'Email : ' . $data->email, 0, 1);
      $pdf->Image($photo,10,110,65);
    
      // Nom du fichier PDF généré
      $filename = 'Reçu de Condidature_' . strtoupper($data->nom).' '. strtoupper($data->prenom)  . '.pdf';
    
    
      $pdf->Output();
      exit;
    } else {
      echo "<script>console.log('Creation de pdf Recap : Y'a eu un problem ave la session user');</script>";
    }
  }

  if($action === 'generateRecap'){
    CreateRecap();
  }

?>

