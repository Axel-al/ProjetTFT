<?php
namespace Controllers\Router;

class Router {
    private array $ctrlList;
    private array $routeList;
    private string $action_key;

    public function __construct(string $name_of_action_key = "action") {
        $this->action_key = $name_of_action_key;
        $this->createControllerList();
        $this->createRouteList();
    }

    private function createControllerList() : void {
        $this->ctrlList = [
            "main" => new \Controllers\MainController(new \League\Plates\Engine('./Views/')),
            "unit" => new \Controllers\UnitController(new \League\Plates\Engine('./Views/')),
            "origin" => new \Controllers\OriginController(new \League\Plates\Engine('./Views/'))
        ];
    }

    private function createRouteList() : void {
        $this->routeList = [
            "index" => new \Controllers\Router\Route\RouteIndex($this->ctrlList['main']),
            "add-unit" => new \Controllers\Router\Route\RouteAddUnit($this->ctrlList['unit']),
            "search" => new \Controllers\Router\Route\RouteSearch($this->ctrlList['main']),
            "add-origin" => new \Controllers\Router\Route\RouteAddOrigin($this->ctrlList['origin']),
            "del-unit" => new \Controllers\Router\Route\RouteDelUnit($this->ctrlList['unit']),
            "edit-unit" => new \Controllers\Router\Route\RouteEditUnit($this->ctrlList['unit']),
            "result-search" => new \Controllers\Router\Route\RouteResultSearch($this->ctrlList['main'])
        ];
    }

    public function routing(array $get, array $post) : void {
        if (isset($get[$this->action_key]) && isset($this->routeList[$get[$this->action_key]])) {
            $route = $this->routeList[$get[$this->action_key]];
        } else {
            $route = $this->routeList['index'];
        }
        $route->action($_SERVER['REQUEST_METHOD'] == 'GET' ? $get : $post, $_SERVER['REQUEST_METHOD']);
    }
}