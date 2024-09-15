  <?php
  
  class userController{
    private $user ;
    private $db;

    function __construct($user, $db){
      $this->user= $user;
      $this->db = $db;
    }

    function SignIn($user){
       //Manual Testing
            // echo "Data submitted </br> </br>";
            $connexion = $this->db->connect();
            $user->token = rand(0000,9999);
            // echo "<script>console.log(".$user->token.")</script>";
            $user->verifStatus = false;
            $user->nom = $_POST['nom'];
            $user->prenom = $_POST['prenom'];
            $user->log = $_POST['log'];
            $user->email = $_POST['email'];
            $user->mdp = crypt($_POST['mdp'],'blowfish');
            $user->naissance = $_POST['naissance'];
            $user->diplome = $_POST['diplome'];
            $user->etab = $_POST['etab'];
        
            // Call function Verifylevel()
            $niveau3=$_POST['niveau3'];
            $niveau4=$_POST['niveau4'];
            $niveau = verifyLevel($niveau3 , $niveau4);  
            $user->niveau = $niveau;
            echo "<br> le niveau d'user :" . $user->niveau . "</br>" ;
        
            // Uploading Files
            uploadFiles($_FILES['photo'], $_FILES['cv'] , $user);

            $_SESSION['user'] = serialize($user);
         
            // if($connexion) echo '</br> </br> Connexion is Working </br>';

            $tokenpdf = CreatefpdfToken($user->token);
            //just For testing
            if($tokenpdf){
              echo "pdf is created";
            } else { echo "There is a problem with the pdf";}

            // Inserting Depending on the Application
            if($user->niveau==='3'){
              $this->db->insertData($user , $connexion, 'etud3a');
              if(sendMail($user->nom , $user->prenom , $user->email , $tokenpdf)){
                header('Location:../Verify_account.html');
                exit();
              };} else if($user->niveau==='4'){
              $this->db->insertData($user , $connexion , 'etud4a');
              if(sendMail($user->nom , $user->prenom , $user->email , $tokenpdf)){
                header('Location:../Verify_account.html');
                exit();
              };} else if($user->niveau === '3 et 4'){
              // Constraint : The user should have a diplome of bac+3 and have an application for both the 3thrd year and the 4th year
              if($user->diplome === 'Bac+2'){
                $this->db->insertData($user , $connexion , 'etud3a');
                $this->db->insertData($user , $connexion , 'etud4a');
                if(sendMail($user->nom , $user->prenom , $user->email , $tokenpdf)){
                  header('Location:../Verify_account.html');
                  exit();
                };
        
              } else{
                echo '<alert>Un etudiant Bac+3  peut pas présenter sa candidature en 3ème et 4ème année en même temps.</alert>';
              }
            }
        
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