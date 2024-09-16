<?php 

class User {
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

  // function __construct($userDetails)

  public static function getUserInformation($connexion ,$login){
    $query="SELECT * FROM etud3a WHERE log = :login Union SELECT * FROM etud4a WHERE log = :login";
    $stmt = $connexion->prepare($query);
    $stmt->execute(['login' => $login]); 
    $result = $stmt->fetch(PDO::FETCH_ASSOC); 
    return $result;
  }

 //deleting user
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

        if($niveau === '3 et 4'){
          $query="DELETE FROM etud3a , etud4a WHERE log = :login AND etud3a.email = etud4a.email";
          $stmt = $connexion->prepare($query);
          if($stmt->execute(['login' => $login])){echo "done";};   }

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


//updating user information

  

}





?>