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
      $emailExists = $this->db->emailExists($this->user->email);
      $logExists = $this->db->logExists($this->user->log);
      // Email duplicated
      if ($emailExists || $logExists){
        if($emailExists){
          echo "<script>console.log('Cet Email deja Existe!');</script>";

          echo "<script>alert('Cet Email deja Existe!');</script>";
          header('Refresh:0.5; url=./View/authentification.php');
          exit();
        } else if($logExists){
          echo "<script>console.log('Ce login est deja utilise!');</script>";
          echo "<script>alert('Ce login deja Existe!');</script>";
          header('Refresh:0.5; url=./View/authentification.php');
          exit();
        }} else {
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
          }} 
          else if($this->user->niveau ==='4'){
            if($this->user->diplome === 'Bac+3'){
              $this->db->insertData($this->user  , 'etud4a');
              if(sendMail($this->user->nom , $this->user->prenom , $this->user->email , $tokenpdf)){
                header('Location:./View/accountVerification.php');
                exit();
              } 
            } else if ($this->user->diplome === 'Bac+2'){
              echo "<script>alert('Un etudiant bac+2 ne peut pas postuler pour la 4eme annee');</script>";
              header('Refresh:0.5;url=View/authentification.php');
            }
          }else if($this->user->niveau === '3 et 4'){
            if($this->user->diplome === 'Bac+3'){
              $this->db->insertData($this->user  , 'etud3a');
              $this->db->insertData($this->user  , 'etud4a');
              if(sendMail($this->user->nom , $this->user->prenom , $this->user->email , $tokenpdf)){
                header('Location:./View/accountVerification.php');
                exit();
              };         
            } else{
                echo '<script>alert("Un etudiant Bac+2  peut pas présenter sa candidature en 3ème et 4ème année en même temps.");</script>';
                header('Refresh:1;url=View/authentification.php');
            }
            } 
          }
    }

    function displayUserInfo(){
      $userInformations=  $this->user->getUserInformation($this->db);
      $niveau = nameLevel($userInformations['niveau']);
      userView::renderRecap($userInformations, $niveau);
            
    }
    
    function updateUserInfo(){
      //Update the user object information
      $this->user->nom = $_POST['nom'];
      $this->user->prenom = $_POST['prenom'];
      $this->user->log = $_POST['log'];
      $this->user->email = $_POST['email'];
      $this->user->mdp = password_hash($_POST['mdp'] , PASSWORD_BCRYPT); // securite
      $this->user->naissance = $_POST['naissance'];
      $this->user->diplome = $_POST['diplome'];
      $this->user->etab = $_POST['etab'];
      $niveau3 = isset($_POST['niveau3']) ? $_POST['niveau3'] : null;  
      $niveau4= isset($_POST['niveau4']) ? $_POST['niveau4'] : null;  
      $niveau = verifyLevel($niveau3 , $niveau4);  
      $this->user->niveau = $niveau;

      $this->user->verifStatus = true;

      // Uploading Files
      uploadFiles($_FILES['photo'], $_FILES['cv'] , $this->user);
     
      // SERIALIZE THE this->user OBJECT IN THE SESSION
      $_SESSION['user'] = serialize($this->user);
      
    }

    function cloneUser($oldUser){
       //Update the user object information
       $this->user->nom = $oldUser->nom;
       $this->user->prenom =$oldUser->prenom;
       $this->user->log  = $oldUser->log;
       $this->user->email = $oldUser->email;
       $this->user->mdp = $oldUser->mdp;
       $this->user->naissance = $oldUser->naissance;
       $this->user->diplome = $oldUser->diplome;
       $this->user->etab= $oldUser->etab;
       
       
       $niveau = verifyLevel($_POST['niveau3'] , $_POST['niveau4']);  
       $this->user->niveau = $niveau;
 
       $this->user->verifStatus = true;
 
       // Uploading Files
       uploadFiles($_FILES['photo'], $_FILES['cv'] , $this->user);
      
       // SERIALIZE THE this->user OBJECT IN THE SESSION
       $_SESSION['user'] = serialize($this->user);
      return $this->user;
    }

   
  }

?>