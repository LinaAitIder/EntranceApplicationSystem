<?php

  class userController{
    private $user ;
    private $db;

    function __construct($user, $db){
      $this->user= $user;
      $this->db = $db;
    }

    function deleteAccount(){    
      $connexion = $this->db->connect();
      $this->user->log =$_SESSION['recap_etud']['log'];
      $this->user->niveau=$_SESSION['recap_etud']['niveau'];
      $this->user->deleteAccount($connexion , $this->user->log , $this->user->niveau);
      $_SESSION['recap_etud']= NULL;
      session_destroy();

      header("Refresh:1; url=../View/authen.html");
      
    }

    function logout(){
      session_destroy();
      header('Location:../index.html');
    }

  }

?>