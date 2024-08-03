<?php session_start();
if($_SESSION['USER'] != 'admin') header("location:Inscription.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminPanel</title>
    <link rel="stylesheet" href="Styles_h.css">
</head>
<body>

<body>
<br><br><br><br><br><br><br><br><br><br>
    <div class="container"><br><br><br>
        <form method="post" action="lister.php">
            <button type="submit" color="yellow">Obtenir Les Informations Des Condidats</button><br><br><br><br><br>
        </form>
        <a href="deconnexion.php">se deconnecter</a><br>
    </div>
</body>
<?php       
    if(isset($_POST['list'])){
        header("location:lister.php");
    }
             


?>
</body>
</html>