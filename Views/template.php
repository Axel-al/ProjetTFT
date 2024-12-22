<?php $home = strtok($_SERVER["REQUEST_URI"], '?') ?>
<?php $addUnit = '?action=add-unit' ?>
<?php $addUnitOrigin = '?action=add-origin' ?>
<?php $search = '?action=search' ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/css/main.css">
    <link rel="icon" href="./public/img/favicon.ico" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->e($title) ?></title>
</head>

<body>
<?= $this->insert('message', ['message' => $message ?? null]) ?>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $home ?>">TFT Manager</a>
            <button id="menuToggle" class="navbar-toggler" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $home ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $addUnit ?>">Add a unit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $addUnitOrigin ?>">Add a unit's origin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $search ?>">Search</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="mobile-menu">
        <div id="mobileNav" class="mobile-nav bg-dark">
            <button id="closeMenu" class="btn btn-danger">Fermer</button>
            <ul class="list-unstyled">
                <li><a href="<?= $home ?>">Home</a></li>
                <li><a href="<?= $addUnit ?>">Add a unit</a></li>
                <li><a href="<?= $addUnitOrigin ?>">Add a unit's origin</a></li>
                <li><a href="<?= $search ?>">Search</a></li>
            </ul>
        </div>
    </div>
</header>
<main id="contenu">
<?=$this->section('content')?>
</main>
<footer>

</footer>
<script>
    const menuToggle = document.getElementById('menuToggle');
    const mobileNav = document.getElementById('mobileNav');
    const closeMenu = document.getElementById('closeMenu');
    const burger = menuToggle.querySelector('.navbar-toggler-icon');

    menuToggle.addEventListener('click', () => {
        if (mobileNav.classList.contains("show")) {
            mobileNav.classList.remove('show')
            burger.classList.remove('active')
        } else {
            mobileNav.classList.add('show');
            burger.classList.add('active');
        }
    });

    closeMenu.addEventListener('click', () => {
        mobileNav.classList.remove('show');
        burger.classList.remove('active');
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>