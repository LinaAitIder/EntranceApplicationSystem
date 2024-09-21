<?php 

class User {
  public $id;
  public $nom;
  public $prenom;
  public $log;
  public $email ;
  public $mdp ;
  public $naissance;
  public $diplome;
  public $niveau;
  public $etab ;
  public $cv;
  public $photo;
  public $token;
  public $verifStatus;

  function createUser($userData){
    $this->id=$userData['id'];
    $this->nom= $userData['nom'];
    $this->prenom= $userData['prenom'];
    $this->log= $userData['log'];
    $this->email=$userData['email'];
    $this->mdp= $userData['mdp'];
    $this->diplome= $userData['diplome'];
    $this->etab= $userData['etablissement'];
    $this->naissance= $userData['naissance'];
    $this->niveau= $userData['niveau'];
    $this->cv= $userData['cv'];
    $this->photo= $userData['photo'];
    $this->token=$userData['token'];
    $this->verifStatus= $userData['verif_token'];
  }

  public function getUserInformation($db){
    $connexion = $db->connect();
    $query="SELECT * FROM etud3a WHERE log = :login Union SELECT * FROM etud4a WHERE log = :login";
    $stmt = $connexion->prepare($query);
    $login =$this->log ;
    $stmt->execute(['login' => $login]); 
    $result = $stmt->fetch(PDO::FETCH_ASSOC); 

    if (!$result) {
      echo "<script>console.log('Pas pu extraire les information de l'/utilisateur');</script>";
    }

    return $result;
  }

 

  function deleteAccount($previousLogin , $niveau){
    $db = new Database;
   
    if($niveau === '3' ){
      $db->deleteUserData('etud3a', $previousLogin); 
    }

    if($niveau === '4'){
      $db->deleteUserData('etud4a', $previousLogin);  
    }

    if ($niveau === '3 et 4') {
      $db->deleteUserData('etud3a', $previousLogin);
      $db->deleteUserData('etud4a', $previousLogin ); 
    }
      
  }
  
}

?>