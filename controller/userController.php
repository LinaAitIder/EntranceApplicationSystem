  <?php

  class userController{
    private $user;
    private $db;

    function __construct($user, $db){
      $this->user= $user;
      $this->db = $db;
    }

    function SignIn(){
      $connexion = $this->db->connect();
      $this->user->token = rand(0000,9999);

      $this->user->verifStatus = false;
      $this->user->nom = $_POST['nom'];
      $this->user->prenom = $_POST['prenom'];
      $this->user->log = $_POST['log'];
      $this->user->email = $_POST['email'];
      $this->user->mdp = password_hash($_POST['mdp'],PASSWORD_BCRYPT);
      $this->user->naissance = $_POST['naissance'];
      $this->user->diplome = $_POST['diplome'];
      $this->user->etab = $_POST['etab'];
  
  
      $niveau = verifyLevel($_POST['niveau3'] , $_POST['niveau4']);  
      $this->user->niveau = $niveau;
    
      uploadFiles($_FILES['photo'], $_FILES['cv'] , $this->user);

      $_SESSION['user'] = serialize($this->user);
    
      $tokenpdf = CreatefpdfToken($this->user->token);

      if($tokenpdf){
        echo "pdf is created";
      } else { echo "<script>alert('There is a problem with the pdf');</script>";}
      
      if($this->user->niveau==='3'){
              $this->db->insertData($this->user , 'etud3a');
              if(sendMail($this->user->nom , $this->user->prenom , $this->user->email , $tokenpdf)){
                header('Location:./View/accountVerification.php');
                exit();
              };} else if($this->user->niveau==='4'){
              $this->db->insertData($this->user  , 'etud4a');
              if(sendMail($this->user->nom , $this->user->prenom , $this->user->email , $tokenpdf)){
                header('Location:./View/accountVerification.php');
                exit();
              };} else if($this->user->niveau === '3 et 4'){
              // Constraint : The user should have a diplome of bac+3 and have an application for both the 3thrd year and the 4th year
              if($this->user->diplome === 'Bac+2'){
                $this->db->insertData($this->user  , 'etud3a');
                $this->db->insertData($this->user  , 'etud4a');
                if(sendMail($this->user->nom , $this->user->prenom , $this->user->email , $tokenpdf)){
                  header('Location:./View/accountVerification.php');
                  exit();
                };
        
              } else{
                echo '<script>alert("Un etudiant Bac+3  peut pas présenter sa candidature en 3ème et 4ème année en même temps.");</script>';
                header('Location:View/authentification.php');
              }
            }
    
        
    }

    function displayUserInfo(){
      $userInformations=  $this->user->getUserInformation($this->db);
      /* echo $this->user->log;
      if ($userInformations) {
        echo "Data fetched successfully: ";
        print_r($userInformations); // Print array for debugging
      } else {
          echo "No data returned.";
      }
      */
      $niveau = nameLevel($userInformations['niveau']);
      userView::renderRecap($userInformations, $niveau);
            
    }

    function updateUserInfo($newUserInfo){
      //Update the user object information
      $this->user->nom = $_POST['nom'];
      $this->user->prenom = $_POST['prenom'];
      $this->user->log = $_POST['log'];
      $this->user->email = $_POST['email'];
      $this->user->mdp = password_hash($_POST['mdp'] , PASSWORD_BCRYPT); // securite
      $this->user->naissance = $_POST['naissance'];
      $this->user->diplome = $_POST['diplome'];
      $this->user->etab = $_POST['etab'];
      
      // Updating level [In DB]
      $niveau3=$_POST['niveau3'];
      $niveau4=$_POST['niveau4'];
      $niveau = verifyLevel($niveau3 , $niveau4);  
      $this->user->niveau = $niveau;
    
      // Uploading Files
      uploadFiles($_FILES['photo'], $_FILES['cv'] , $this->user);
     
      // SERIALIZE THE this->user OBJECT IN THE SESSION
      $_SESSION['user'] = serialize($this->user);
      
    }

    public static function getId($connexion , $user){
      $query = "SELECT id FROM etud3a, etud4a Where login= :log";
      $stmt = $connexion->prepare($query);
      $result = $stmt->execute(['log', $user->login]);

    }

    
  }

?>