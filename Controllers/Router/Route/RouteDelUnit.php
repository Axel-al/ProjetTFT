<?php
namespace Controllers\Router\Route;

class RouteDelUnit extends \Controllers\Router\Route {
    private \Controllers\UnitController $controler;

    public function __construct(\Controllers\UnitController $controler) {
        $this->controler = $controler;
    }

    public function get(array $params = array()) : void {
        $this->controler->delUnit($params);
    }

    public function post(array $params = array()) : void {
        $this->controler->delUnit($params);
    }
}