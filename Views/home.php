<?php $this->layout('template', [
    'title' => 'TP TFT',
    'home' => strtok($_SERVER["REQUEST_URI"], '?'),
    'addUnit' => '?action=add-unit',
    'addUnitOrigin' => '?action=add-unit-origin',
    'search' => '?action=search'
]) ?>

<h1 class="text-center my-4">TFT - Set <?= $this->e($tftSetName) ?></h1>

<div class="container">
    <h2 class="my-4">Units:</h2>
    <div class="search-container text-center mb-4">
        <input type="text" id="search" class="form-control" placeholder="Search units..." />
    </div>
    <div id="units-container" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-4 g-4">
        <?php foreach ($listUnits as $unit): ?>
            <div class="col unit-card">
                <div class="card shadow-sm">
                    <img src="<?= $unit->getUrl_img() ?>" class="card-img-top" alt="<?= $unit->getName() ?>">
                    <div class="card-body">
                        <div class="card-buttons">
                            <a href="<?= $editUnit . $unit->getId() ?>"><img src="./public/img/edit-icon.png" alt="Edit" class="button-icon mb-2"></a>
                            <a href="<?= $delUnit . $unit->getId() ?>"><img src="./public/img/delete-icon.png" alt="Delete" class="button-icon"></a>
                        </div>
                        <h5 class="card-title"><?= $unit->getName() ?></h5>
                        <p class="card-text"><strong>Cost:</strong> <?= $unit->getCost() ?></p>
                        <p class="card-text"><strong>Origin:</strong><img src="https://www.mobafire.com/images/tft/set13/origin/icon/<?= $unit->getOrigin() ?>.png" alt="<?= $unit->getOrigin() ?>" class="origin-img"> <?= ucfirst($unit->getOrigin()) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
<script src="./public/js/searchFilter.js"></script>