<?php 
  class authController {
     private $db;
     private $user;

     function __construct($db , $user){
        $this->db = new Database;
        $this->user = $user;
     }

     function login($login , $pass){
      $connexion= $this->db->connect();
      $query="SELECT * FROM etud3a WHERE log = :login Union SELECT * FROM etud4a WHERE log = :login";
      $stmt = $connexion->prepare($query);
      $stmt->execute(['login' => $login ]); 
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if($result){
        $this->user->createUser($result);
        $_SESSION['user'] = serialize($this->user);
        echo $result['log'];
        echo $result['mdp'];

   
        if (password_verify($pass, $result['mdp'])) {
            $_SESSION['userType'] = 'etud';
            header("Location:./View/recap.php?login=".$login);
        } else {
            header("Location:./View/authentification.php?error=wrong_password");
        }
      } else{
        header("Location:./View/authentification.php?error=not_existing");
      }
     }  

     function verifyAccount(){
      $connexion = $this->db->connect();

      echo "<script> console.log('le nom d'utilisateur :".$this->user->nom."); </script>";

      $codeInput = trim($_POST['tokenCode']);
      $tokenStored = trim($this->db->getToken($this->user, $connexion));

      echo "<script> console.log('le code saisie par utilisateur : ". htmlspecialchars($codeInput) ."'); </script>";
      echo "<script> console.log('le code de verification aleartoire : :".htmlspecialchars($tokenStored)."'); </script>";

      if($codeInput === $tokenStored){
          $this->user->verifStatus = true;
          $this->user->token = $codeInput;
          
          $this->db->updateVerifStatus($this->user);
          $_SESSION['userType'] = 'etud';

          header("Location:./View/authentification.php");
          exit();
      } else {
          echo "<script src='errorMessage.js'></script>";
          echo "<script>CodeVerifError();</script>";
          header("Location:./View/Verify_account.php?error=codeNotMatching");
      }
     }

  }
?>