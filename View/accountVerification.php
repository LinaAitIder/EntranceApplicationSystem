<?php 
    session_start();
    if($_SESSION['userType'] !== 'admin'){
        if($_SESSION['userType'] === 'etud'){
            header('Location:./recap.php');
        } else {
            header('Location:./authentification.php');
        }
    }
?>
<html>
    <head>
    <link rel="stylesheet" href="../styles/StylePage.css">
    </head>
    <body>
        <div class="container">
            <form method="post" class="form" action='../verifyAccount.php'>
                <legend>Entrer votre code de confirmation , Veuillez consulter votre email :</legend>
                <input type="text" name="tokenCode" >
                <input type="submit" name="verify" value="verifyEmail">
            </form>
        </div>
        <div class="container-fluid d-flex justify-content-center align-items-center">
            <div></div>
            <div class="text-center" id="js-msg-error"></div>
            <div></div>
        </div>
        <script src="../scripts/functions.js"></script>
        <script>
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');
            if(error === 'codeNotMatching'){
                message('le code que vous avez saisie est faux!', 'js-msg-error');
            }

        </script>
    </body>
</html>