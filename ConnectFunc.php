<?php
    function connect(){
        $localhost = "localhost";
        $db = "concours";
        $username = "root";
        $password = "";
            try {
                $connexion = new PDO("mysql:host=$localhost;dbname=$db", $username, $password);
                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $connexion;
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            return null;
    } 
    

?>