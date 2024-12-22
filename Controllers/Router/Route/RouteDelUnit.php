<?php
namespace Controllers\Router\Route;

class RouteDelUnit extends \Controllers\Router\Route {
    private \Controllers\UnitController $controler;

    public function __construct(\Controllers\UnitController $controler) {
        $this->controler = $controler;
    }

    public function get(array $params = array()) : void {
        try {
            $idUnit = parent::getParam($params, 'id', false);
        } catch (\Exception $e) {
            $this->controler->deleteUnitAndIndex(null, $e);
            return;
        }
        $this->controler->deleteUnitAndIndex($idUnit);
    }

    public function post(array $params = array()) : void {
        $this->controler->deleteUnitAndIndex(null, new \Exception("Method 'POST' not allowed"));
    }
}