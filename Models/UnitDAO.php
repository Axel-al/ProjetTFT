<?php
namespace Models;

class UnitDAO extends BasePDODAO {
    public function __construct() {
        (new \Models\DatabaseInitializer())->init();
    }

    public function getAll() : array {
        $Units = \Helpers\Utils::downloadImages($this->execRequest("SELECT * FROM UNIT ORDER BY name;")->fetchAll(\PDO::FETCH_CLASS, "\Models\Unit"));
        foreach ($Units as $unit) {
            $unit->setOrigins((new \Models\OriginDAO())->getOriginsForUnit($unit->getId()));
        }
        return $Units;
    }

    public function getByID(string $idUnit) : ?Unit {
        $stmt = $this->execRequest("SELECT * FROM UNIT WHERE id = :id;", ["id" => $idUnit]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "\Models\Unit");
        $unit = $stmt->fetch();
        $unit?->setOrigins((new \Models\OriginDAO())->getOriginsForUnit($unit->getId()));
        return !$unit ? null : $unit;
    }

    public function createUnit(Unit $unit) : void {
        $error = new \PDOException("Error while creating unit");
        $stmt = $this->execRequest("INSERT INTO UNIT (id, name, cost, url_img) VALUES (:id, :name, :cost, :url_img);",
            ['id' => $unit->getId(), 'name' => $unit->getName(), 'cost' => $unit->getCost(), 'url_img' => $unit->getUrl_img()], $error);
        if ($stmt === false) {
            throw $error;
        }

        try {
            $origins = $unit->getOrigins();
            if ($origins !== null) {
                $error = new \PDOException("Error while creating unit origins");
                foreach ($origins as $origin) {
                    $stmt = $this->execRequest("INSERT INTO UNITORIGIN (id_unit, id_origin) VALUES (:id_unit, :id_origin);",
                        ['id_unit' => $unit->getId(), 'id_origin' => $origin->getId()], $error);
                    if ($stmt === false) {
                        throw $error;
                    }
                }
            } else {
                throw new \Exception("Error while creating unit: no origins provided");
            }
        } catch (\Exception $e) {
            $this->deleteUnit($unit->getId());
            throw $e;
        } catch (\Error $e) {
            throw new \Exception("Error while updating unit: no origins provided");
        }
    }

    public function deleteUnit(string $idUnit = '-1') : int {
        $error = new \PDOException("Error while deleting unit");
        $stmt = $this->execRequest("DELETE FROM UNIT WHERE id = :id;", ["id" => $idUnit], $error);
        if ($stmt === false) {
            throw $error;
        }
        return $stmt->rowCount();
    }

    public function updateUnit(Unit $unit) : bool {
        $error = new \PDOException("Error while updating unit");
        $stmt = $this->execRequest("UPDATE UNIT SET name = :name, cost = :cost, url_img = :url_img WHERE id = :id;",
            ['id' => $unit->getId(), 'name' => $unit->getName(), 'cost' => $unit->getCost(), 'url_img' => $unit->getUrl_img()], $error);
        if ($stmt === false) {
            throw $error;
        }
        
        try {
            $lastOrigins = (new \Models\OriginDAO())->getOriginsForUnit($unit->getId());
        } catch (\Exception $e) {
            $lastOrigins = [];
        }

        try {
            $origins = $unit->getOrigins();
            if ($origins === array()) {
                throw new \Exception("Error while updating unit: origins were empty");
            }
            $error = new \PDOException("Error while updating unit origins");
            if ($this->execRequest("DELETE FROM UNITORIGIN WHERE id_unit = :id_unit;", ['id_unit' => $unit->getId()], $error) === false) {
                throw $error;
            }
        } catch (\Exception $e) {
            throw $e;
        } catch (\Error $e) {
            throw new \Exception("Error while updating unit: " . $e);
        }

        try {
            foreach ($origins as $origin) {
                if (!is_object($origin) || !method_exists($origin, 'getId')) {
                    throw new \Exception("Error while updating unit: Origin is not an object or does not have an id");
                }
                $stmt = $this->execRequest("INSERT INTO UNITORIGIN (id_unit, id_origin) VALUES (:id_unit, :id_origin);",
                    ['id_unit' => $unit->getId(), 'id_origin' => $origin->getId()], $error);
                if ($stmt === false) {
                    throw $error;
                }
            }
        } catch (\Exception $e) {
            $error = new \PDOException("Error while restauring unit origins");
            foreach ($lastOrigins as $origin) {
                $stmt = $this->execRequest("INSERT INTO UNITORIGIN (id_unit, id_origin) VALUES (:id_unit, :id_origin);",
                    ['id_unit' => $unit->getId(), 'id_origin' => $origin->getId()], $error);
                if ($stmt === false) {
                    throw $error;
                }
            }
            throw $e;
        }

        return $this->execRequest("SELECT COUNT(*) FROM UNIT WHERE id = :id;", ["id" => $unit->getId()])->fetchColumn() > 0;
    }
}