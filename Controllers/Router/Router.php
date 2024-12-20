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
            "unit" => new \Controllers\UnitController(new \League\Plates\Engine('./Views/'))
        ];
    }

    private function createRouteList() : void {
        $this->routeList = [
            "index" => new \Controllers\Router\Route\RouteIndex($this->ctrlList['main']),
            "add-unit" => new \Controllers\Router\Route\RouteAddUnit($this->ctrlList['unit'])
        ];
    }

    public function routing(array $get, array $post) : void {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($get['action'])) {
            $this->routeList[$get['action']]->action($get, 'GET');
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($post['action'])) {
            $this->routeList[$post['action']]->action($post, 'POST');
        } else {
            $this->routeList['index']->action();
        }
    }
}