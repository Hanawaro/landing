<?php
if (!isset($carts))
    $carts = array();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Landing</title>

    <link rel="stylesheet" href="/assets/styles/style.css">
    <link rel="stylesheet" href="/assets/styles/header.css">

    <link rel="stylesheet" href="/assets/styles/pricing/style.css">
    <link rel="stylesheet" href="/assets/styles/pricing/mobile.css" media="(max-width: 1000px)">
</head>
<body>

<section class="header">
    <?php include_once ROOT . '/views/header.php' ?>
</section>

<main>
    <div class="filter">
        <div>
            <h2>Price</h2>
            <div class="variables">
                <label><input id="free-checkbox" type="checkbox" name="money" value="0" data-strict="false">Free</label>
                <label>
                    <input id="price-range" type="range" name="money" min="1" max="999" value="999">
                    <span class="indicator">999$</span>
                </label>
            </div>
        </div>
        <div>
            <h2>Period</h2>
            <div class="variables">
                <label><input type="checkbox" name="period" value="month" data-strict="true">Month</label>
                <label><input type="checkbox" name="period" value="year" data-strict="true">Year</label>
                <label><input type="checkbox" name="period" value="unlimited" data-strict="true">Unlimited</label>
            </div>
        </div>
        <div>
            <h2>Keys</h2>
            <div class="variables">
                <label><input type="checkbox" name="keys" value="1" data-strict="true">One</label>
                <label><input type="checkbox" name="keys" value="5" data-strict="true">Five</label>
                <label><input type="checkbox" name="keys" value="9" data-strict="true">Nine</label>
            </div>
        </div>
        <div>
            <h2>Our notices</h2>
            <div class="variables">
                <label><input type="checkbox" name="recommended" value="1" data-strict="false">Recommended</label>
            </div>
        </div>
    </div>
    <div class="carts">
        <?php foreach ($carts as $cart): ?>
            <div class="cart"
                 data-money="<?= $cart['price'] ?>"
                 data-period="<?= $cart['period'] ?>"
                 data-keys="<?= $cart['count'] ?>"
                 data-recommended="<?= $cart['recommended'] ?>">

                <h3><?= $cart['name'] ?></h3>
                <div class="info">
                    <p class="price"><span><?= $cart['price'] == 0 ? 'Free' : $cart['price'] . '$' ?></span>
                        on <?= $cart['period'] ?></p>
                    <p class="keys"><?= $cart['count'] ?> key(s) access</p>
                    <p class="recommended<?= $cart['recommended'] == 0 ? ' disabled' : '' ?>">Recommended</p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<script src="/assets/vendor/jquery/jquery.js"></script>
<script src="/assets/scripts/burger.js"></script>
<script src="/assets/scripts/filter.js"></script>
<script src="/assets/scripts/pop-up-menu.js"></script>

</body>
</html>