<?php
session_start();
$code_ver = $_GET['code'];
?>
<html>
    <head>
    <link rel="stylesheet" href="StylePage.css">
    </head>
    <body>
        <div class="container">
            <form method="post" class="form">
                <legend>Entrer votre code de confirmation , Veuillez consulter votre email :</legend>
                <input type="text" name="num" >
                <input type="submit" name="submit">
            </form>
        </div>
    </body>
</html>
<?php

if(isset($_POST['submit'])){
    $code=$_POST['num'];
    if($code === $code_ver ){
        header("location: authen.php");
        exit();
    }
    else {
        echo "<script>alert('Invalid code. Please try again.');</script>";
    }
}

/*
    Other Ideas :
    - adding a link : return to inscription -> Done : LINA
    - send another code 
    - un temps d'expiration de token
    -------------------------------------------------
    hihi :~) - HAYAT
    We couln't -_- I wish we had more time to add this - LINA
*/

?>