<?php
namespace Controllers;

class MainController {
    private \League\Plates\Engine $templates;

    public function __construct(\League\Plates\Engine $templates) {
        $this->templates = $templates;
    }

    public function index() : void {
        $dao = new \Models\UnitDAO();
        echo $this->templates->render('home', ['tftSetName' => 'Remix Rumble', 'getAll' => $dao->getAll(), 'getByIdQuiExiste' => $dao->getByID('oingroignrgin'), 'getByIdQuiExistePas' => $dao->getByID('rgnrgrgoir')]);
    }
}