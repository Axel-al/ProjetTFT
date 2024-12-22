<?php $this->layout('template', ['title' => 'TP TFT - Home', 'message' => $message]) ?>

<h1 class="text-center my-4">TFT - Set <?= $this->e($tftSetName) ?></h1>

<div class="container">
    <h2 class="my-4"><?= isset($defaultSearch) ? "Results" : "Units" ?>:</h2>
    <form action="" method="get" class="search-container mb-4 form-inline">
        <input type="hidden" name="action" value="result-search">
        <div class="input-group">
            <select class="form-select" name="attribute" id="attribute">
                <?php foreach ($attributes as $attribute): ?>*
                    <option value="<?= $attribute->getName() ?>"<?= isset($defaultSearch) && ($defaultSearch['attribute'] == $attribute->getName()) ? " selected" : null ?>><?= ucfirst($attribute->getName()) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="query" id="search" class="form-control" placeholder="Search units..." value="<?= isset($defaultSearch) ? $defaultSearch['query'] : null ?>" required>
            <button type="submit" class="btn btn-outline-secondary" id="search-button">
                <img src="./public/img/search-icon.png" alt="Search" class="button-icon">
            </button>
        </div>
    </form>
    <div id="units-container" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-4 g-4">
        <?php foreach ($listUnits as $unit): ?>
            <div class="col unit-card">
                <div class="card shadow-sm h-100">
                    <img src="<?= $this->e($unit->getUrl_img()) ?>" class="card-img-top" alt="<?= $this->e($unit->getName()) ?>">
                    <div class="card-body">
                        <div class="card-buttons">
                            <a href="<?= '?action=edit-unit&id=' . $unit->getId() ?>"><img src="./public/img/edit-icon.png" alt="Edit" class="button-icon mb-2"></a>
                            <a href="<?= '?action=del-unit&id=' . $unit->getId() ?>"><img src="./public/img/delete-icon.png" alt="Delete" class="button-icon"></a>
                        </div>
                        <h5 class="card-title"><?= $this->e($unit->getName()) ?></h5>
                        <p class="card-text"><strong>Cost:</strong> <?= $this->e($unit->getCost()) ?></p>
                        <p class="card-text origins-container"><strong>Origins:</strong>
                            <span class="origins-items">
                                <?php foreach ($unit->getOrigins() as $index => $origin): ?>
                                    <span class="origin-item">
                                        <img src="<?= $this->e($origin->getUrl_img()) ?>" alt="<?= $this->e($origin->getName()) ?>" class="origin-img<?= strpos($origin->getUrl_img(), "mobafire.com") === false ? " custom-img" : null ?>">
                                        <?= $this->e(ucfirst($origin->getName())) ?>
                                    </span>
                                <?php endforeach; ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>