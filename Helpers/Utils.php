<?php
namespace Helpers;

class Utils {
    public static function downloadImages(array $listEntities, string $imageDir = "./public/img/") : array {
        if (!is_dir($imageDir)) {
            mkdir($imageDir, 0777, true);
        }
        foreach ($listEntities as $entity) {
            $url = $entity->getUrl_img();
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                continue;
            }
            $imagePath = $imageDir . basename(parse_url($url, PHP_URL_PATH));
            $entity->setUrl_img($imagePath);
            if (file_exists($imagePath)) {
                continue;
            }
            $ch = curl_init($url);
            $file = fopen($imagePath, 'w');
            curl_setopt_array($ch, [CURLOPT_FILE => $file, CURLOPT_FOLLOWLOCATION => true, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false]);
            if (curl_exec($ch) === false) {
                trigger_error("Curl error : " . curl_error($ch));
            }
            curl_close($ch);
            fclose($file);
        }
        return $listEntities;
    }
}