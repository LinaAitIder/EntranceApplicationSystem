<?php
  session_start();

  $action=$_GET['action'];
  // echo $action;
  // var_dump($_POST);
 
  switch($action){
    case 'signIn':
      require_once 'utils/functions.php';
      require_once 'verificationActions.php';
      require_once 'controller/userController.php';
      require 'utils/pdfGenerator.php';
      require_once 'data/database.php';
      require_once 'data/user.php';

      // Managing page Access
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
      require 'data/database.php';
      require 'data/user.php';
      require 'controller/authController.php';
      require 'utils/functions.php';

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
      require 'data/database.php';
      require 'data/user.php';
      $db = new Database;
      $connexion = $db->connect();
      $user = unserialize($_SESSION['user']);
      $user->deleteAccount($connexion , $user->log , $user->niveau);
      session_destroy();
      header("Location:./View/authentification.php");
      break;

    case 'updateAccount':
      require 'controller/userController.php';
      require 'controller/viewController.php';
      require 'data/database.php';
      require 'data/user.php';
      require 'utils/functions.php';

      var_dump($_POST);
      $user = unserialize($_SESSION['user']);
      $db = new Database;
      $userLogin = $user->log;
      ECHO  "avant la modification de Db ".$user->niveau ;

      if (isset($_POST['modifier'])) {
        try { 
          $db->updateData($user , $userLogin);
        } catch(Exception $error){
          echo 'Error : '. $error->getMessage();
        };
       
        ECHO  "/n apres la modification de Db " . $user->niveau ;

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
