<?php
namespace Controllers\Router\Route;

class RouteAddUnit extends \Controllers\Router\Route {
    private \Controllers\UnitController $controler;

    public function __construct(\Controllers\UnitController $controler) {
        $this->controler = $controler;
    }

    public function get(array $params = array()) : void {
        $this->controler->displayAddUnit($params);
    }

    public function post(array $params = array()) : void {

    }
}