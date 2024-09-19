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
    $query = "SELECT * FROM etud3a UNION SELECT * FROM etud4a";
    $stmt = $connexion->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function SearchUser($db , $user){
    $connexion = $db->connect();
    $existingUsers = User::SearchUsers($connexion, $user);
    echo userView::showFoundUsers($existingUsers);
  }
}
?>