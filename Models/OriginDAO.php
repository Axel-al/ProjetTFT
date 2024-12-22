<?php
namespace Models;

class OriginDAO extends BasePDODAO {
    public function __construct() {
        (new \Models\DatabaseInitializer())->init();
    }

    public function getAll() : array {
        return $this->execRequest("SELECT * FROM ORIGIN ORDER BY name;")->fetchAll(\PDO::FETCH_CLASS, "\Models\Origin");
    }

    public function getByID(int $idOrigin) : ?Origin {
        $stmt = $this->execRequest("SELECT * FROM ORIGIN WHERE id = :id;", ["id" => $idOrigin]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "\Models\Origin");
        $originObj = $stmt->fetch();
        return !$originObj ? null : $originObj;
    }

    public function createOrigin(Origin $origin) : Origin {
        $error = new \PDOException("Error while creating origin");
        if ($this->execRequest("INSERT INTO ORIGIN (name, url_img) VALUES (:name, :url_img);",
            ['name' => $origin->getName(), 'url_img' => $origin->getUrl_img()], $error) === false) {
            throw $error;
        }
        $origin->setId($this->getDB()->lastInsertId());
        return $origin;
    }

    public function deleteOrigin(int $idOrigin) : int {
        $error = new \PDOException("Error while deleting origin");
        $stmt = $this->execRequest("DELETE FROM ORIGIN WHERE id = :id;", ["id" => $idOrigin], $error);
        if ($stmt === false) {
            throw $error;
        }
        return $stmt->rowCount();
    }

    public function updateOrigin(Origin $origin) : bool {
        $error = new \PDOException("Error while updating origin");
        $stmt = $this->execRequest("UPDATE ORIGIN SET name = :name, url_img = :url_img WHERE id = :id;",
            ['id' => $origin->getId(), 'name' => $origin->getName(), 'url_img' => $origin->getUrl_img()], $error);
        if ($stmt === false) {
            throw $error;
        }
        return $this->execRequest("SELECT COUNT(*) FROM ORIGIN WHERE id = :id;", ["id" => $origin->getId()])->fetchColumn() > 0;
    }

    public function getOriginsForUnit(string $unitId) : array {
        $stmt = $this->execRequest("SELECT ORIGIN.id, name, url_img FROM UNITORIGIN JOIN ORIGIN ON id_origin = ORIGIN.id WHERE id_unit = :id_unit;", ["id_unit" => $unitId]);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, "\Models\Origin");
    }
}