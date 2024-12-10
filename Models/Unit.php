<?php
namespace Models;

class Unit {
    private ?string $id;
    private string $name;
    private int $cost;
    private string $origin;
    private string $urlImg;

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

    public function setUrlImg(string $urlImg) : void {
        $this->urlImg = $urlImg;
    }

    public function getUrlImg() : string {
        return $this->urlImg;
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