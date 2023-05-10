<?php

var_dump($_SESSION);

$file = new FileMTDT($_SESSION['file']);

$file->setJSON($_POST);

?>