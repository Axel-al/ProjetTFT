<?php
namespace Controllers\Router\Route;

class RouteSearch extends \Controllers\Router\Route {
    private \Controllers\MainController $controler;

    public function __construct(\Controllers\MainController $controler) {
        $this->controler = $controler;
    }

    public function get(array $params = array()) : void {
        $this->controler->search();
    }
    
    public function post(array $params = array()) : void {
        $this->controler->search("Error: Method POST not allowed");
    }
}