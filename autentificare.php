<?php
require 'resources/init.php';
if (is_logged()) {
    relocate('favorite');
}

$username = '';

if (isset($variables->post->one)) {
    $username = $variables->post->username;
    $password = $variables->post->password;

    $erori = new errors();
    $erori->checkUsername('username', $username, 'username incorect');
    $erori->check_null('parola', $password, 'Completati parola');

    if ($erori->getStatus()) {
        /** @var utilizatori $utilizator */
        $utilizator = utilizatori::loginUser($username, md5($password));

        if ($utilizator) {
            $variables->add_session('user', $utilizator->id);
            relocate('home');
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
                    <div class="deja"> Am deja un cont in magazin :</div>

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

            <div class="adresa">
                <div class="deschide">Deschide un cont</div>
                <div class="restul">
                    Aici verifici statutul si istoricul comenzilor </br>
                    Poti vedea unde se gasete contul tau </br>
                    Primesti coduri care iti dau dreptul la reduceri
                </div>
                <div class="clear"></div>
                <div class="log"><input type="button" onclick="window.location.href='cont';" value="Deschide un cont"/>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </section>

<?php
require 'includes/footer.php';
require 'includes/end.php';