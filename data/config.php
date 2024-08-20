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
          
        }
      
    

    public static function getAllUsers($connexion){
        $htmlCandidatsLists = `
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
        `;
        $query=" SELECT * FROM etud3a Union SELECT * FROM etud4a ";
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
                    <td ><a href='{$row['cv']} download'> CV</a></td>
                </tr>
                
                ";
        } 
        $htmlCandidatsLists .= '
        </table>
        <br>
        <br>
        <br>

        <a href="deconnexion.php">se deconnecter</a>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        </body>
        </html>
        ';
        return $htmlCandidatsLists;

    }

} 

?>