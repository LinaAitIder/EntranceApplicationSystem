<?php
session_start();
require '../fpdf186/fpdf.php';
// Inclusion de la bibliothèque FPDF
 if(isset($_SESSION['recap_etud'])){
  $data = $_SESSION['recap_etud'];
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
  $pdf->Cell(0, 10, 'niveau : ' .$data['nivName']  , 0, 1);

  //level required
  $pdf->Cell(0, 10, 'Etablissement : ' . $data['etablissement'], 0, 1);
  $pdf->Cell(0, 10, 'Email : ' . $data['email'], 0, 1);

  // Nom du fichier PDF généré
  $filename = 'Reçu de Condidature' . date('Y-m-d_H-i-s') . '.pdf';


  $pdf->Output();
  exit;
 }


?>
