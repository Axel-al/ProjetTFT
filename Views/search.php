<?php $this->layout('template', ['title' => 'TP TFT - Search', 'message' => $message]) ?>
<?php $attributes = (new \ReflectionClass(new \Models\Unit))->getProperties(\ReflectionProperty::IS_PRIVATE) ?>

<div style="margin: 15rem"></div>
<h1 class="display-2 text-center my-4">Search</h1>

<div class="container">
    <form action="" method="get" class="search-container mb-4 form-inline">
        <input type="hidden" name="action" value="search">
        <div class="input-group">
            <select class="form-select" name="attribute" id="attribute">
                <?php foreach ($attributes as $attribute): ?>
                    <?php if ($attribute->getName() !== 'id'): ?>
                        <option value="<?= $attribute->getName() ?>"><?= ucfirst($attribute->getName()) ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <input type="text" name="query" id="search" class="form-control" placeholder="Search units..." />
            <button type="submit" class="btn btn-outline-secondary" id="search-button">
                <img src="./public/img/search-icon.png" alt="Search" class="button-icon">
            </button>
        </div>
    </form>
</div>