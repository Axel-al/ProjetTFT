<?php
namespace Models;

class UnitDAO extends BasePDODAO {
    public function __construct() {
        if (($stmt = $this->execRequest("SELECT COUNT(*) FROM UNIT;")) === false || $stmt->fetch(\PDO::FETCH_ASSOC)['COUNT(*)'] === 0) {
            $this->execRequest("
            CREATE TABLE IF NOT EXISTS UNIT (
                id VARCHAR(13) PRIMARY KEY,
                name VARCHAR(14) NOT NULL,
                cost INT NOT NULL,
                origin VARCHAR(14) NOT NULL,
                url_img VARCHAR(91) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
            
            $data = json_decode(file_get_contents("./data/champs_info.json"), true);
            
            $origin_count = [];
            foreach ($data as $unit) {
                foreach ($unit['origins'] as $origin) {
                    if (!isset($origin_count[$origin])) {
                        $origin_count[$origin] = 0;
                    }
                    $origin_count[$origin]++;
                }
            }

            foreach ($data as $unit) {
                $selected_origin = $unit['origins'][0];
                foreach ($unit['origins'] as $origin) {
                    if ($origin_count[$origin] === 1) {
                        $selected_origin = $origin;
                        break;
                    }
                }

                $this->execRequest("INSERT INTO UNIT (id, name, cost, origin, url_img) VALUES (:id, :name, :cost, :origin, :url_img);",
                    ['id' => uniqid(), 'name' => $unit['name'], 'cost' => $unit['cost'], 'origin' => $selected_origin, 'url_img' => $unit['url_img']]);
            }
        }
    }

    public function getAll() : array {
        return $this->downloadImages($this->execRequest("SELECT * FROM UNIT;")->fetchAll(\PDO::FETCH_CLASS, "\Models\Unit"));
    }

    public function getByID(string $idUnit) : ?Unit {
        $stmt = $this->execRequest("SELECT * FROM UNIT WHERE id = :id;", ["id" => $idUnit]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "\Models\Unit");
        $unitObj = $stmt->fetch();
        return !$unitObj ? null : $this->downloadImages(array($unitObj))[0];
    }

    private function downloadImages(array $listUnits) : array {
        $path_dir = "./public/img/";
        if (!is_dir($path_dir)) {
            mkdir($path_dir);
        }
        foreach ($listUnits as $unit) {
            $url = $unit->getUrl_img();
            $imagePath = "./public/img/" . basename(parse_url($url, PHP_URL_PATH));
            $unit->setUrl_img($imagePath);
            if (file_exists($imagePath)) {
                continue;
            }
            $ch = curl_init($url);
            $file = fopen($imagePath, 'w');
            curl_setopt_array($ch, [CURLOPT_FILE => $file, CURLOPT_FOLLOWLOCATION => true, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false]);
            if (curl_exec($ch) === false) {
                echo "<!--Curl error : " . curl_error($ch) . "-->";
            }
            curl_close($ch);
            fclose($file);
        }
        return $listUnits;
    }
}