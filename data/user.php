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

  public function getUserInformation($connexion){
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

  function deleteAccount($connexion , $login , $niveau){

        if($niveau === '3'){
          $query="DELETE FROM etud3a WHERE log = :login";
          $stmt = $connexion->prepare($query);
           if($stmt->execute(['login' => $login])){echo "done";}; 
        }

        if($niveau === '4'){
          $query="DELETE FROM etud4a WHERE log = :login";
          $stmt = $connexion->prepare($query);
          if($stmt->execute(['login' => $login])){echo "done";};   
        }

        if ($niveau === '3 et 4') {
          // Delete from both tables at once using JOIN
          $query = "DELETE etud3a, etud4a 
                    FROM etud3a 
                    INNER JOIN etud4a ON etud3a.email = etud4a.email 
                    WHERE etud3a.log = :login AND etud4a.log = :login";
      
          $stmt = $connexion->prepare($query);
      
          if ($stmt->execute(['login' => $login])) {
              echo "done";
          }
      }
      
      

  }

  public static function SearchUsers($connexion , $user){
    $query = "
    SELECT * FROM (
        SELECT * FROM etud3a 
        WHERE etud3a.nom LIKE :user 
        UNION 
        SELECT * FROM etud4a 
        WHERE etud4a.nom LIKE :user
    ) AS combined_results
    LIMIT 10
    ";
    $stmt = $connexion->prepare($query);
    $stmt->execute([':user' => '%' . $user . '%']); // Use '%' for the LIKE search
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;

  }

 


  

}





?>