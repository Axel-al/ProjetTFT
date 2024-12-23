<?php
namespace Controllers\Router\Route;

class RouteAddUnit extends \Controllers\Router\Route {
    private \Controllers\UnitController $controler;

    public function __construct(\Controllers\UnitController $controler) {
        $this->controler = $controler;
    }

    public function get(array $params = array()) : void {
        $this->controler->displayAddUnit();
    }
    
    public function post(array $params = array()) : void {
        try {
            $origins = array_filter([
                ['id' => parent::getParam($params, "origin_0", false)],
                ['id' => parent::getParam($params, "origin_1", true)],
                ['id' => parent::getParam($params, "origin_2", true)]
            ], fn($origin) => !empty($origin['id']));
            $data = [
                "name" => parent::getParam($params, "name", false),
                "cost" => parent::getParam($params, "cost", false),
                "origins" => $origins,
                "url_img" => parent::getParam($params, "url_img", false)
            ];
        } catch (\Exception $e) {
            $this->controler->displayAddUnit($e);
            return;
        }
        $this->controler->addUnit($data);
    }
}