<?php
  session_start();

  require './data/database.php';
  require './data/user.php';
  require './utils/functions.php';
  require './controller/userController.php';
  require './View/userView.php';
  require './controller/authController.php';
  require './utils/pdfGenerator.php';

 

  $action=$_GET['action'];
  echo $action;
  var_dump($_POST);
 
  switch($action){
    case 'signIn':
      $userUrl = './View/recap.php';
      $adminUrl = './View/administration.php ';
      pageAccess($userUrl , $adminUrl);

      $userController = new userController(new user , new Database);
      if(isset($_POST['signUp'])) {
          $userController->SignIn();
         
      } else {
          echo "Sign up data not submitted ";
      }
      break;
    case 'login':
      $userUrl = './View/recap.php';
      $adminUrl = './View/administration.php ';
      pageAccess($userUrl , $adminUrl);

      if(isset($_POST['submit'])){
        $login=$_POST['log'];
        $pass=$_POST['mdp'];

        if( $login ==='admin' && $pass ==='admin') {
            $_SESSION['userType'] = 'admin';
            header("Location:./View/administration.php");
            exit();
        }

        else {
            $authController = new authController(new Database , $user);
             $authController->login($login,$pass);
        }
      }
      break;
   
    case 'logout':
      session_destroy();
      header('Location:./View/authentification.php');
      break;

    case 'deleteAccount':
      $db = new Database;
      $connexion = $db->connect();
      $user = unserialize($_SESSION['user']);
      $user->deleteAccount($connexion , $user->log , $user->niveau);
      header("Location:./View/authentification.php");
      break;

    case 'updateAccount':
      var_dump($_POST);
      $user = unserialize($_SESSION['user']);
      $db = new Database;
      $userLogin = $user->log;

      if (isset($_POST['modifier'])) {
        $userController = new userController($user , $db);
        $userController->updateUserInfo($user);

        try { 
          $db->updateData($user , $userLogin);
        } catch(Exception $error){
          echo 'Error : '. $error->getMessage();
        };

      $niveau = nameLevel($user->niveau);
      userView::updateRecap($user , $niveau);
     
      }
      else { 
        echo "the post data doesn't woek";
      }
      break;

    default :
      echo '<script>alert(Il y\'a eu un probleme , Veuillez retourner a la page precedente!);</script>';
  }

?>
