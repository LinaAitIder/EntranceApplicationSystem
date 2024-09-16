<?php
  class adminController {
    private $login;
    private $mdp;
    private $db;

    function __construct(){
      $this->login='admin';
      $this->mdp='admin';
      $this->db=new Database;
    }

  function lister(){
    $db = new Database;
    $this->showAllUsers();
  }

  public function showAllUsers(){
    $connexion = $this->db->connect();
    $Admin= new Admin;
    $users = $Admin->getAllUsers($connexion);
    
    // Pass data to the View
    echo UserView::renderUserList($users);
    
  }

  function search($keywordSearch){
    admin::SearchUser($this->db,$keywordSearch);
  }

  

  }
?>
