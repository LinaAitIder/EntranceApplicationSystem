<?php
try {
ob_start();
session_start();
// Inclusion de la bibliothèque FPDF
require('fpdf186/fpdf.php');

$data=$_SESSION['recap_etud'];
echo "<br>";
if (isset($_SESSION['recap_etud'])) {
    $result = $_SESSION['recap_etud'];
    $id=$result['ID'];
    $nom = $result['nom'];
    $prenom = $result['prenom'];
    $email = $result['email'];
    $date = $result['naissance'];
    $diplome = $result['diplome'];
    $niv= $result['niveau'] ;
    $etab = $result['etablissement'];

$pdf = new FPDF();
$pdf->AddPage();

// Titre
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Information de Condidature', 0, 1, 'C');

// Informations 
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Identifiant : ' . $id , 0, 1);
$pdf->Cell(0, 10, 'Nom : ' . $nom, 0, 1);
$pdf->Cell(0, 10, 'Prénom : ' . $prenom, 0, 1);
$pdf->Cell(0, 10, 'Date de naissance : ' . $date, 0, 1);
$pdf->Cell(0, 10, 'Diplôme : ' . $diplome, 0, 1);
if ($result['niveau'] == "nv3") {$pdf->Cell(0, 10, 'Condidature : ' . "3éme année", 0, 1);} 
else {$pdf->Cell(0, 10, 'Condidature : ' . "4éme année", 0, 1);    }
$pdf->Cell(0, 10, 'Etablissement : ' . $etab, 0, 1);
$pdf->Cell(0, 10, 'Email : ' . $email, 0, 1);

// Nom du fichier PDF généré
$filename = 'Reçu de Condidature' . date('Y-m-d_H-i-s') . '.pdf';
}
ob_end_clean();
} catch (Exception $e) {
    echo 'Exception: ',  $e->getMessage(), "\n";
}

$pdf->Output($filename, 'D');

?>
