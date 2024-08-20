<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script>
    function vers_Modif() {
        window.location.href = 'modif.php';
    }

    function deconnecter() {
        window.location.href = 'controller/logout.php';
    }

    function suppr_cmpt() {
        window.location.href = 'suppr_cmpt.php';
    }

    function recu() {
        window.location.href = 'pdf_gen.php';
    }

    </script>

    <link rel="stylesheet" href="Styles_h.css">

</head>
<body>

<div class="container">
    <?php
    session_start();
    echo "<br>";    
    if (isset($_SESSION['recap_etud'])) {
        $result = $_SESSION['recap_etud'];
        echo "<h2>Informations de Candidature</h2>";
        echo "<div class='info'><strong>Identifiant :</strong> " . $result['ID']. "</div>";
        echo "<div class='info'><strong>Nom :</strong> " . $result['nom']. "</div>";
        echo "<div class='info'><strong>Prénom :</strong> " . $result['prenom']. "</div>";
        echo "<div class='info'><strong>Date de naissance :</strong> " . $result['naissance']. "</div>";
        echo "<div class='info'><strong>Diplôme :</strong> " . $result['diplome']. "</div>";
        $niveau = ($result['niveau'] == "nv3") ? "3ème année" : "4ème année";
        echo "<div class='info'><strong>Condidature :</strong> " . $niveau . "</div>";
        echo "<div class='info'><strong>Etablissement :</strong> " . $result['etablissement']. "</div>";
        echo "<div class='info'><strong>Email :</strong> " . $result['email'] . "</div><br>";
        echo "<img src='" . $result['photo'] . "' alt='Photo' style='width: 150px; height: auto;' />";
        echo "<br>";
        echo "<a href='" . $result['cv'] . "' download>Télécharger CV</a><br><br>";
    } else {
        echo "<p>Aucune information de candidature disponible.</p>";
    }
    ?>
</div>


<br><br><br><br>

<div class="button-container">
    <button type="button" onclick="vers_Modif()">Modifier</button> 
    <button type="button" onclick="deconnecter()">Se déconnecter</button>
    <button type="button" onclick="suppr_cmpt()">Supprimer le compte</button>
    <button type="button" onclick="recu()">Obtenir votre reçu PDF</button>
</div>

</body>
</html>
