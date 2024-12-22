<?php
namespace Controllers\Router\Route;

class RouteEditUnit extends \Controllers\Router\Route {
    private \Controllers\UnitController $controler;

    public function __construct(\Controllers\UnitController $controler) {
        $this->controler = $controler;
    }

    public function get(array $params = array()) : void {
        try {
            $idUnit = parent::getParam($params, 'id', false);
        } catch (\Exception $e) {
            $this->controler->displayAddUnit($e);
            return;
        }
        $this->controler->displayEditUnit($idUnit);
    }

    public function post(array $params = array()) : void {
        try {
            $id = parent::getParam($params, "id", false);
            $origins = array_filter([
                ['id' => parent::getParam($params, "origin_0", false)],
                ['id' => parent::getParam($params, "origin_1", true)],
                ['id' => parent::getParam($params, "origin_2", true)]
            ], fn($origin) => !empty($origin["id"]));
            $data = [
                "id" => $id,
                "name" => parent::getParam($params, "name", false),
                "cost" => parent::getParam($params, "cost", false),
                "origins" => $origins,
                "url_img" => parent::getParam($params, "url_img", false)
            ];
        } catch (\Exception $e) {
            if (isset($id)) {
                $this->controler->displayEditUnit($id, $e);
                return;
            }
            (new \Controllers\Router\Router())->routing(array(), ["message" => $e]);
            return;
        }
        $this->controler->editUnitandIndex($data);
    }
}