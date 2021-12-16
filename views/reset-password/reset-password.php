<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Landing</title>

    <link rel="stylesheet" href="/assets/styles/style.css">
    <link rel="stylesheet" href="/assets/styles/header.css">

    <link rel="stylesheet" href="/assets/styles/reset-password/style.css">
    <link rel="stylesheet" href="/assets/styles/reset-password/desktop.css" media="(min-width: 1100px)">
</head>
<body>

<form action="/user/reset-password" method="post">
    <div><h2>Reset password</h2></div>

    <label>
        <input type="password" name="<?= PASSWORD_TAG ?>" placeholder="password" required>
    </label>
    <label>
        <input type="password" name="<?= RE_PASSWORD_TAG ?>" placeholder="repeat password" required>
    </label>

    <input type="hidden" name="<?= LOGIN_TAG ?>" value="<?= $login ?>">
    <input type="hidden" name="<?= RESET_VALUE_TAG ?>" value="<?= $token ?>">

    <div class="info">
        <div class="success"><?= $this->getResetPassword(SUCCESS_TAG) ?></div>
        <div class="error"><?= $this->getResetPassword(ERROR_TAG) ?></div>
    </div>
    <input type="submit" name="<?= RESET_PASSWORD_SUBMIT_TAG ?>" value="Save">
</form>

</body>
</html>