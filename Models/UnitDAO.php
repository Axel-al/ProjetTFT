<?php
namespace Models;

class UnitDAO extends BasePDODAO {
    public function getAll() : array {
        $this->execRequest("SELECT");
    }
}