<?php 
    session_start();
    if($_SESSION['userType'] !== 'etud'){
        if(($_SESSION['userType'] === 'admin')){
            header('Location:./administration.php');
        } else{
            header('Location:./authentification.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/css/StyleSignIn.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Inscription</title>
</head>
<body>
<div class="container container-sm">
            <form method="post" action="../userActions.php?action=updateAccount" enctype="multipart/form-data" class="form row  container-md p-5 ">
                    <h5 style="font-family: arial;font-size: 20px; font-weight:bold; text-align:center; color:black; margin-bottom:30px; ">Admission au concours d'accès:</h5>
                    <div>
                        <input type="text" name="nom"  id="nom" placeholder="Nom" class="form-control" required>
                    </div>
                    <div>
                        <input type="text" placeholder="Prénom" name="prenom"  class="form-control" required>
              
                    </div>
                    <div>
                        <input type="text" placeholder="Username" name="log"
                        class="form-control"  required>
                    </div>
                    <div>
                            <input type="email" placeholder="Email" name="email" class="form-control" required>
                    </div>
                    <div>
                            <input type="password" placeholder="Votre mot de passe" name="mdp"  class="form-control" required>
                    </div>
                    <div>
                            <input type="date" placeholder="Date de naissance" name="naissance" class="form-control"  required>
                    </div>
                    <div>  
                        <input type="text" placeholder="Établissement" name="etab" class="form-control" required>
                    </div>
                    <div>
                            <select name="diplome" class="form-select" required>
                                <option value="Bac+2" selected >Bac+2</option>
                                <option value="Bac+3">Bac+3</option>
                            </select>
                  </div>
                    <div class="file-form">
                        <label for="photo" class="form-label">Importer une photo</label>
                        <input type="file" name="photo" value="Importer une photo" src="ImageIcon.png" class="form-control" id="photo">
                    </div>
                    <div  class="file-form">
                         <label for="cv" class="form-label">Importer un cv</label>
                         <input type="file" name="cv"  value="Importer un CV" src="ImageIcon.png" class="form-control" >
                    </div>
                    
                    <div class="checkbox-form">
                         <p class="mb-0">Votre niveau d'études:</P>
                        <div class="form-check">
                                <input  class="form-check-input" type="checkbox" name="niveau4" id="defaultCheck">
                                <label for="defaultCheck" class="form-check-label">   4 ème année</label> 
                        </div>
                        <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="niveau3" id="anotherCheck">
                                <label for="anotherCheck" class="form-check-label"> 3 ème année </label> 
                        </div>
                    <div>
                     <input type="submit" name="signUp" value="Confirmer" class=" btnSignIn">
                    </div>
                   
            </form>
    </div>

    
</body>
</html>