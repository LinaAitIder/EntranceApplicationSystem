<?php 
  class authController {
     private $db;
     private $user;

     function __construct($db , $user){
        $this->db = $db;
        $this->user = $user;
     }

     function login($login , $pass){
      //Verification de l'existence d'etudiant dans Bd
      $db = new Database;
      $connexion= $db->connect();
    
      //if($connexion) echo "Working !!";

      $query="SELECT * FROM etud3a WHERE log = :login Union SELECT * FROM etud4a WHERE log = :login";
      // if($query) echo "the query is okay!!";
      $stmt = $connexion->prepare($query);
      $stmt->execute(['login' => $login ]); 
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if($result){

        $user = new User;
        $user->createUser($result);
        $_SESSION['user'] = serialize($user);
        echo '<pre>';
        print_r($_SESSION);  //rint out session data for debugging
        echo '</pre>';

        if (password_verify($pass, $result['mdp'])) {
            $_SESSION['userType'] = 'etud';
            header("Location:./View/recap.php?login=".$login);
        } else {
            header("Location:./View/authentification.php?error=wrong_password");

        }
      }
      else{
        header("Location:./View/authentification.php?error=not_existing");
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
          $this->db->updateVerifStatus($this->user);
          $_SESSION['userType'] = 'etud';
          echo "I guess the problem is in the header";
          header("Location:./View/authentification.php");
          exit();
      }
      else {
          echo "<script src='errorMessage.js'></script>";
          echo "<script>CodeVerifError();</script>";
          header("Location:./View/Verify_account.php?error=codeNotMatching");
  
      }
     }

     function logout(){
        session_start();
        session_destroy();
        header("location: ../View/authentification.php");
     }
  }
?>