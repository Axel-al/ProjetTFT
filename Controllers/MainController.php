<?php
namespace Controllers;

class MainController {
    private \League\Plates\Engine $templates;

    public function __construct(\League\Plates\Engine $templates) {
        $this->templates = $templates;
    }

    public function index(array $params) : void {
        $listUnits = (new \Models\UnitDAO())->getAll();
        echo $this->templates->render('home', array_merge([
            'tftSetName' => 'Into the Arcane',
            'listUnits' => $listUnits
        ], $params));
    }

    public function search(array $params) : void {
        echo $this->templates->render('search', $params);
    }
}