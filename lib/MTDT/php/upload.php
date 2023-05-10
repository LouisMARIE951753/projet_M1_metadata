<?php


$exiftool = "Image-ExifTool-12.52/exiftool -json -g1 " . $target_file ;
ob_start();
passthru($exiftool);
$perlreturn = ob_get_contents();
ob_end_clean();

$json = json_decode($perlreturn,true);


?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Métadonnées</title>
</head>
<body>
  <p> Bonjour </p>
  <h1>
  <?php
  echo $_FILES["fileToUpload"]["name"];
  ?> </h1>
  <form action="<?php echo "insert.php?p=" . basename($_FILES["fileToUpload"]["name"]);?>" method="post" enctype="multipart/form-data">
    <?php
    $content="";
    foreach ($json[0]["XMP-dc"] as $key => $value) {
      if(!is_array($value)){
        $content.= "<label>" . $key . "</label>";
        if($key == "Description"){
          $content.="<textarea name=".$key." cols=\"40\" rows=\"5\">".$value."</textarea>";
        } else {
          $content.="<input type=\"text\" value=".$value." name=" . $key . " >";
        }
      }
    }
    echo $content;
    ?>
    <input type="submit" value="Insert METADONNE INTO THE METAIMAGE VIA METAINSERT METAFUTURE METAVOITURELA">
  </form>


</body>
</html>


<?php




?>
