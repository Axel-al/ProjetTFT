<?php
namespace Controllers\Router\Route;

class RouteAddOrigin extends \Controllers\Router\Route {
    private \Controllers\OriginController $controler;

    public function __construct(\Controllers\OriginController $controler) {
        $this->controler = $controler;
    }

    public function get(array $params = array()) : void {
        $this->controler->displayAddOrigin();
    }
    
    public function post(array $params = array()) : void {
        try {
            $data = [
                "name" => parent::getParam($params, "name", false),
                "url_img" => parent::getParam($params, "url_img", false)
            ];
        } catch (\Exception $e) {
            $this->controler->displayAddOrigin($e);
            return;
        }
        $this->controler->addOrigin($data);
    }
}