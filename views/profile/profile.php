<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Landing</title>

    <link rel="stylesheet" href="/assets/styles/style.css">
    <link rel="stylesheet" href="/assets/styles/header.css">

    <link rel="stylesheet" href="/assets/styles/profile/style.css">
</head>
<body>

<section class="header">
    <?php include_once ROOT . '/views/header.php' ?>
</section>

<main>
    <div class="profile invisible">
        <div class="action">
            <div id="close">Close the window</div>
            <a href="/profile/update" id="edit">Edit</a>
            <form action="/user/logout" method="post">
                <input type="submit" name="logout" value="logout">
            </form>
        </div>
        <div class="info">
            <img src="/assets/img/users/<?= ProfileRepository::get(PHOTO_TAG) ?>?nocache=<?= time() ?>" alt="photo">
            <div>
                <div id="login"><?= ProfileRepository::get(LOGIN_TAG) ?></div>
                <div id="full-name"><?= ProfileRepository::get(SECOND_NAME_TAG) . ' ' . ProfileRepository::get(FIRST_NAME_TAG) . ' ' . ProfileRepository::get(LAST_NAME_TAG) ?></div>
                <div id="email"><?= ProfileRepository::get(EMAIL_TAG) ?></div>
            </div>
        </div>
    </div>
</main>

<script src="/assets/vendor/jquery/jquery.js"></script>
<script src="/assets/scripts/burger.js"></script>
<script src="/assets/scripts/pop-up-menu.js"></script>
<script src="/assets/scripts/profile-bar.js"></script>

</body>
</html>