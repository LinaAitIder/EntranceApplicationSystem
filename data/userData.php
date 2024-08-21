<?php 
class User {
  public $nom;
  public $prenom;
  public $log;
  public $email ;
  public $mdp ;
  public $naissance;
  public $diplome;
  public $niveau;
  public $etab ;
  public $cv;
  public $photo;
  public $token;
  public $verifStatus;
  // function __construct($userDetails)
public static function getUserInformation($connexion ,$login){

  $query="SELECT * FROM etud3a WHERE log = :login Union SELECT * FROM etud4a WHERE log = :login";
              $stmt = $connexion->prepare($query);
              $stmt->execute(['login' => $login]); 
              $result = $stmt->fetch(PDO::FETCH_ASSOC); 
             return $result;
}}



?>