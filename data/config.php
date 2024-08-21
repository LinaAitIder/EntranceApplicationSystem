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

        function insertData($user , $connexion , $table){
            // Preparing parameter
            $insertReq=$connexion->prepare(" INSERT INTO  $table (nom, prenom, email, naissance, diplome, niveau, etablissement,photo , cv , log , mdp , token , verif_token) 
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
                echo "<alert> Data inserted successfully! </alert>";
            } else {
                $errorInfo = $insertReq->errorInfo();
                echo "Error inserting data: " . $errorInfo[2];
            }
            
           
        }

        function getToken($user , $connexion){
            echo "Email being used in query: " . htmlspecialchars($user->email) . "<br>";

            if($user->niveau === '3'){
                $getReq= $connexion->prepare("SELECT token FROM etud3a WHERE email= :email");
                $getReq->bindValue(':email',$user->email , PDO::PARAM_STR);
                $executeSuccess = $getReq->execute();
                if($executeSuccess){
                    $tokenV = $getReq->fetchColumn(); 
                    return $tokenV;
                }
                else {
                    echo "Something is wrong with the extration of the data";
                    return false ;
                }
            }
            if($user->niveau === '4'){
                $getReq= $connexion->prepare("SELECT token FROM etud4a WHERE email= :email");
                $getReq->bindValue(':email',$user->email , PDO::PARAM_STR);
                $token = $getReq->execute();
                if($token){
                    $tokenV = $token->fetchColumn(); 
                    return $tokenV;
                }
                // id user niveau = '3 et 4';
                else {
                    echo "Something is wrong with the extration of the data";
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
                        echo "No matching token found.";
                    }
                } else {
                    echo "Something is wrong with the extration of the data";
                }
            }
         
        }

        function updateVerifStatus($user , $connexion){
            if($user->niveau === '3' ){
                $user->verifStatus = true;
                $updateReq= $connexion->prepare("UPDATE etud3a SET verif_token = :verif_token WHERE email= :email");
                $updateReq->bindValue(':email',$user->email , PDO::PARAM_STR);
                $updateReq->bindValue(':verif_token',$user->verifStatus , PDO::PARAM_BOOL);
                if($updateReq->execute()){
                    echo " Data updated in etud3a";
                }
                else {
                    echo "Something is wrong with the extration of the data";
                }
            }
            if($user->niveau === '4'){
                $updateReq= $connexion->prepare("UPDATE etud4a SET verif_token = :verif_token WHERE email= :email");
                $updateReq->bindValue(':email',$user->email , PDO::PARAM_STR);
                $updateReq->bindValue(':verif_token',$user->verifStatus , PDO::PARAM_BOOL);
                if($updateReq->execute()){
                    echo " Data updated in etud4a";
                }
                else {
                    echo "Something is wrong with the extration of the data";
                }
            }
            if($user->niveau === '3 et 4'){
                $updateReq= $connexion->prepare("UPDATE etud4a , etud3a SET etud3a.verif_token = :verif_token , etud4a.verif_token = :verif_token WHERE etud3a.email= :email AND etud4a.email= :email");
                $updateReq->bindValue(':email',$user->email , PDO::PARAM_STR);
                $updateReq->bindValue(':verif_token',$user->verifStatus , PDO::PARAM_BOOL);
                if($updateReq->execute()){
                    echo " Data updated in etud4a";
                }
                else {
                    echo "Something is wrong with the extration of the data";
                }
            }
            
          
        }
      
        function updateData($user, $connexion , $userLogin) {
            // Update for niveau 3
            if ($user->niveau === "3") {
                $dateUpdateReq = "
                UPDATE etud3a
                SET nom = :nom, prenom = :prenom, email = :email, naissance = :naissance, diplome = :diplome, niveau = :niveau, etablissement = :etab, photo = :photo, cv = :cv, log = :log, mdp = :mdp 
                WHERE log = :userLogin;
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
                $stmt->bindParam(':userLogin', $userLogin);
                if ($stmt->execute()) {
                    echo "Updated data in etud3a";
                } else {
                    print_r($stmt->errorInfo());
                }
            }
        
            // Update for niveau 4
            if ($user->niveau === "4") {
                $dateUpdateReq = "
                UPDATE etud4a
                SET nom = :nom, prenom = :prenom, email = :email, naissance = :naissance, diplome = :diplome, niveau = :niveau, etablissement = :etab, photo = :photo, cv = :cv, log = :log, mdp = :mdp 
                WHERE log = :userLogin;
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
                $stmt->bindParam(':userLogin', $userLogin);
                if ($stmt->execute()) {
                    echo "Updated data in etud4a";
                } else {
                    print_r($stmt->errorInfo());
                }
            }
        
            // Update for niveau 3 et 4
            if ($user->niveau === "3 et 4") {
                // Update etud3a
                $dateUpdateReq = "
                UPDATE etud3a 
                SET nom = :nom, prenom = :prenom, email = :email, naissance = :naissance, diplome = :diplome, niveau = :niveau, etablissement = :etab, photo = :photo, cv = :cv, log = :log, mdp = :mdp 
                WHERE log = :userLogin;
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
                $stmt->bindParam(':userLogin', $userLogin);
                if ($stmt->execute()) {
                    echo "Updated data in etud3a";
                } else {
                    print_r($stmt->errorInfo());
                }
        
                // Update etud4a
                $dateUpdateReqS = "
                UPDATE etud4a 
                SET nom = :nom, prenom = :prenom, email = :email, naissance = :naissance, diplome = :diplome, niveau = :niveau, etablissement = :etab, photo = :photo, cv = :cv, log = :log, mdp = :mdp 
                WHERE log = :userLogin;
                ";
                $stmtS = $connexion->prepare($dateUpdateReqS);
                // Binding parameters
                $stmtS = $connexion->prepare($dateUpdateReqS);

                $stmtS->bindParam(':nom', $user->nom);
                $stmtS->bindParam(':prenom', $user->prenom);
                $stmtS->bindParam(':email', $user->email);
                $stmtS->bindParam(':naissance', $user->naissance);
                $stmtS->bindParam(':diplome', $user->diplome);
                $stmtS->bindParam(':niveau', $user->niveau);
                $stmtS->bindParam(':etab', $user->etab);
                $stmtS->bindParam(':photo', $user->photo);
                $stmtS->bindParam(':cv', $user->cv);
                $stmtS->bindParam(':log', $user->log);
                $stmtS->bindParam(':mdp', $user->mdp);
                $stmtS->bindParam(':userLogin', $userLogin);
                if ($stmtS->execute()) {
                    echo "Updated data in etud4a";
                } else {
                    print_r($stmtS->errorInfo());
                }
                
                $_SESSION['recap_etud']['log']= $user->log;
                
            }
        }
        

    public static function getAllUsers($connexion){
        $htmlCandidatsLists = '
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>liste des inscriptions</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        </head>
        <body>
            <div class="container">
                <center><h3><b>Liste des inscriptions</b></h3></center>
                <table class="table table-hover">
                <tr>  
                    <th >nom</th>   
                    <th >prenom</th>   
                    <th >email</th>   
                    <th >naissance</th>   
                    <th >diplome</th>   
                    <th >niveau</th>   
                    <th >etablissement</th>   
                    <th >photo</th>   
                    <th >cv</th>
                </tr>
            ';
        $query = "SELECT * FROM etud3a UNION SELECT * FROM etud4a";
        $data = $connexion->query($query);
        $rows = $data->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row){ 
        $htmlCandidatsLists .=  "
                <tr> 
                    <td >{$row['nom']} </td>   
                    <td  >{$row['prenom']}</td>   
                    <td >{$row['email']}</td>   
                    <td >{$row['naissance']}</td>   
                    <td >{$row['diplome']}</td>   
                    <td  >{$row['niveau']}</td>   
                    <td >{$row['etablissement']}</td>   
                    <td ><img src='{$row['photo']}' style='width: 100px; height: auto;'></td>   
                    <td ><a href='{$row['cv']}' download> CV</a></td>
                </tr>
                
                ";
        } 
        $htmlCandidatsLists .= '
        </table>
        <br>
        <br>
        <br>

        <a href="../controller/logout.php">se deconnecter</a>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        </body>
        </html>
        ';
        return $htmlCandidatsLists;

    }


}
?>