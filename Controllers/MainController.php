<?php
namespace Controllers;

class MainController {
    private \League\Plates\Engine $templates;

    public function __construct(\League\Plates\Engine $templates) {
        $this->templates = $templates;
    }

    public function index(?string $message = null) : void {
        $listUnits = (new \Models\UnitDAO())->getAll();
        echo $this->templates->render('home', [
            'tftSetName' => 'Into the Arcane',
            'listUnits' => $listUnits,
            'attributes' => (new \ReflectionClass(new \Models\Unit))->getProperties(\ReflectionProperty::IS_PRIVATE),
            'message' => $message
        ]);
    }

    public function search(?string $message = null) : void {
        echo $this->templates->render('search', [
            'attributes' => (new \ReflectionClass(new \Models\Unit))->getProperties(\ReflectionProperty::IS_PRIVATE),
            'message' => $message
        ]);
    }
}