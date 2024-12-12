<?php
namespace Models;

class UnitDAO extends BasePDODAO {
    public function getAll() : array {
        return $this->execRequest("SELECT * FROM UNIT;")->fetchAll(\PDO::FETCH_CLASS, "\Models\Unit");
    }

    public function getByID(string $idUnit) : ?Unit {
        $stmt = $this->execRequest("SELECT * FROM UNIT WHERE id = :id;", ["id" => $idUnit]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "\Models\Unit");
        $unitObj = $stmt->fetch();
        return !$unitObj ? null : $unitObj;
    }
}