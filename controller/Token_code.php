<?php
require_once('..\fpdf186\fpdf.php');
class PDF extends FPDF
{
// En-tête
function Header()
{
   
    $this->SetFont('Arial','B',15);
    $this->Cell(80);
    $this->Cell(100,10,'code de verification',1,0,'C');
    $this->Ln(20);
}

// Pied de page
function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

function CreatefpdfToken($token){
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','',12);
    $pdf->Cell(0,10,"Votre code de verification : $token",0,1);
    #return $pdf;
    $filename='CodeConfirmation.pdf';
    $pdf->Output('F', $filename);  // Save to a file
    return $filename;

}

?>

