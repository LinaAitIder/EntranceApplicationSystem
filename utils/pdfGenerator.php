<?php
require_once('.\fpdf186\fpdf.php');
class PDF extends FPDF
{
  public $headerTitle;
  // En-tête
  function Header()
  {
      $this->SetFont('Arial','B',15);
      $this->Cell(80);
      $this->Cell(100,10,$this->headerTitle,1,0,'C');
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
  $pdf = new PDF;
  $pdf->headerTitle = 'Information de Condidature';
  if(isset($userSession)){
    $data = unserialize($userSession);
  
    $pdf = new Fpdf();
    $pdf->AddPage();
  
  
    $photo = '../'.$data->photo;
    $niveau = nameLevel($data->niveau);
  
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
    $pdf->Image($photo,10,5,50);
  
    // Nom du fichier PDF généré
    $filename = 'Reçu de Condidature' . date('Y-m-d_H-i-s') . '.pdf';
  
  
    $pdf->Output();
    exit;
   } else {
    echo "this session doesn't work !";
   }
  
}

$action = $_GET['action'];
if($action === 'generateRecap'){
  CreateRecap();
}

?>
