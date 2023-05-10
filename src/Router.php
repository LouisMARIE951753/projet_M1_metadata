<?php

include_once 'view/View.php';
include_once 'control/Controller.php';

class Router{


  /* ATTRIBUTS */


  private $url;


  /* CONSTUCTEUR */


  public function __construct(){
    $this->url = "https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
  }


  /* METHODE PRINCIPALE */


  public function main(){

    session_start();

    $view = new View($this);

    $control = new Controller($view);

    $action = (isset($_GET['action']) ? $_GET['action'] : "accueil");


    switch ($action){

        case "accueil":
          $control->showAccueilPage();
          break;

        case "upload":
          $control->upload($_POST);
          break;

        default:
          $control->showAccueilPage();
          break;
        
    }

    $control->showRender();

  }

  public function getAccueilURL(){
    return $this->url . "?action=accueil";
  }

  public function getUploadURL(){
    return $this->url . "?action=upload";
  }
}


?>
