<?php
namespace Models;

class Unit {
    private ?string $id;
    private string $name;
    private int $cost;
    private string $origin;
    private string $url_img;

    public function __construct(?string $id = null, string $name = null, int $cost = null, string $origin = null, string $url_img = null) {
        if (is_null($id) && is_null($name) && is_null($cost) && is_null($origin) && is_null($url_img)) {
            return;
        }
        $this->id = $id;
        $this->name = $name;
        $this->cost = $cost;
        $this->origin = $origin;
        $this->url_img = $url_img;
    }

    public function setId(?string $id) : void {
        $this->id = $id;
    }

    public function getId() : ?string {
        return $this->id;
    }

    public function setName(string $id) : void {
        $this->Name = $Name;
    }

    public function getName() : string {
        return $this->Name;
    }

    public function setCost(int $cost) : void {
        $this->cost = $cost;
    }

    public function getCost() : int {
        return $this->cost;
    }

    public function setOrigin(string $origin) : void {
        $this->origin = $origin;
    }

    public function getOrigin() : string {
        return $this->origin;
    }

    public function setUrl_img(string $url_img) : void {
        $this->url_img = $url_img;
    }

    public function getUrl_img() : string {
        return $this->url_img;
    }

    public function hydrate(array $data): Character {
        foreach ($data as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }
}