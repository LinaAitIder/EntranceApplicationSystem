<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require_once('..\fpdf186\fpdf.php');


Function sendmail($nom , $prenom , $email , $tokenpdf) 
{
    $mail = new PHPMailer(true);
    try {                            
        $mail->IsSMTP();                                     
        $mail->Host = 'smtp.gmail.com';                       
        $mail->SMTPAuth = true;                               
        $mail->Username = 'testpproject12@gmail.com';            
        $mail->Password = 'sqklreubjyzmkjmf';                   
        $mail->SMTPSecure = 'ssl'  ;                    
        $mail->Port = 465;                                   
        $mail->setFrom('testpproject12@gmail.com');
        $mail->addAddress($email, "$nom $prenom");    
        $mail->addAttachment($tokenpdf); 
        $mail->isHTML(true);                                  
        $mail->Subject = 'Code Verification';
        $mail->Body    = "
        <h3><b>Verification code</b></h3> <p> Please look into the file! </p>";
        $mail->send();
        echo '<script>alert("Message envoye!");</script>';
        return 1;
    } catch (Exception $e) {
        echo "Message pas envoyee . Error: {$mail->ErrorInfo}";
        return 0;
    }
}
?>