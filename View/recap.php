
    <?php

        require '../data/config.php';
        require '../data/userData.php';



        session_start();
        $user=new User;
        $db=new Database;
        $connexion = $db->connect();
        $userLogin = $_SESSION['recap_etud']['log'];

        if (isset($_SESSION['recap_etud'])) {
            $result= $user->getUserInformation($connexion , $userLogin);
            if($result['niveau'] === "3"){
                $niveau ="3ème année";
                $_SESSION['recap_etud']['nivName'] = $niveau;
            } 
            else if ($result['niveau'] === "4"){
                $niveau ="4ème année";
                $_SESSION['recap_etud']['nivName'] = $niveau;

            } 
            else{
                $niveau ="3ème année et 4ème année";
                $_SESSION['recap_etud']['nivName'] = $niveau;

            }
            $candidatInfo = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Recap</title>
            </head>
            <body>
                <div class="container">
                    <h2>Informations de Candidature</h2>
                    <div class="info"><strong>Identifiant :</strong> ' . $result['id'] . '</div>
                    <div class="info"><strong>Nom :</strong> ' . $result['nom'] . '</div>
                    <div class="info"><strong>Prénom :</strong> ' . $result['prenom'] . '</div>
                    <div class="info"><strong>Date de naissance :</strong> ' . $result['naissance'] . '</div>
                    <div class="info"><strong>Diplôme :</strong> ' . $result['diplome'] . '</div>
                    <div class="info"><strong>Condidature :</strong> ' . $niveau . '</div>
                    <div class="info"><strong>Etablissement :</strong> ' . $result['etablissement'] . '</div>
                    <div class="info"><strong>Email :</strong> ' . $result['email'] . '</div>
                    <br>
                    <img src="' . $result['photo'] . '" alt="Photo" style="width: 150px; height: auto;" />
                    <br><br>
                    <a href="' . $result['cv'] . '" download>Télécharger CV</a>
                </div>
                <br>
                <br>           
                <div class="button-container">
                    <button type="button" onclick="window.location.href = \'./modif.html\';">Modifier</button> 
                    <button type="button" onclick="window.location.href =  \'../controller/logout.php \';">Se déconnecter</button>
                    <button type="button" onclick="window.location.href = \'./../controller/deleteUser.php\';">Supprimer le compte</button>
                    <button type="button" onclick="window.location.href = \'./pdf_gen.php\';">Obtenir votre reçu PDF</button>
                </div>
                
                <script src="./../scripts/functions.js"></script>
            </body>
            </html>';
            echo $candidatInfo;
            
        
        } else {
            echo "<p>Aucune information de candidature disponible.</p>";
        }
   
    ?>

