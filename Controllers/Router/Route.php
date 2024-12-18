<?php
namespace Controllers\Router;

abstract class Route {
    public function action(array $params=array(), string $method = 'GET') {

    }

    protected function getParam(array $array, string $paramName, bool $canBeEmpty = true) {
        if (isset($array[$paramName])) {
            if(!$canBeEmpty && empty($array[$paramName]))
                throw new Exception("Paramètre '$paramName' vide");
            return $array[$paramName];
        } else
            throw new Exception("Paramètre '$paramName' absent");
    }

    abstract public function get(array $params = array());

    abstract public function post(array $params = array());
}