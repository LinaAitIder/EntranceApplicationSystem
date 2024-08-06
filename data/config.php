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

        function insertData($user , $connexion){
            // Preparing parameter
            $insertReq=$connexion->prepare(" INSERT INTO users  (name, prenom, email, naissance, diplome, niveau, etablissement, cv, photo, department_id) 
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $niveau = 3; // Assuming 'niveau' is always 3
            $insertReq->bind_param(
                "sssssssssi", 
                $user->name, 
                $user->prenom, 
                $user->email, 
                $user->naissance, 
                $user->diplome, 
                $niveau, 
                $user->etab, 
                $user->photo, 
                $user->cv,
                $user->login,
                $user->pass,
            );
               // Execute the query and check for errors
            if ($insertReq->execute()) {
                echo "<alert> Data inserted successfully! </alert>";
            } else {
                echo " <alert> Error inserting data: </alert>" . $insertReq->error;
            }
            
            // Close the statement and connection
            $insertReq->close();
            $connexion->close();
           
        }

      
    }

    

?>