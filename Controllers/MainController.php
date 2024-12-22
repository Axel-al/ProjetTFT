<?php
namespace Controllers;

class MainController {
    private \League\Plates\Engine $templates;

    public function __construct(\League\Plates\Engine $templates) {
        $this->templates = $templates;
    }

    public function index(?string $message = null) : void {
        $listUnits = (new \Models\UnitDAO())->getAll();
        echo $this->templates->render('home', [
            'tftSetName' => 'Into the Arcane',
            'listUnits' => $listUnits,
            'attributes' => (new \ReflectionClass(new \Models\Unit))->getProperties(\ReflectionProperty::IS_PRIVATE),
            'message' => $message
        ]);
    }

    public function search(?string $message = null) : void {
        ?><script>
            history.replaceState(null, "", "<?= strtok($_SERVER["REQUEST_URI"], '?') . "?action=search" ?>");
        </script><?php
        echo $this->templates->render('search', [
            'attributes' => (new \ReflectionClass(new \Models\Unit))->getProperties(\ReflectionProperty::IS_PRIVATE),
            'message' => $message
        ]);
    }

    public function resultSearch(array $data) : void {
        try {
            $listUnits = (new \Models\UnitDAO())->search($data['query'], $data['attribute']);
        } catch (\Exception $e) {
            $this->search($e);
            return;
        }
        echo $this->templates->render('home', [
            'tftSetName' => 'Into the Arcane',
            'listUnits' => $listUnits,
            'attributes' => (new \ReflectionClass(new \Models\Unit))->getProperties(\ReflectionProperty::IS_PRIVATE),
            'message' => null,
            'defaultSearch' => $data
        ]);
    }
}