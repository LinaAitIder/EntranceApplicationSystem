<?php
  session_start();
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  require './PHPMailer/src/Exception.php';
  require './PHPMailer/src/PHPMailer.php';
  require './PHPMailer/src/SMTP.php';
  require "controller/authController.php";
  require 'data/user.php';
  require 'data/database.php'; 

  //Account Verification

  $action = $_GET['action'];
  
  if($action === 'verifyAccount'){ 
      if(isset($_POST['verify'])){
          if(isset($_SESSION['user'])){
              $user = unserialize($_SESSION['user']);
              $authController = new authController(new Database , $user);
              $authController->verifyAccount();
            
          }  else {
            echo "user session not working";
            echo'<pre>';
            print_r($_SESSION);
            echo'</pre>';
          }
      } else {
              echo "verify data not submitted";
      }
  }

  //Sending an Email
  
  function sendmail($nom , $prenom , $email , $tokenpdf) {
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
          <h3><b>OTP Verification code</b></h3> <p> Please look into the file! </p>";
          $mail->send();
          echo '<script>alert("Message envoye!");</script>';
          return 1;
      } catch (Exception $e) {
          echo "Message pas envoyee . Error: {$mail->ErrorInfo}";
          return 0;
      }
  }
 
?>