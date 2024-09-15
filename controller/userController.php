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
                header('Location:./View/Verify_account.html');
                exit();
              };} else if($this->user->niveau==='4'){
              $this->db->insertData($this->user , $connexion , 'etud4a');
              if(sendMail($this->user->nom , $this->user->prenom , $this->user->email , $tokenpdf)){
                header('Location:./View/Verify_account.html');
                exit();
              };} else if($this->user->niveau === '3 et 4'){
              // Constraint : The user should have a diplome of bac+3 and have an application for both the 3thrd year and the 4th year
              if($this->user->diplome === 'Bac+2'){
                $this->db->insertData($this->user , $connexion , 'etud3a');
                $this->db->insertData($this->user , $connexion , 'etud4a');
                if(sendMail($this->user->nom , $this->user->prenom , $this->user->email , $tokenpdf)){
                  header('Location:./View/Verify_account.html');
                  exit();
                };
        
              } else{
                echo '<script>alert("Un etudiant Bac+3  peut pas présenter sa candidature en 3ème et 4ème année en même temps.");</script>';
              }
            }
        
    }


    function deleteAccount(){    
      $connexion = $this->db->connect();
      $this->user->log =$_SESSION['recap_etud']['log'];
      $this->user->niveau=$_SESSION['recap_etud']['niveau'];
      $this->user->deleteAccount($connexion , $this->user->log , $this->user->niveau);
      $_SESSION['recap_etud']= NULL;
      session_destroy();

      header("Refresh:1; url=../View/authentification.html");
      
    }

    function showAllUsers(){
      $connexion = $this->db->connect();
      $users = user::getAllUsers($connexion);
      
      // Pass data to the View
      echo UserView::renderUserList($users);
      
    }

    function SearchUser(){
      $connexion = $this->db->connect();
      $existingUsers = User::SearchUsers($connexion, $this->user);
      echo UserView::showFoundUsers($existingUsers);
    }

  }

?>