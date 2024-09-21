<?php
class Admin {
  private $login;
  private $mdp;
  
  function __construct()
  {
    $login = 'admin';
    $mdp='admin';
  }
 
  public static function SearchUser($db , $user){
    $existingUsers =  $db->getUsersSearchResult($user);
    echo userView::showFoundUsers($existingUsers);
  }
}

?>