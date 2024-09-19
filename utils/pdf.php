<?php
 require_once 'fpdf186/fpdf.php'; 

class PDF extends FPDF
{
  public $headerTitle;
  // En-tête
  function Header()
  {     
      $this->SetFont('Times','UB',25);
      $this->Cell(100,10,$this->headerTitle,0,0);
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

?>