<?php
var_dump(glob($target_dir . "*"));

if(empty(glob($target_dir . "*"))){

  foreach (glob($target_dir . "*") as $filename) {
    unlink($filename);
  }

  $cleared = true;
}
?>
