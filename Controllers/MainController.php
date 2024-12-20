<?php
namespace Controllers;

class MainController {
    private \League\Plates\Engine $templates;

    public function __construct(\League\Plates\Engine $templates) {
        $this->templates = $templates;
    }

    public function index() : void {
        $listUnits = (new \Models\UnitDAO())->getAll();
        echo $this->templates->render('home', [
            'tftSetName' => 'Into the Arcane',
            'listUnits' => $listUnits
        ]);
    }
}