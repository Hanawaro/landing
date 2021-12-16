<header class="three-columns">
    <button id="burger-btn">
        <div class="burger"></div>
    </button>

    <nav class="left-column">
        <a href="/" id="tour-btn">Tour</a>
        <a href="#" id="features-btn">Features</a>
        <a href="/pricing" id="pricing-btn">Pricing</a>
    </nav>
    <div class="center-column uppercase">
        <span>New</span>providence
    </div>
    <nav class="right-column">
        <a href="#" id="help-btn">Help</a>
        <a href="#" id="contacts-btn">Contacts</a>
        <a href="#" id="get-app-btn">Get app</a>
    </nav>
</header>

<?php

$class = '';
if ($this->isRequired())
    $class = 'redirect disabled';
else if (!$this->isTryLogin() && !$this->isTryRegister() && !$this->isTryResetPassword())
    $class = 'animation disabled';

?>

<div class="pop-up-menu <?= $class ?>">

    <?php if (!$this->isRequired()): ?>

    <div id="login-form"
         class="<?= $this->isTryLogin() || !($this->isTryRegister() || $this->isTryResetPassword()) ? 'active' : '' ?>">
        <form action="/user/login/profile" method="post">
            <div><h2>Login</h2></div>
            <label>
                <input type="text" name="<?= LOGIN_TAG ?>" placeholder="login" value="<?= $this->getLogin(LOGIN_TAG) ?>"
                       maxlength="256"  required>
            </label>
            <label>
                <input type="password" name="<?= PASSWORD_TAG ?>" placeholder="password" required>
            </label>
            <div class="error"><?= $this->getLogin(ERROR_TAG) ?></div>
            <div class="link"><span id="to-reset-password-btn">Forget your password?</span></div>
            <input type="submit" name="<?= LOGIN_SUBMIT_TAG ?>" value="login">
            <div class="link">Have you not an account? <span id="to-register-btn">Sign up</span></div>
        </form>
    </div>

    <div id="reset-password-form" class="<?= $this->isTryResetPassword() ? 'active' : '' ?>">
        <form action="/user/send-email" method="post">
            <div><h2>Forget password?</h2></div>
            <label>
                <input type="text" name="<?= LOGIN_TAG ?>" placeholder="login" maxlength="256" required>
            </label>
            <div class="info">
                <div class="success"><?= $this->getResetPassword(SUCCESS_TAG) ?></div>
                <div class="error"><?= $this->getResetPassword(ERROR_TAG) ?></div>
            </div>
            <input type="submit" name="<?= RESET_PASSWORD_SUBMIT_TAG ?>" value="Send message">
        </form>
    </div>

    <div id="register-form" class="<?= $this->isTryRegister() ? 'active' : '' ?>">
        <form action="/user/register" method="post" enctype="multipart/form-data">
            <div><h2>Registration</h2></div>
            <div>
                <div class="column">
                    <div>
                        <label><input type="text" name="<?= LOGIN_TAG ?>" placeholder="login"
                                      value="<?= $this->getRegister(LOGIN_TAG) ?>" maxlength="256" required></label>
                        <label><input type="email" name="<?= EMAIL_TAG ?>" placeholder="email"
                                      value="<?= $this->getRegister(EMAIL_TAG) ?>" maxlength="512" required></label>
                    </div>
                    <div>
                        <label><input type="password" name="<?= PASSWORD_TAG ?>" placeholder="password" maxlength="256"
                                      required></label>
                        <label><input type="password" name="<?= RE_PASSWORD_TAG ?>" placeholder="repeat password"
                                      maxlength="256" required></label>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <label><input type="text" name="<?= FIRST_NAME_TAG ?>" placeholder="first name"
                                      value="<?= $this->getRegister(FIRST_NAME_TAG) ?>" maxlength="256"
                                      required></label>
                        <label><input type="text" name="<?= SECOND_NAME_TAG ?>" placeholder="second name"
                                      value="<?= $this->getRegister(SECOND_NAME_TAG) ?>" maxlength="256"
                                      required></label>
                        <label><input type="text" name="<?= LAST_NAME_TAG ?>" placeholder="last name"
                                      value="<?= $this->getRegister(LAST_NAME_TAG) ?>" maxlength="256"></label>
                    </div>
                    <div>
                        <input id="choose-photo" type="file" name="<?= PHOTO_TAG ?>" accept="image/*">
                        <label class="choose-photo-lbl" for="choose-photo">Choose a photo</label>
                    </div>
                </div>
            </div>
            <div class="info">
                <div class="success"><?= $this->getRegister(SUCCESS_TAG) ?></div>
                <div class="error"><?= $this->getRegister(ERROR_TAG) ?></div>
            </div>
            <div>
                <input type="submit" name="<?= REGISTER_SUBMIT_TAG ?>" value="register">
            </div>
            <div class="link">Have you an account? <span id="to-login-btn">Login</span></div>
        </form>

        <?php endif; ?>
    </div>

</div>