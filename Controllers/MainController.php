<?php
namespace Controllers;

class MainController {
    protected \League\Plates\Engine $templates;

    public function __construct(\League\Plates\Engine $templates) {
        $this->setTemplates($templates);
    }

    public function setTemplates(\League\Plates\Engine $templates) : void {
        $this->templates = $templates;
    }

    public function index() : void {
        echo $this->templates->render('home', ['tftSetName' => 'Remix Rumble']);
        }
}