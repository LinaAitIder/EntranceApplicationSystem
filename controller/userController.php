  <?php

  class userController{
    private $user;
    private $db;

    function __construct($user, $db){
      $this->user= $user;
      $this->db = $db;
    }

    function SignIn(){
       //Manual Testing
            // echo "Data submitted </br> </br>";
            $connexion = $this->db->connect();
            $this->user->token = rand(0000,9999);
            // echo "<script>console.log(".$user->token.")</script>";
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
            // echo "<br> le niveau d'user :" . $this->user->niveau . "</br>" ;
        
            // Uploading Files
            uploadFiles($_FILES['photo'], $_FILES['cv'] , $this->user);

            $_SESSION['user'] = serialize($this->user);
         
            // if($connexion) echo '</br> </br> Connexion is Working </br>';

            $tokenpdf = CreatefpdfToken($this->user->token);
            //just For testing
            if($tokenpdf){
              echo "pdf is created";
            } else { echo "<script>alert('There is a problem with the pdf');</script>";}
            
            // Inserting Depending on the Application
           if($this->user->niveau==='3'){
              $this->db->insertData($this->user , $connexion, 'etud3a');
              if(sendMail($this->user->nom , $this->user->prenom , $this->user->email , $tokenpdf)){
                header('Location:./View/Verify_account.php');
                exit();
              };} else if($this->user->niveau==='4'){
              $this->db->insertData($this->user , $connexion , 'etud4a');
              if(sendMail($this->user->nom , $this->user->prenom , $this->user->email , $tokenpdf)){
                header('Location:./View/Verify_account.php');
                exit();
              };} else if($this->user->niveau === '3 et 4'){
              // Constraint : The user should have a diplome of bac+3 and have an application for both the 3thrd year and the 4th year
              if($this->user->diplome === 'Bac+2'){
                $this->db->insertData($this->user , $connexion , 'etud3a');
                $this->db->insertData($this->user , $connexion , 'etud4a');
                if(sendMail($this->user->nom , $this->user->prenom , $this->user->email , $tokenpdf)){
                  header('Location:./View/Verify_account.php');
                  exit();
                };
        
              } else{
                echo '<script>alert("Un etudiant Bac+3  peut pas présenter sa candidature en 3ème et 4ème année en même temps.");</script>';
              }
            }
    
        
    }

    function displayUserInfo(){
      $connexion= $this->db->connect();
      $userInformations=  $this->user->getUserInformation($connexion);
      
      /*
      echo $this->user->log;
      if ($userInformations) {
        echo "Data fetched successfully: ";
        print_r($userInformations); // Print array for debugging
      } else {
          echo "No data returned.";
      }
      */

      $niveau = nameLevel($userInformations['niveau']);
      userView :: renderRecap($userInformations, $niveau);
            
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
      // Call function Verifylevel()
      $niveau3=$_POST['niveau3'];
      $niveau4=$_POST['niveau4'];
      $niveau = verifyLevel($niveau3 , $niveau4);  
      $this->user->niveau = $niveau;
      // echo "<br> le niveau d'this->user :" . $this->user->niveau . "</br>" ;

      // Uploading Files
      uploadFiles($_FILES['photo'], $_FILES['cv'] , $this->user);
     
      // SERIALIZE THE this->user OBJECT IN THE SESSION
      $_SESSION['user'] = serialize($this->user);
      
    }

    function deleteAccount(){    
      $connexion = $this->db->connect();
      $this->user->log =$_SESSION['recap_etud']['log'];
      $this->user->niveau=$_SESSION['recap_etud']['niveau'];
      $this->user->deleteAccount($connexion , $this->user->log , $this->user->niveau);
      $_SESSION['recap_etud']= NULL;
      session_destroy();

      header("Refresh:1; url=../View/authentification.php");
      
    }

    public static function getId($connexion , $user){
      $query = "SELECT id FROM etud3a, etud4a Where login= :log";
      $stmt = $connexion->prepare($query);
      $result = $stmt->execute(['log', $user->login]);

    }

    
  }

?>