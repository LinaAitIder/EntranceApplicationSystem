\<html>
    <head>
    <link rel="stylesheet" href="../styles/StylePage.css">
    </head>
    <body>
        <div class="container">
            <form method="post" class="form" action='../verificationActions.php?action=verifyAccount'>
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
