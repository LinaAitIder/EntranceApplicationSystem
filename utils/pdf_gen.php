<?php
session_start();
require '../fpdf186/fpdf.php';
require '../data/userData.php';
require './functions.php';


// Inclusion de la bibliothèque FPDF
 if(isset($_SESSION['user'])){

  $data = unserialize($_SESSION['user']);

  $pdf = new Fpdf();
  $pdf->AddPage();

  echo $data->id;

  $photo = '../'.$data->photo;
  $niveau = nameLevel($data->niveau);

  $pdf->Image($photo,10,5,30);
  $pdf->SetFont('Arial','B',15);
  $pdf->Cell(80);
  $pdf->Cell(40, 40, 'Information de Condidature', 0, 1, 'C');
  $pdf->Ln(20);

  // Informations 
  $pdf->SetFont('Arial', '', 12);
  // $pdf->Cell(0, 10, 'Identifiant : ' . $data->id, 0, 1);
  $pdf->Cell(0, 10, 'Nom : ' . $data->nom, 0, 1);
  $pdf->Cell(0, 10, 'Prénom : ' . $data->prenom, 0, 1);
  $pdf->Cell(0, 10, 'Date de naissance : ' . $data->naissance, 0, 1);
  $pdf->Cell(0, 10, 'Diplôme : ' . $data->diplome , 0, 1);
  $pdf->Cell(0, 10, 'niveau : ' .$niveau , 0, 1);

  //level required
  $pdf->Cell(0, 10, 'Etablissement : ' . $data->etab, 0, 1);
  $pdf->Cell(0, 10, 'Email : ' . $data->email, 0, 1);

  // Nom du fichier PDF généré
  $filename = 'Reçu de Condidature' . date('Y-m-d_H-i-s') . '.pdf';


  $pdf->Output();
  exit;
 } else {
  echo "this session doesn't work !";
 }


?>
