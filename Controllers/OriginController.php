<?php
namespace Controllers;

class OriginController {
    private \League\Plates\Engine $templates;

    public function __construct(\League\Plates\Engine $templates) {
        $this->templates = $templates;
    }

    public function displayAddOrigin(?string $message = null) : void {
        echo $this->templates->render('add-origin', ['message' => $message]);
    }
    
    public function addOrigin(array $data) : void {
        $origin = (new \Models\Origin($data));
        try {
            (new \Models\OriginDAO())->createOrigin($origin);
        } catch (\PDOException $e) {
            $this->displayAddOrigin($e);
            return;
        }
        ?><script>
            history.replaceState(null, "", "<?= strtok($_SERVER["REQUEST_URI"], '?') ?>");
        </script><?php
        (new \Controllers\MainController($this->templates))->index("Origin '". $origin->getName() . "' added");
    }
}