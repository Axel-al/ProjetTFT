<?php $this->layout('template', ['title' => "TP TFT - Add Unit's Origin", 'message' => $message]) ?>

<h1 class="text-center my-4">Add Unit's Origin</h1>

<form action="" method="post" class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="form-group mb-4">
                <label for="name">Origin Name</label>
                <input type="text" class="form-control" id="name" name="name" maxlength="255" required>
            </div>
            <div class="form-group mb-4">
                <label for="url_img">Origin Image URL</label>
                <input type="text" class="form-control" id="url_img" name="url_img" maxlength="255" required>
            </div>
            <button type="submit" class="btn btn-primary">Add a Unit's Origin</button>
        </div>
    </div>
</form>