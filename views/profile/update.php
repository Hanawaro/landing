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
    <div class="update-profile">
        <h2><?= $this->get(LOGIN_TAG) ?> profile</h2>
        <div class="container">
            <img id="photo" src="/assets/img/users/<?= $this->get(PHOTO_TAG) ?>?nocache=<?= time() ?>" alt="photo">
            <div class="actions">
                <form action="/user/update" method="post">
                    <div>
                        <label><input type="email" name="<?= EMAIL_TAG ?>" value="<?= $this->get(EMAIL_TAG) ?>"
                                      placeholder="email"></label>
                    </div>
                    <input type="submit" name="<?= UPDATE_SUBMIT_TAG ?>" value="save">
                </form>
                <form action="/user/update" method="post">
                    <div>
                        <label><input type="text" name="<?= FIRST_NAME_TAG ?>" value="<?= $this->get(FIRST_NAME_TAG) ?>"
                                      placeholder="first name"></label>
                        <label><input type="text" name="<?= SECOND_NAME_TAG ?>"
                                      value="<?= $this->get(SECOND_NAME_TAG) ?>" placeholder="second name"></label>
                        <label><input type="text" name="<?= LAST_NAME_TAG ?>" value="<?= $this->get(LAST_NAME_TAG) ?>"
                                      placeholder="last name"> </label>
                    </div>
                    <input type="submit" name="<?= UPDATE_SUBMIT_TAG ?>" value="save">
                </form>
                <form action="/user/update" method="post">
                    <div>
                        <label><input type="password" name="<?= OLD_PASSWORD_TAG ?>" placeholder="old password"></label>
                        <label><input type="password" name="<?= PASSWORD_TAG ?>" placeholder="new password"></label>
                        <label><input type="password" name="<?= RE_PASSWORD_TAG ?>"
                                      placeholder="repeat new password"></label>
                    </div>
                    <input type="submit" name="<?= UPDATE_SUBMIT_TAG ?>" value="save">
                </form>
                <form action="/user/update" method="post" enctype="multipart/form-data">
                    <div>
                        <input id="choose-photo" type="file" name="<?= PHOTO_TAG ?>" accept="image/*">
                        <label class="choose-photo-lbl" for="choose-photo">Choose a photo</label>
                    </div>
                    <input type="submit" name="<?= UPDATE_SUBMIT_TAG ?>" value="save">
                </form>
            </div>
        </div>
        <div class="info">
            <div class="success"><?= $this->get(SUCCESS_TAG) ?></div>
            <div class="error"><?= $this->get(ERROR_TAG) ?></div>
        </div>
    </div>
</main>

<script src="/assets/vendor/jquery/jquery.js"></script>
<script src="/assets/scripts/burger.js"></script>
<script src="/assets/scripts/pop-up-menu.js"></script>
<script>
    $('#choose-photo').change(function (event) {
        let file = URL.createObjectURL(event.target.files[0]);
        $('#photo').attr('src', file);
    });
</script>

</body>
</html>