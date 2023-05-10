<!DOCTYPE html>
<html lang='fr' dir='ltr'>
  <head>
    <meta charset='utf-8'>
    <title> Métadonnées </title>
    <link href="skin/screen.css" rel="stylesheet" type="text/css">
  </head>
  <body>

    <div class="titre">
      <?php echo $this->titre; ?>
    </div>

    <div class="menu-container">

        <?php $this->getMenuLien(); ?>

    </div>

    <div class="mainContent">
      <?php echo $this->content; ?>
    </div>

  </body>
</html>
