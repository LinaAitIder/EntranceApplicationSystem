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
      echo "No results found.";
    }

    return $result;
  }

  function deleteAccount($previousLogin , $table){
    $db = new Database;
   
    if($table === 'etud3a'){
      $db->deleteUserData($table, $previousLogin); 
    }

    if($table === '4'){
      $db->deleteUserData($table, $previousLogin);  
    }

    if ($table === '3 et 4') {
      $db->deleteUserData('etud3a', $previousLogin);
      $db->deleteUserData($table, $previousLogin ); 
      // $query = "DELETE etud3a, etud4a 
      //           FROM etud3a 
      //           INNER JOIN etud4a ON etud3a.email = etud4a.email 
      //           WHERE etud3a.log = :login AND etud4a.log = :login";
  
      // $stmt = $connexion->prepare($query);
  
      // if ($stmt->execute(['login' => $login])) {
      //     echo "done";
      // }
    }
      
  }
  
}

?>