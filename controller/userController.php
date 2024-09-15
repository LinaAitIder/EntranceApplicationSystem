  <?php
  
  class userController{
    private $user ;
    private $db;

    function __construct($user, $db){
      $this->user= $user;
      $this->db = $db;
    }

    function SignIn(){

    }

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
          $_SESSION['USER'] = 'etud';
          header("Location:./../View/recap.php?login=".$login);
      } else {
          header("Location:./../authentification.html?error=not_existing");

      }
    }
            
        
  

    function deleteAccount(){    
      $connexion = $this->db->connect();
      $this->user->log =$_SESSION['recap_etud']['log'];
      $this->user->niveau=$_SESSION['recap_etud']['niveau'];
      $this->user->deleteAccount($connexion , $this->user->log , $this->user->niveau);
      $_SESSION['recap_etud']= NULL;
      session_destroy();

      header("Refresh:1; url=../View/authen.html");
      
    }

    function logout(){
      session_destroy();
      header('Location:../index.html');
    }

     public static function showAllUsers(){
      $db = new Database();
      $connexion = $db->connect();
      $users = User::getAllUsers($connexion);
      
      // Pass data to the View
      echo UserView::renderUserList($users);
      
    }

    public static function SearchUser($user ,$db){
      $connexion = $db->connect();
      $existingUsers = User::SearchUsers($connexion, $user);
      echo UserView::showFoundUsers($existingUsers);
    }

  }

?>