<?php
foreach ($_POST as $key => $value) {
  $exiftool="Image-ExifTool-12.52/exiftool -XMP-dc:";
  $exiftool.=$key."=".$value;
  $exiftool.=" ". "../uploads/".$_GET["p"];
  ob_start();
  passthru($exiftool);
  $perlreturn = ob_get_contents();
  ob_end_clean();
}


?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Métadonnées</title>
</head>
<body>
  <p> Bonjour </p>
  <h1> INSERT </h1>
  <p> sexe </p>
  <a href="../../index.php"> RETOUR VERS LE PASSE DE LA FUTUR </a>


</body>
</html>
