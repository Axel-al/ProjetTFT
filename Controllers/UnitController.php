<?php
namespace Controllers;

class UnitController {
    private \League\Plates\Engine $templates;

    public function __construct(\League\Plates\Engine $templates) {
        $this->templates = $templates;
    }

    public function displayAddUnit(?string $message = null) : void {
        ?><script>
            history.replaceState(null, "", "<?= $_SERVER["REQUEST_URI"] ?>");
        </script><?php
        echo $this->templates->render('add-unit', ["message" => $message, "listOrigins" => (new \Models\OriginDAO())->getAll()]);
    }
    
    public function displayEditUnit(string $idUnit, ?string $message = null) : void {
        ?><script>
            history.replaceState(null, "", "<?= $_SERVER["REQUEST_URI"] ?>");
        </script><?php
        try {
            $unit = (new \Models\UnitDAO())->getByID($idUnit) ?? throw new \Exception("Unit not found");
        } catch (\Exception $e) {
            ?><script>
                history.replaceState(null, "", "<?= strtok($_SERVER["REQUEST_URI"], '?') ?>");
            </script><?php
            (new \Controllers\MainController($this->templates))->index($e);
            return;
        }
        echo $this->templates->render('add-unit', ['id' => $unit->getId(), 'name' => $unit->getName(), 'cost' => $unit->getCost(), 'origins' => $unit->getOrigins(), 'url_img' => $unit->getUrl_img(), 'message' => $message, 'listOrigins' => (new \Models\OriginDAO())->getAll()]);
    }

    public function displayAddOrigin() : void {
        echo $this->templates->render('add-origin');
    }
    
    public function addUnit(array $data) : void {
        $data['origins'] = array_map(fn($origin) => new \Models\Origin($origin), $data['origins']);
        $data['id'] = uniqid();
        $unit = (new \Models\Unit())->hydrate($data);
        try {
            (new \Models\UnitDAO())->createUnit($unit);
        } catch (\PDOException $e) {
            $this->displayAddUnit($e);
            return;
        }
        ?><script>
            history.replaceState(null, "", "<?= strtok($_SERVER["REQUEST_URI"], '?') ?>");
        </script><?php
        (new \Controllers\MainController($this->templates))->index("Unit '". $unit->getName() . "' added");
    }
    
    public function deleteUnitAndIndex(?string $id = null, ?string $message = null) : void {
        if ($id === null && $message === null) {
            $message = new \Exception("No id or error message provided");
        } else if ($id !== null) {
            $unitdao = new \Models\UnitDAO();
            $unit = $unitdao->getByID($id);
            $name = !is_null($unit) ? $unit->getName() : null;
            try {
                if ($unitdao->deleteUnit($id) === 0) {
                    throw new \Exception("Unit not deleted, id not found");
                }
            } catch (\Exception $e) {
                $message = $e;
            }
        }
        ?><script>
            history.replaceState(null, "", "<?= strtok($_SERVER["REQUEST_URI"], '?') ?>");
        </script><?php
        (new \Controllers\MainController($this->templates))->index($message ?? "Unit '" . $name . "' deleted");
    }

    public function editUnitandIndex(array $dataUnit) : void {
        $dataUnit['origins'] = array_map(fn($origin) => new \Models\Origin($origin), $dataUnit['origins']);
        $unit = (new \Models\Unit())->hydrate($dataUnit);
        try {
            if (!(new \Models\UnitDAO())->updateUnit($unit)) {
                throw new \Exception("Unit not updated, id not found");
            }
        } catch (\Exception $e) {
            $this->displayEditUnit($dataUnit['id'], $e);
            return;
        }
        ?><script>
            history.replaceState(null, "", "<?= strtok($_SERVER["REQUEST_URI"], '?') ?>");
        </script><?php
        (new \Controllers\MainController($this->templates))->index($message ?? ("Unit '". $unit->getName() . "' edited"));
    }
}