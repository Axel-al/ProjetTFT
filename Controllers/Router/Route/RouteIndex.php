<?php
namespace Controllers\Router\Route;

class RouteIndex extends \Controllers\Router\Route {
    private \Controllers\MainController $controler;

    public function __construct(\Controllers\MainController $controler) {
        $this->controler = $controler;
    }

    public function get(array $params = array()) {
        
    }

    public function post(array $params = array()) {

    }
}