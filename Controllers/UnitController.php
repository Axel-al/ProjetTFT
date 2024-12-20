<?php
namespace Controllers;

class UnitController {
    private \League\Plates\Engine $templates;

    public function __construct(\League\Plates\Engine $templates) {
        $this->templates = $templates;
    }

    public function displayAddUnit(array $params) : void {
        echo $this->templates->render('add-unit', $params);
    }
}