  <?php

  class userController{
    private $user;
    public $db ;

    function __construct($user, $db){
      $this->user= $user;
      $this->db = $db;
    }


    function SignIn(){
      $connexion = $this->db->connect();
      $this->user->log = $_POST['log'];
      $this->user->email = $_POST['email'];
      // Email duplicated
      if($this->db->emailExists($this->user->email) || $this->db->logExists($this->user->log)){
        if($this->db->emailExists($this->user->email)){
          echo "<script>alert('Cet Email deja Existe!');</script>";
          header('Location:./View/authentification.php');
          exit();
        }
        if($this->db->logExists($this->user->log)){
          echo "<script>alert('Ce login deja Existe!');</script>";
          header('Location:./View/authentification.php');
        }
      }

      else {
        $this->user->token = rand(0000,9999);
        $this->user->verifStatus = false;
        $this->user->nom = $_POST['nom'];
        $this->user->prenom = $_POST['prenom'];
        $this->user->mdp = password_hash($_POST['mdp'],PASSWORD_BCRYPT);
        $this->user->naissance = $_POST['naissance'];
        $this->user->diplome = $_POST['diplome'];
        $this->user->etab = $_POST['etab'];
    
        $niveau = verifyLevel( $_POST['niveau3'] , $_POST['niveau4']);  
        $this->user->niveau = $niveau;
      
        uploadFiles($_FILES['photo'], $_FILES['cv'] , $this->user);

        $_SESSION['user'] = serialize($this->user);
      
        $tokenpdf = CreatefpdfToken($this->user->token);

        if($tokenpdf){
          echo "<script>console.log('pdf is created');</script>";
        } else { echo "<script>console.log('Il y'a un problem de generation de pdf');</script>";}
        
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
    }

    function displayUserInfo(){
      $userInformations=  $this->user->getUserInformation($this->db);
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
      
      
      $niveau = verifyLevel($_POST['niveau3'] , $_POST['niveau4']);  
      $this->user->niveau = $niveau;

      $this->user->verifStatus = true;

      // Uploading Files
      uploadFiles($_FILES['photo'], $_FILES['cv'] , $this->user);
     
      // SERIALIZE THE this->user OBJECT IN THE SESSION
      $_SESSION['user'] = serialize($this->user);
      
    }

  }

?>