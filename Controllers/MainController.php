<?php
namespace Controllers;

class MainController {
    private \League\Plates\Engine $templates;

    public function __construct(\League\Plates\Engine $templates) {
        $this->templates = $templates;
    }

    public function index() : void {
        $listUnits = (new \Models\UnitDAO())->getAll();
        $this->downloadImages($listUnits);
        echo $this->templates->render('home', ['tftSetName' => 'Into the Arcane', 'listUnits' => $listUnits]);
    }

    private function downloadImages(array $listUnits) : void {
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
    }
}