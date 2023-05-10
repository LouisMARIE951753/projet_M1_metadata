<?php

include_once 'view/View.php';

include_once 'lib/MTDT/php/FileMTDT.php';

class Controller{

  /*   ATTRIBUTS */

  private $view;


  /* CONSTRUCTEUR */


  public function __construct(View $view){
    $this->view = $view;
  }

  public function upload($post){
    $target_dir = "uploads/";
    $target_file = basename($_FILES["fileToUpload"]["name"]);

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $target_file)) {
      $_SESSION['file'] = $target_dir . $target_file;
    }
    
    $this->showFilePage($_SESSION['file']);
  }

  public function showFilePage($file){

    try {
      $obj_File = new FileMTDT($file);
    } catch (Exception $e) {
      $this->showErrorPage($e->getMessage());
    }

    $json = json_decode($obj_File->getJSONMetadata(),true);

    $this->view->makeFilePage($json[0]);
  }

  
  public function showAccueilPage(){
    $this->view->makeAccueilPage();
  }

  public function showRender(){
    $this->view->render();
  }

  public function showErrorPage($msg){
    $this->view->makeErrorPage($msg);
  }
  


}

 ?>
