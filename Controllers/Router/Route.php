<?php
namespace Controllers\Router;

abstract class Route {
    public function action(array $params = array(), string $method = 'GET') : void {
        try {
            $this->{strtolower($method)}($params);
        } catch(\BadMethodCallException $e) {
            throw new \Exception("Unknown method '$method'");
        }
    }

    protected function getParam(array $array, string $paramName, bool $canBeEmpty = true) : string {
        if (isset($array[$paramName])) {
            if(!$canBeEmpty && empty($array[$paramName]))
                throw new \Exception("Empty parameter '$paramName'");
            return $array[$paramName];
        } else
            throw new \Exception("Missing parameter '$paramName'");
    }

    abstract public function get(array $params = array()) : void;

    abstract public function post(array $params = array()) : void;
}