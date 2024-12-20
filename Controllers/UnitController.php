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

    public function displayAddOrigin(array $params) : void {
        echo $this->templates->render('add-origin', $params);
    }

    public function delUnit(array $params) : void {
        // $unitDAO = new \Models\UnitDAO();
        // $unitDAO->delete($params['id']);
        header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
    }
}