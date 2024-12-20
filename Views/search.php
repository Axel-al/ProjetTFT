<?php $this->layout('template', ['title' => 'TP TFT']) ?>

<div style="margin: 15rem"></div>
<h1 class="display-2 text-center my-4">Search</h1>

<div class="container">
    <form class="search-container mb-4">
        <input type="hidden" name="action" value="search">
        <div action="" method="get" class="input-group">
            <input type="text" name="query" id="search" class="form-control" placeholder="Search units..." />
            <button type="submit" class="btn btn-outline-secondary" type="button" id="search-button">
                <img src="./public/img/search-icon.png" alt="Search" class="button-icon">
            </button>
        </div>
    </form>
</div>