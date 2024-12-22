<?php
namespace Models;

class DatabaseInitializer extends BasePDODAO {
    public function init() : void {
        if ($this->isTableEmpty('UNIT')) {
            $this->createUnitTable();
        }
        if ($this->isTableEmpty('ORIGIN')) {
            $this->createOriginTable();
        }
        if ($this->isTableEmpty('UNITORIGIN')) {
            $this->createUnitOriginTable();
        }
    }
    
    private function createUnitTable(bool $defaultUnits = true) : void {
        $this->execRequest("
            CREATE TABLE IF NOT EXISTS UNIT (
                id VARCHAR(13) PRIMARY KEY,
                name VARCHAR(255) UNIQUE NOT NULL,
                cost INT NOT NULL CHECK (cost BETWEEN 1 AND 5),
                url_img VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
        ");
        if ($defaultUnits) {
            $data = json_decode(file_get_contents("./data/champs_info.json"), true);
            foreach ($data as $unit) {
                $this->execRequest("INSERT INTO UNIT (id, name, cost, url_img) VALUES (:id, :name, :cost, :url_img);",
                    ['id' => uniqid(), 'name' => $unit['name'], 'cost' => $unit['cost'], 'url_img' => $unit['url_img']]);
            }
        }
    }

    private function createOriginTable(bool $defaultOrigins = true) : void {
        $this->execRequest("
            CREATE TABLE IF NOT EXISTS ORIGIN (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                url_img VARCHAR(255) UNIQUE NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
        ");
        if ($defaultOrigins) {
            $data = json_decode(file_get_contents("./data/origins_info.json"), true);
            foreach ($data as $origin) {
                $this->execRequest("INSERT INTO ORIGIN (name, url_img) VALUES (:name, :url_img);",
                    ['name' => $origin['name'], 'url_img' => $origin['url_img']]);
            }
        }
    }

    private function createUnitOriginTable(bool $defaultUnitOrigins = true) : void {
        $this->execRequest("
            CREATE TABLE IF NOT EXISTS UNITORIGIN (
                id INT AUTO_INCREMENT PRIMARY KEY,
                id_unit VARCHAR(13) NOT NULL,
                id_origin INT NOT NULL,
                FOREIGN KEY (id_unit) REFERENCES UNIT(id) ON DELETE CASCADE ON UPDATE CASCADE,
                FOREIGN KEY (id_origin) REFERENCES ORIGIN(id) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
        ");
        if ($defaultUnitOrigins) {
            $data = json_decode(file_get_contents("./data/champs_info.json"), true);
            foreach ($data as $unit) {
                $row = $this->execRequest("SELECT id FROM UNIT WHERE name = :name;", ['name' => $unit['name']])->fetch(\PDO::FETCH_ASSOC);
                if (!$row) {
                    continue;
                }
                $idUnit = $row['id'];
                foreach ($unit['origins'] as $origin) {
                    $row = $this->execRequest("SELECT id FROM ORIGIN WHERE name = :name;", ['name' => $origin])->fetch(\PDO::FETCH_ASSOC);
                    if (!$row) {
                        continue;
                    }
                    $idOrigin = $row['id'];
                    $this->execRequest("INSERT INTO UNITORIGIN (id_unit, id_origin) VALUES (:id_unit, :id_origin);",
                        ['id_unit' => $idUnit, 'id_origin' => $idOrigin]);
                }
            }
        }
    }

    private function isTableEmpty(string $tableName) : bool {
        $stmt = $this->execRequest("SELECT COUNT(*) FROM $tableName;");
        if ($stmt === false) {
            return true;
        }
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['COUNT(*)'] == 0;
    }
}