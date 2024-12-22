<?php $this->layout('template', ['title' => 'TP TFT - ' . (isset($id) ? 'Edit Unit' : 'Add Unit'), 'message' => $message]) ?>
<?php $origins = array_pad($origins ?? [], 3, null) ?>

<h1 class="text-center my-4"><?= isset($id) ? 'Edit Unit' : 'Add Unit' ?></h1>

<form action="" method="post" class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="form-group mb-4">
                <label for="name">Unit Name</label>
                <input type="text" class="form-control" id="name" name="name" maxlength="255" value="<?= $this->e($name ?? null) ?>" required>
            </div>
            <div class="form-group mb-4">
                <label for="cost">Unit Cost</label>
                <input type="number" class="form-control" id="cost" name="cost" min="1" max="5" step="1" value="<?= $this->e($cost ?? null) ?>" required>
            </div>
            <?php foreach ($origins as $index => $origin): ?>
                <div class="form-group mb-4">
                    <label for="origin <?= $index ?>">Unit Origin <?= $index+1 ?></label>
                    <select class="form-select" id="origin <?= $index ?>" name="origin <?= $index ?>" <?= $index == 0 ? "required" : null ?>>
                        <option value="">Select an origin</option>
                        <?php foreach ($listOrigins as $listOrigin): ?>
                            <option value="<?= $listOrigin->getId() ?>" <?= $origin?->getId() == $listOrigin->getId() ? 'selected' : '' ?>>
                                <?= ucfirst($this->e($listOrigin->getName())) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            <?php endforeach ?>
            <div class="form-group mb-4">
                <label for="url_img">Unit Image URL</label>
                <input type="text" class="form-control" id="url_img" name="url_img" maxlength="255" value="<?= $this->e($url_img ?? null) ?>" required>
            </div>
            <?php if (isset($id)): ?>
                <input type="hidden" name="id" value="<?= $this->e($id) ?>">
                <button type="submit" class="btn btn-primary">Edit the Unit</button>
            <?php else: ?>
                <button type="submit" class="btn btn-primary">Add a Unit</button>
            <?php endif ?>
        </div>
    </div>
</form>