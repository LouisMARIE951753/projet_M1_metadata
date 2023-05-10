<?php 

// UPLOAD DE FICHIER 

$target_dir = "uploads/";
$target_file = basename($_FILES["fileToUpload"]["name"]);

$_SESSION['file'] = $target_dir . $target_file;

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $target_file)) {
  $file = new FileMTDT($target_dir . $target_file);
}

// CONTENU DE LA PAGE 

    // EN TETE

$content="";

$content .="<h1> Upload de : " . $_SESSION['file'] ."</h1>";

$content .= (getimagesize($target_dir . $target_file) !== false ? "<img src=\"uploads/". $_SESSION['file'] ."\">" : "");


    // PARTIE METADATA DE LA PAGE

$json = $file->getJSON();

$metadata = json_decode($json,true);


        // FORMULAIRE

        
            //FONCTION FORMULAIRE 


function MTDT_Array_Treatment($key,$value,$inputName,$parentKey = null){

  $content = "";

  if(!is_array($value)){

    $content .= "<div class=\"div_input_ta\" >";

    $content .= "<label class=\"label\">" . $key;

    if(strlen($value) < 50){ // si la chaine est trop longue on l'affiche en textarea pour plus de lisibilité

      $content.="<input class=\"input\" class= type=\"text\" value=".$value." name=" . $inputName . " >";

    } else {

      $content.="<textarea class=\"textarea\" name=". $inputName ." cols=\"40\" rows=\"5\">".$value."</textarea>";

    }

    $content .= "</label>";

    $content .= "</div>";


  } else {

    $content .= "<div class=\"div_Grp\" >";

    $content .= "<label class=\"lbl_Grp\" > " . $key ;

    foreach ($value as $keyOfValue => $val) {

      $content .= MTDT_Array_Treatment($keyOfValue,$val,$inputName . "[" . $keyOfValue . "]",$key);

    }

    $content .= "</label>";

    $content .= "</div>";

  }

  return $content;
  
}

            // CONTENU FORMULAIRE


if(!is_null($metadata)){

  $content .= "<form class=\"form\"  action=\"index.php?action=insert\" method=\"post\" enctype=\"multipart\form-data\" ";

  foreach ($metadata[0] as $key => $value) {

    $content .= MTDT_Array_Treatment($key,$value,$key);

  }

  $content .= "<input id=\"form_button\" type=\"submit\" value=\"Modifier\"/>";

  $content .= "</form>";

}

echo $content;


?>





