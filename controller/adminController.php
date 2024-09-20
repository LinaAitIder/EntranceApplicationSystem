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
    $db= new Database;
    $users = $db->getAllUsers();
    echo userView::renderUserList($users);
    
  }

  function search($keywordSearch){
    admin::SearchUser($this->db,$keywordSearch);
  }

  

  }
?>
