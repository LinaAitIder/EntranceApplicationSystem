<?php 
  class authController {
     private $db;
     private $user;

     function login($login , $pass){
      //Verification de l'existence d'etudiant dans Bd
      $db = new Database;
      $connexion= $db->connect();

      //if($connexion) echo "Working !!";

      $query="SELECT * FROM etud3a WHERE log = :login Union SELECT * FROM etud4a WHERE log = :login";
      // if($query) echo "the query is okay!!";
      $stmt = $connexion->prepare($query);
      $stmt->execute(['login' => $login , 'mdp'=>$pass]); 
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
      if ($result && password_verify($pass, $result['mdp'])) {
          $_SESSION['recap_etud']=$result;
          $_SESSION['userType'] = 'etud';
          header("Location:./../View/recap.php?login=".$login);
      } else {
          header("Location:./../authentification.html?error=not_existing");

      }
    }


     function verifyAccount(){
      $connexion = $this->db->connect();
      ECHO "name of user :" .$this->user->nom;
      $code = trim($_POST['tokenCode']);
      $token_ver = trim($this->db->getToken($this->user, $connexion));
      echo "Entered Code: " . htmlspecialchars($code) . "<br>";
      echo "Token from DB: " . htmlspecialchars($token_ver) . "<br>";
      if($code === $token_ver ){
          $this->user->verifStatus = true;
          $this->user->token = $code;
          //Creating an update function
          $this->db->updateVerifStatus($this->user , $connexion);
          $_SESSION['USER'] == 'etud';
          echo "I guess the problem is in the header";
          header("Location: ../View/authen.html");
          exit();
      }
      else {
          echo "<script src='errorMessage.js'></script>";
          echo "<script>CodeVerifError();</script>";
          echo " pas le mm code";
  
      }
     }

     function logout(){
        session_start();
        session_destroy();
        header("location: ../authentification.html");
     }
  }
?>