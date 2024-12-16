<?php
namespace Controllers\Router;

abstract class Route {
    public function action(array $params=array(), string $method = 'GET') {

    }

    protected function getParam(array $array, string $paramName, bool $canBeEmpty = true) {

    }

    abstract public function get(array $params = array());

    abstract public function post(array $params = array());
}