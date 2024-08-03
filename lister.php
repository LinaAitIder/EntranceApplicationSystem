<?php 
session_start();
if($_SESSION['USER']!== 'admin'){ header("location: inscriptions.php");}
#how are we going to do with session_id()
require("ConnectFunc.php");
$con=connect();
$query="SELECT * FROM etud3a Union SELECT * FROM etud4a ";
$data = $con->query($query);
$rows = $data->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>liste des inscriptions</title>
    <link rel="stylesheet" href="Styles_h.css">
</head>
<body>
    <div class='table-container'>
    <center><h3><b>Liste des inscriptions</b></h3></center>
    <table border="1" style="width:100%; border-collapse: collapse;">
        <tr>  
         <th colspan='2'>nom</th>   
         <th colspan='2'>prenom</th>   
         <th colspan='6'>email</th>   
         <th colspan='6'>naissance</th>   
         <th colspan='6'>diplome</th>   
         <th colspan='2'>niveau</th>   
         <th colspan='6'>etablissement</th>   
         <th colspan='4'>photo</th>   
         <th colspan='4'>cv</th>
        </tr>
        <?php foreach($rows as $row){ ?>
        <tr> 
         <td colspan='2'><?php echo $row['nom'] ;?></td>   
         <td  colspan='2'><?php echo $row['prenom'] ;?></td>   
         <td  colspan='6'><?php echo $row['email'] ;?></td>   
         <td  colspan='6'><?php echo $row['naissance']; ?></td>   
         <td  colspan='6'><?php echo $row['diplome']; ?></td>   
         <td  colspan='2'><?php echo $row['niveau']; ?></td>   
         <td  colspan='6'><?php echo $row['etablissement']; ?></td>   
         <td colspan='4'><img src="<?php echo $row['photo'];?>" style="width: 100px; height: auto;"></td>   
         <td colspan='4'><a href="<?php echo $row['cv']; ?>" download> CV</a></td>
        <tr>
         <?php 
        }
        ?>
    </table>
    <br><br>
    <a href="deconnexion.php">se deconnecter</a>
    <br><br>
    </div>   
</body>

</html>