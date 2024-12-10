<?php
namespace Models;

class UnitDAO extends BasePDODAO {
    public function getAll() : array {
        $lines = $this->execRequest("SELECT * FROM UNIT;")->fetchAll(PDO::FETCH_FUNC, Unit::class);

    }
}