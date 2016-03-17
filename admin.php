<?php
require 'resources/init.php';

if (admin_is_logged()) {
    relocate('admin-account');
}

$username = '';

if (isset($variables->post->one)) {
    $username = $variables->post->username;
    $password = $variables->post->password;

    $erori = new errors();
    $erori->checkUsername('username', $username, 'username incorect');
    $erori->check_null('parola', $password, 'Completati parola');

    if ($erori->getStatus()) {

        $admin = new admini();

        /** @var admini $admin */
        $admin = admini::loginUser($username, md5($password));

        if ($admin) {
            $variables->add_session('admin', $admin->id);
            relocate('admin-account');
        } else {
            $erori->add_error('username', 'Username sau parola gresita');
            $eroriGasite = $erori->getErrors();
        }
    } else {
        $eroriGasite = $erori->getErrors();
    }
}

require 'includes/start.php';
?>

    <title>Online Shop</title>

    <!-- script here -->

<?php require 'includes/header.php'; ?>
<?php require 'includes/menu.php'; ?>

    <section class="content">
        <div class="tot">
            <div class="cont">Contul tau:</div>

            <div class="adresa">
                <form action="" method="POST">
                    <div class="deja"> Contul meu:</div>

                    <div class="name">
                        Username: <input type="text" name="username" value="<?php echo $username; ?>">
                        <?php if (isset($eroriGasite['username'])) { ?>
                            <br/>
                            <span class="error"><?php echo $eroriGasite['username']; ?></span>
                        <?php } ?>
                    </div>
                    <div class="name">
                        Parola:<input type="password" name="password" value="">
                        <?php if (isset($eroriGasite['parola'])) { ?>
                            <br/>
                            <span class="error"><?php echo $eroriGasite['parola']; ?></span>
                        <?php } ?>
                    </div>
                    <div class="log"><input type="submit" name="one" value="Logheaza"></div>
                </form>
            </div>
            <div class="clear"></div>
        </div>
    </section>
<?php
require 'includes/footer.php';
require 'includes/end.php';