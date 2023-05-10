<?php

include_once 'lib/MTDT/php/FileMTDT.php';

class View{

  // ATTRIBUTS


  private $titre;
  private $content;
  private $router;
  private $menuNav;
  private $acceptedMtdt = array('PDF','XMP-dc','XMP' );

  private const DIR_UPLOAD = "upload/";


  // CONSTRUCTEUR


  public function __construct($router){
    $this->router = $router;
    $this->titre = "";
    $this->content = "";
    $this->menuNav = array($this->router->getAccueilURL() => "Acceuil");
  }

  public function makeAccueilPage(){
    $this->titre .= "<h1>Accueil<h1>";
    $this->content .= "<form action=\"index.php?action=upload\" method=\"post\" enctype=\"multipart/form-data\">";
    $this->content .= "    <label>File to Upload :</label>";
    $this->content .= "<input type=\"file\" id=\"fileToUpload\" name=\"fileToUpload\">";
    $this->content .= "<input type=\"submit\" value=\"Upload File\" name=\"upload\">";
    $this->content .= "</form>"; 
  }

  public function makeFilePage($json){
    $this->titre = "<h1>Resultat</h1>";

    $obj_File = new FileMTDT();
    $this->content .= $obj_File->displayMetadataCheck($json);
    $this->content .= $obj_File->displayMetadata($json);
    $this->content .= "";

  }

  public function makeErrorPage($msg){
    $this->titre .="<h1>Error</h1>";
    $this->content .="<p> ".$msg."</p>";
  }

  private function getMenuLien(){
    echo "<ul class=\"header_menu_links\">";
    foreach ($this->menuNav as $url => $text){
      echo "<li>";
      echo "<a href=\"" . $url . "\">". $text ."</a>";
      echo "</li>";
    }
    echo "</ul>";
  }

  public function render(){

    include_once('lib/squeletteHTML.php');

  }
}


?>
