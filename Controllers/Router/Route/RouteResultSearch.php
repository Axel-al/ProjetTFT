<?php
namespace Controllers\Router\Route;

class RouteResultSearch extends \Controllers\Router\Route {
    private \Controllers\MainController $controler;

    public function __construct(\Controllers\MainController $controler) {
        $this->controler = $controler;
    }

    public function get(array $params = array()) : void {
        try {
            $attribute = $this->getParam($params, 'attribute', false);
            $query = $this->getParam($params, 'query', false);
            $data = [
                'attribute' => $attribute,
                'query' => $query
            ];
            if ('attribte' == 'name' && !is_string($query)) {
                throw new \Exception("Error: 'Name' should be a string");
            } else if ('attribute' == 'id' && !is_string($query)) {
                throw new \Exception("Error: 'ID' should be a string");
            } else if ('attribute' == 'cost' && !is_int($query)) {
                throw new \Exception("Error: 'Cost' should be a number");
            } else if ('attribute' == 'origins' && !is_string($query)) {
                throw new \Exception("Error: 'Origins' should be a string");
            } else if ('attribute' == 'url_img' && !is_string($query)) {
                throw new \Exception("Error: 'URL Image' should be a string");
            }
        } catch (\Exception $e) {
            $this->controler->search($e);
            return;
        }
        $this->controler->resultSearch($data);
    }
    
    public function post(array $params = array()) : void {
        $this->controler->search("Error: Method POST not allowed");
    }
}