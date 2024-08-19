<?php
    if(isset($_POST['submit'])){
        $login=$_POST['log'];
        $pass=$_POST['mdp'];
        if( $login=='admin' && $pass=='admin') {
            $_SESSION['USER']='admin';
            header("location:administration.php");
        }
        else {
            //Verification de l'existence d'etudiant dans Bd
            $query="SELECT log FROM etud3a WHERE log = :login Union SELECT log FROM etud4a WHERE log = :login";
            $stmt = $con->prepare($query);
            $stmt->execute(['login' => $login]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($result) {
                $query="SELECT * FROM etud3a WHERE log = :login Union SELECT * FROM etud4a WHERE log = :login";
                $stmt = $con->prepare($query);
                $stmt->execute(['login' => $login]); 
                $result = $stmt->fetch(PDO::FETCH_ASSOC); 
                $_SESSION['recap_etud']=$result;
                $_SESSION['USER'] = 'etud';
                header("Location: recap.php?login=" . $login);
            } else {
                echo "<script>alert('Vous n'êtes pas inscrit, Veuillez vous reinscrire !');</script>";
            }}
            
        }
?>