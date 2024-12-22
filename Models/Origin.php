<?php
namespace Models;

class Origin {
    private ?int $id;
    private string $name;
    private string $url_img;

    public function __construct(array $data = array()) {
        $this->hydrate($data);
    }

    public function setId(?int $id) : void {
        $this->id = $id;
    }

    public function getId() : ?int {
        return $this->id;
    }

    public function setName(string $name) : void {
        $this->name = $name;
    }

    public function getName() : string {
        return $this->name;
    }

    public function setUrl_img(string $url_img) : void {
        $this->url_img = $url_img;
    }

    public function getUrl_img() : string {
        return $this->url_img;
    }

    public function hydrate(array $data) : Origin {
        foreach ($data as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }
}