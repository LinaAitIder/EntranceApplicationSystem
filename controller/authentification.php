<?php
    session_start();
    require '../data/config.php';

    // require "inscription.php";
    // if($_POST){
    //     echo "Working well";
    // }
    if(isset($_POST['submit'])){
        $login=$_POST['log'];
        $pass=$_POST['mdp'];

        if( $login ==='admin' && $pass ==='admin') {
            $_SESSION['USER']='admin';
            header("Refresh:0.5; url=adminVerification.php");
            exit();
        }
        else {
            //Verification de l'existence d'etudiant dans Bd
            // Query Verification
            $db = new Database;
            $connexion= $db->connect();
            if($connexion) echo "Working !!";
            $query="SELECT log FROM etud3a WHERE log = :login Union SELECT log FROM etud4a WHERE log = :login";
            if($query) echo "the query is okay!!";
            $stmt = $connexion->prepare($query);
            $stmt->execute(['login' => $login]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($result) {
                $query="SELECT * FROM etud3a WHERE log = :login Union SELECT * FROM etud4a WHERE log = :login";
                $stmt = $connexion->prepare($query);
                $stmt->execute(['login' => $login]); 
                $result = $stmt->fetch(PDO::FETCH_ASSOC); 
                $_SESSION['recap_etud']=$result;
                $_SESSION['USER'] = 'etud';
                header("Location:./../View/recap.php?login=".$login);
            } else {
                echo "<script>alert('Vous n'êtes pas inscrit, Veuillez vous reinscrire !');</script>";
            }}
            
        
        }
?>