<?php

  class userView {

    public static function renderUserList($users){
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

            foreach ($users as $user) { 
                $htmlCandidatsLists .=  '
                    <tr> 
                        <td>'.$user['nom'].'</td>   
                        <td>'.$user['prenom'].'</td>   
                        <td>'.$user['email'].'</td>   
                        <td>'.$user['naissance'].'</td>   
                        <td>'.$user['diplome'].'</td>   
                        <td>'.$user['niveau'].'</td>   
                        <td>'.$user['etablissement'].'</td>   
                        <td>
                            <img src="'.$user['photo'] . '" alt="Photo" style="width: 150px; height: auto;" />
                        </td>   
                        <td>
                            <a href="'.$user['cv'].'" download>CV</a>
                        </td>
                    </tr>
            ';
            }
        $htmlCandidatsLists .= '
        </table>
        <br>
        <br>
        <br>

        <a href="./adminActions.php?action=logout">se deconnecter</a>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        </body>
        </html>
        ';
        return $htmlCandidatsLists;

    }
    
    public static function showFoundUsers($users){
        $html ='';
        foreach($users as $user){
            $html.= '<div style="margin-top:20px; border-bottom:2px solid #ccc"> ';
            $html.= htmlspecialchars($user['nom']) . ' ' . htmlspecialchars($user['prenom']); 
            $html.= ' </div>';
          }
        return $html;
    }
    
    public static function renderRecap($userInformations , $niveau){
        $candidatInfo = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="../styles/css/studentPortal.css">
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

                <title>Recap</title>
            </head>
            <body>
                <div class="container-fluid container">
                    <h2 class="text-center pt-4">Informations de Candidature</h2>
                    <hr>
                    <div class="info"><strong>Identifiant :</strong> ' . $userInformations['id'] . '</div>
                    <div class="info"><strong>Nom :</strong> ' . $userInformations['nom'] . '</div>
                    <div class="info"><strong>Prénom :</strong> ' . $userInformations['prenom'] . '</div>
                    <div class="info"><strong>Date de naissance :</strong> ' . $userInformations['naissance'] . '</div>
                    <div class="info"><strong>Diplôme :</strong> ' . $userInformations['diplome'] . '</div>
                    <div class="info"><strong>Condidature :</strong> ' . $niveau . '</div>
                    <div class="info"><strong>Etablissement :</strong> ' . $userInformations['etablissement'] . '</div>
                    <div class="info"><strong>Email :</strong> ' . $userInformations['email'] . '</div>
                    <br>
                    <img src="'. '../'. $userInformations['photo'] . '" alt="Photo" style="width: 150px; height: auto;" />
                    <br><br>
                    <a href="' . '../'. $userInformations['cv'] . '" download>Télécharger CV</a>
                </div>
                <br>
                <br>           
                <div class="button-container ">
                    <button type="button" onclick="window.location.href = \'./accountUpdating.php\';" class="first-btn-recap" >Modifier</button> 
                    <button type="button" onclick="window.location.href =  \'../userActions.php?action=logout \';" class="btn-recap">Se déconnecter</button>
                    <button type="button" onclick="window.location.href =  \'../userActions.php?action=deleteAccount \'" class="btn-recap">Supprimer le compte</button>
                    <button type="button" onclick="window.location.href = \'../utils/pdfGenerator.php?action=generateRecap\';" class="btn-recap">Obtenir votre reçu PDF</button>
                </div>
                
                <script src="../scripts/functions.js"></script>
            </body>
            </html>';
            echo $candidatInfo;
    }

    public static function updateRecap($userData , $niveau){
        $updatedCandidatInfo = '
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
                     <div class="info"><strong>Identifiant :</strong> ' . $userData->id . '</div>
                    <div class="info"><strong>Nom :</strong> ' . $userData->nom . '</div>
                    <div class="info"><strong>Prénom :</strong> ' . $userData->prenom . '</div>
                    <div class="info"><strong>Date de naissance :</strong> ' . $userData->naissance . '</div>
                    <div class="info"><strong>Diplôme :</strong> ' . $userData->diplome . '</div>
                    <div class="info"><strong>Condidature :</strong> ' . $niveau . '</div>
                    <div class="info"><strong>Etablissement :</strong> ' . $userData->etab . '</div>
                    <div class="info"><strong>Email :</strong> ' . $userData->email . '</div>
                    <br>
                    <img src="' . './'. $userData->photo . '" alt="Photo" style="width: 150px; height: auto;" />
                    <br><br>
                    <a href="' . './'. $userData->cv . '" download>Télécharger CV</a>
                </div>
                <br>
                <br>           
                <div class="button-container">
                    <button type="button" onclick="window.location.href = \'./View/accountUpdating.php\';">Modifier</button> 
                    <button type="button" onclick="window.location.href =  \'./userActions.php?action=logout \';">Se déconnecter</button>
                    <button type="button" onclick="window.location.href =  \'./userActions.php?action=deleteAccount \'">Supprimer le compte</button>
                    <button type="button" onclick="window.location.href = \'./utils/pdfGenerator.php?action=generateRecap\';">Obtenir votre reçu PDF</button>
                </div>
                
                <script src="./scripts/functions.js"></script>
            </body>
            </html>';
            echo $updatedCandidatInfo;
    }

}

?>