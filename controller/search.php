<?php
session_start();
require '../data/config.php';
 $db = new Database;
$connexion = $db->connect();
// GETTING THE VALUE
if(isset($_POST['user'])){
  $user = (String) trim($_POST['user']);
  $query = "
      SELECT * FROM (
          SELECT * FROM etud3a 
          WHERE etud3a.nom LIKE :user 
          UNION 
          SELECT * FROM etud4a 
          WHERE etud4a.nom LIKE :user
      ) AS combined_results
      LIMIT 10
  ";
  $stmt = $connexion->prepare($query);
  $stmt->execute([':user' => '%' . $user . '%']); // Use '%' for the LIKE search
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach($results as $result){
    echo '<div style="margin-top:20px; border-bottom:2px solid #ccc">';
    echo htmlspecialchars($result['nom']) . ' ' . htmlspecialchars($result['prenom']);
    echo '</div>';
  }
}




?>