<?php
    ini_set('memory_limit', '1024M');

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

        
        function emailExists($email){
            $connexion=$this->connect();
            $query = "SELECT COUNT(*) FROM (SELECT email FROM etud3a WHERE email = :email UNION SELECT email FROM etud4a WHERE email =:email)";
            $stmt = $connexion->prepare($query);
            $stmt->bindParam(':email',$email);
            $count = $stmt->fetchColumn();
            return $count>0;
        }

        function logExists($login){
            $connexion=$this->connect();
            $query = "SELECT COUNT(*) FROM (SELECT log FROM etud3a WHERE log = :login UNION SELECT log FROM etud4a WHERE log =:login)";
            $stmt = $connexion->prepare($query);
            $stmt->bindParam(':login',$login);
            $count = $stmt->fetchColumn();
            return $count>0;

        }

        function insertData($user , $table){
            $connexion = $this->connect();
            // Preparing parameter
            $insertReq=$connexion->prepare("INSERT INTO  $table (nom, prenom, email, naissance, diplome, niveau, etablissement,photo , cv , log , mdp , token , verif_token) 
            VALUES 
            (:nom,:prenom,:email,:naissance,:diplome,:niveau,:etablissement,:photo,:cv,:log, :mdp , :token , :verif_token)"
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
            $insertReq->bindValue(':token', $user->token, PDO::PARAM_INT);
            $insertReq->bindValue(':verif_token', $user->verifStatus, PDO::PARAM_BOOL);

            if ($insertReq->execute()) {
                echo "<script>console.log('Data inserted successfully!');</script>";
            } else {
                $errorInfo = $insertReq->errorInfo();
                echo "<script> console.log ('Error inserting data: $errorInfo[2]');</script>";
            }
            
           
        }
        
        function insertUpdatedData($user, $table, $sameToken){
            // Preparing parameter
            $connexion = $this->connect();
            $insertReq=$connexion->prepare(" INSERT INTO  $table (nom, prenom, email, naissance, diplome, niveau, etablissement,photo , cv , log , mdp , token , verif_token)
            VALUES 
            (:nom,:prenom,:email,:naissance,:diplome,:niveau,:etablissement,:photo,:cv,:log, :mdp , :token , :verif_token)"
            );
            $user->verifStatus =1;
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
            $insertReq->bindValue(':token', $sameToken, PDO::PARAM_INT);
            $insertReq->bindValue(':verif_token', $user->verifStatus, PDO::PARAM_BOOL);

            if ($insertReq->execute()) {
                echo "<script>console.log('Data inserted successfully!');</script>";
            } else {
                $errorInfo = $insertReq->errorInfo();
                echo "<script> console.log ('Error inserting data: $errorInfo[2]');</script>";
            }
           
        }

        function getToken($user){
            $connexion = $this->connect();
            $email = htmlspecialchars($user->email); 
            // echo "<script>console.log('email : $email');</script>";

            if($user->niveau === '3'){
                $getReq= $connexion->prepare("SELECT token FROM etud3a WHERE email= :email");
                $getReq->bindValue(':email',$user->email , PDO::PARAM_STR);
                $executeSuccess = $getReq->execute();
                if($executeSuccess){
                    $tokenV = $getReq->fetchColumn(); 
                    return $tokenV;
                }
                else {
                    echo "<script>console.log('probleme d'extraction de token de BD');</script>";
                }
            }

            if($user->niveau === '4'){
                $getReq= $connexion->prepare("SELECT token FROM etud4a WHERE email= :email");
                $getReq->bindValue(':email',$user->email , PDO::PARAM_STR);

                if ($getReq->execute()) {
                    $tokenV = $getReq->fetchColumn(); 
        
                    if ($tokenV) {
                        return $tokenV;
                    } else {
                        echo "<script>console.log('Il y'a eu un probleme d'extraction de token de BD');</script>";
                    }
                } else {
                    echo "<script>console.log('probleme d'execution de la requete d'extraction de token!');</script>";              
                }
            }

            if($user->niveau === '3 et 4'){
                $getReq= $connexion->prepare("SELECT etud4a.token FROM etud4a INNER JOIN etud3a ON etud4a.email= etud3a.email WHERE etud4a.email= :email AND  etud3a.token=etud4a.token ");
                $getReq->bindValue(':email',$user->email , PDO::PARAM_STR);
                // $token = $getReq->execute();
                // if($token){
                //     $tokenV = $token->fetchColumn(); 
                //     return $tokenV;
                // }
                // THE CODE UP DIDN'T WORK , IT SEEMS THAT WE HAVE TO FIRST ENSURE THAT THE QUERY EXECUTION IS SUCCESSFUL

                if ($getReq->execute()) {
                    $tokenV = $getReq->fetchColumn(); 
        
                    if ($tokenV) {
                        return $tokenV;
                    } else {
                        echo "<script>console.log('Token untrouvable !');</script>";
                    }
                } else {
                    echo "<script>console.log('Un probleme est survenue lors d'extraction de donnees!');</script>";
                }
            }
         
        }

        public function getUsersSearchResult($user){
            $connexion = $this->connect();
            $query = "
            SELECT * FROM (
                SELECT * FROM etud3a 
                WHERE etud3a.nom LIKE :user 
                UNION 
                SELECT * FROM etud4a 
                WHERE etud4a.nom LIKE :user
            ) AS combined_results
            LIMIT 10
            ";
            $stmt = $connexion->prepare($query);
            $stmt->execute([':user' => '%' . $user . '%']); // Use '%' for the LIKE search
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;

        }

        public function getAllUsers() {
            $connexion = $this->connect();
            $query = "
                SELECT nom, prenom, email, naissance, diplome,  niveau, etablissement, photo, cv 
                FROM etud3a 
                UNION 
                SELECT nom, prenom, email, naissance, diplome, niveau, etablissement, photo, cv 
                FROM etud4a";
        
            $stmt = $connexion->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function updateVerifStatus($user){
            $connexion = $this->connect();

            if($user->niveau === '3' ){
                $user->verifStatus = true;
                $updateReq= $connexion->prepare("UPDATE etud3a SET verif_token = :verif_token WHERE email= :email");
                $updateReq->bindValue(':email',$user->email , PDO::PARAM_STR);
                $updateReq->bindValue(':verif_token',$user->verifStatus , PDO::PARAM_BOOL);
                if($updateReq->execute()){
                    echo "<script> console.log('Data updated in etud3a'); </script>";
                }
                else {
                    echo "<script>console.log(' Something is wrong with the extration of the data'); </script>";
                }
            }

            if($user->niveau === '4'){
                $updateReq= $connexion->prepare("UPDATE etud4a SET verif_token = :verif_token WHERE email= :email");
                $updateReq->bindValue(':email',$user->email , PDO::PARAM_STR);
                $updateReq->bindValue(':verif_token',$user->verifStatus , PDO::PARAM_BOOL);
                if($updateReq->execute()){
                    echo "<script> console.log('Data updated in etud4a'); </script>";
                }
                else {
                    echo "<script> console.log('Something is wrong with the extration of the data'); </script>";
                }
            }

            if($user->niveau === '3 et 4'){
                $updateReq= $connexion->prepare("UPDATE etud4a , etud3a SET etud3a.verif_token = :verif_token , etud4a.verif_token = :verif_token WHERE etud3a.email= :email AND etud4a.email= :email");
                $updateReq->bindValue(':email',$user->email , PDO::PARAM_STR);
                $updateReq->bindValue(':verif_token',$user->verifStatus , PDO::PARAM_BOOL);
                if($updateReq->execute()){
                    echo "<script> console.log(' Data updated in etud4a '); </script>";
                }
                else {
                    echo "<script> console.log( 'Something is wrong with the extration of the data '); </script>";
                }
            }
            
        }
        
        function updateTableData($table , $user , $previousLogin){   
            $connexion = $this->connect();
            $verificatinStatus = 1;
            $dateUpdateReq = "
            UPDATE $table
            SET nom = :nom, prenom = :prenom, email = :email, naissance = :naissance, diplome = :diplome, niveau = :niveau, etablissement = :etab, photo = :photo, cv = :cv, log = :log, mdp = :mdp , verif_token = :verifStatus
            WHERE log = :previousLogin;
            ";
            $stmt = $connexion->prepare($dateUpdateReq);
            // Binding parameters
            $stmt->bindParam(':nom', $user->nom);
            $stmt->bindParam(':prenom', $user->prenom);
            $stmt->bindParam(':email', $user->email);
            $stmt->bindParam(':naissance', $user->naissance);
            $stmt->bindParam(':diplome', $user->diplome);
            $stmt->bindParam(':niveau', $user->niveau);
            $stmt->bindParam(':etab', $user->etab);
            $stmt->bindParam(':photo', $user->photo);
            $stmt->bindParam(':cv', $user->cv);
            $stmt->bindParam(':log', $user->log);
            $stmt->bindParam(':mdp', $user->mdp);
            $stmt->bindParam(':previousLogin', $previousLogin);
            $stmt->bindParam(':verifStatus', $verificatinStatus);

            if ($stmt->execute()) {
                echo "<script>console.log('Updated data in $table');</script>";
            } else {
                echo "<script>". print_r($stmt->errorInfo()) ."</script>";
               
            }
        }

        function updateData($user , $previousLogin) {
            $connexion = $this->connect();
            $sameToken = $this->getToken($user);

            if ($user->niveau === "3") {
                $userController = new userController($user , $this->db);
                $userController->updateUserInfo($user);
                $updatedLevel = $user->niveau;
                $updatedDiplome = $user->diplome;
            
                if($updatedLevel  === "3"){
                    $this->updateTableData('etud3a', $user , $previousLogin);
                } else if ($updatedLevel  === "4"){
                    $this->insertUpdatedData($user,'etud4a' , $sameToken);
                    $user->deleteAccount($previousLogin , 'etud3a');
                } else if ($updatedLevel  === '3 et 4'){
                    if($user->diplome === 'Bac+2') {
                        $this->insertUpdatedData($user,'etud4a', $sameToken);
                        $this->updateTableData('etud3a', $user , $previousLogin) ;
                    }
                    else  if($updatedDiplome === 'Bac+3') {
                        echo "<script>console.log('Un candidat titulaire d’un Bac+3 ne peut pas présenter sa candidature en 3ème et 4ème année en même temps. ')</script>";
                        echo "<script>alert('Un candidat titulaire d’un Bac+3 ne peut pas présenter sa candidature en 3ème et 4ème année en même temps. ');</script>";
                    }
                } else {
                    echo '<script>alert("Il y\'a eu une erreur avec la mise a jour des informations!");</script>';
                }
             
            }

            if ($user->niveau === "4") {
                $userController = new userController($user , $this->db);
                $userController->updateUserInfo($user);
                $updatedDiplome = $user->diplome ;
                $updatedLevel = $user->niveau;
                if($updatedLevel === "4"){
                    $this->updateTableData('etud4a', $user , $previousLogin);
                } else if ($updatedLevel === "3"){
                    $this->insertUpdatedData($user, 'etud3a', $sameToken);
                    $user->deleteAccount($previousLogin , 'etud4a');
                } else if ($updatedLevel === '3 et 4'){
                    if ($updatedDiplome === 'Bac+2'){
                        $this->updateTableData('etud4a', $user , $previousLogin);
                        $this->insertUpdatedData($user, 'etud3a', $sameToken);
                    } else  if($updatedDiplome === 'Bac+3') {
                        echo "<script>console.log('Un candidat titulaire d’un Bac+3 ne peut pas présenter sa candidature en 3ème et 4ème année en même temps. ')</script>";
                        echo "<script>alert('Un candidat titulaire d’un Bac+3 ne peut pas présenter sa candidature en 3ème et 4ème année en même temps. ');</script>";
                    }
                } else {
                    echo '<script>alert("Il y\'a eu une erreur avec la mise a jour des informations!");</script>';
                }
            }
        
            if ($user->niveau === "3 et 4") {
                $userController = new userController($user , $this->db);
                $userController->updateUserInfo($user);
                $updatedDiplome = $user->diplome;
                $updatedLevel = $user->niveau;
                if($updatedLevel === "4"){
                    $this->updateTableData('etud4a', $user ,  $previousLogin);
                    $user->deleteAccount($previousLogin , 'etud3a');
                } else if ($updatedLevel === "3"){
                    $this->updateTableData('etud3a', $user ,  $previousLogin);
                    $user->deleteAccount($previousLogin , 'etud4a');
                } else if ($updatedLevel === '3 et 4'){
                    if($updatedDiplome === 'Bac+2'){
                    $this->updateTableData('etud4a', $user ,  $previousLogin);
                    $this->updateTableData('etud3a' , $user ,  $previousLogin);
                    } else if($updatedDiplome === 'Bac+3'){
                        echo "<script>console.log('Un candidat titulaire d’un Bac+3 ne peut pas présenter sa candidature en 3ème et 4ème année en même temps. ')</script>";
                        echo "<script>alert('Un candidat titulaire d’un Bac+3 ne peut pas présenter sa candidature en 3ème et 4ème année en même temps. ');</script>";;
                    }
                } else {
                    echo '<script>alert("Il y\'a eu une erreur avec la mise a jour des informations!");</script>';
                }
            }
        } 

        function deleteUserData($table, $previousLogin){
            $connexion = $this->connect();
            $query="DELETE FROM $table WHERE log = :login";
            $stmt = $connexion->prepare($query);
            if($stmt->execute(['login' => $previousLogin])){
                echo "<script> console.log('User Account deleted'); </script>";
            };
        }

       

    }
    

?>