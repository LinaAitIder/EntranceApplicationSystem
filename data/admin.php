<?php
class Admin {
  private $login;
  private $mdp;
  
  function __construct()
  {
    $login = 'admin';
    $mdp='admin';
  }
 
  public static function getAllUsers($connexion) {
    $query = "
        SELECT nom, prenom, email, naissance, diplome,  niveau, etablissement, photo, cv 
        FROM etud3a 
        UNION 
        SELECT nom, prenom, email, naissance, diplome, niveau, etablissement, photo, cv 
        FROM etud4a";

    $stmt = $connexion->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


  public static function SearchUser($db , $user){
    $connexion = $db->connect();
    $existingUsers =  Database::getUsersSearchResult($connexion, $user);
    echo userView::showFoundUsers($existingUsers);
  }
}
?>