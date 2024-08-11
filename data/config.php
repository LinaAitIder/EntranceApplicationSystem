<?php
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

        function insertData($user , $connexion , $table){
            // Preparing parameter
            $insertReq=$connexion->prepare(" INSERT INTO  $table (nom, prenom, email, naissance, diplome, niveau, etablissement,photo , cv , log , mdp) 
            VALUES 
            (:nom,:prenom,:email,:naissance,:diplome,:niveau,:etablissement,:photo,:cv,:log, :mdp)"
            );
            $insertReq->bindValue(':nom', $user->nom, PDO::PARAM_STR);
            $insertReq->bindValue(':prenom', $user->prenom, PDO::PARAM_STR);
            $insertReq->bindValue(':email', $user->email, PDO::PARAM_STR);
            $insertReq->bindValue(':naissance', $user->naissance, PDO::PARAM_STR); // Date as a string
            $insertReq->bindValue(':diplome', $user->diplome, PDO::PARAM_STR);
            $insertReq->bindValue(':niveau', $user->niveau, PDO::PARAM_STR);
            $insertReq->bindValue(':etablissement', $user->etab, PDO::PARAM_STR);
            $insertReq->bindValue(':cv', $user->cv, PDO::PARAM_STR);
            $insertReq->bindValue(':photo', $user->photo, PDO::PARAM_STR);
            $insertReq->bindValue(':log', $user->log, PDO::PARAM_STR);
            $insertReq->bindValue(':mdp', $user->mdp, PDO::PARAM_STR);
            if ($insertReq->execute()) {
                echo "<alert> Data inserted successfully! </alert>";
            } else {
                $errorInfo = $insertReq->errorInfo();
                echo "Error inserting data: " . $errorInfo[2];
            }
            
           
        }
      


      
    }

    

?>