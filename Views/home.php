<?php
$this->layout('template', ['title' => 'TP TFT']);
?>
<h1>TFT - Set <?= $this->e($tftSetName) ?></h1>
<div><?php var_dump($getAll)?></div>
<div><?php var_dump($getByIdQuiExiste)?></div>
<div><?php var_dump($getByIdQuiExistePas)?></div>