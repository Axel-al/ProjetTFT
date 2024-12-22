<?php
namespace Models;

class Unit {
    private string $name;
    private ?string $id;
    private int $cost;
    private array $origins;
    private string $url_img;

    public function setId(?string $id) : void {
        if ($id === null) {
            $id = uniqid();
        }
        $this->id = $id;
    }

    public function getId() : ?string {
        return $this->id;
    }

    public function setName(string $name) : void {
        $this->name = $name;
    }

    public function getName() : string {
        return $this->name;
    }

    public function setCost(int $cost) : void {
        $this->cost = $cost;
    }

    public function getCost() : int {
        return $this->cost;
    }

    public function setOrigins(array $origins) : void {
        $this->origins = $origins;
    }

    public function getOrigins() : array {
        return $this->origins;
    }

    public function setUrl_img(string $url_img) : void {
        $this->url_img = $url_img;
    }

    public function getUrl_img() : string {
        return $this->url_img;
    }

    public function hydrate(array $data) : Unit {
        foreach ($data as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }
}