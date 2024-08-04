<?php
require 'userData.php';
    class Database{
        private $localhost = "localhost";
        private $db = "concours";
        private $username = "root";
        private $password = "";

        function connect(){
                try {
                    $connexion = new PDO("mysql:host=$this->localhost;dbname=$this->db", $this->username, $this->password);
                    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $connexion;
                } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                return null;
        } 

        function insertData($user , $db){
            $connexion= $db->connect();
            $insertReq="Insert into $this->db VALUES '$user->name ,  $user->prenom , $user->email , $user->naissance , $user->diplome , '3' , $user->etab' , $user->cv , $user-> photo ";
        }

      
    }

    

?>