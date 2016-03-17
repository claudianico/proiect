<?php
require 'resources/init.php';

if (is_logged()) {
    relocate('home');
}

$name = '';
$email = '';
$username = '';
$birthday = '';

if (isset($variables->post->one)) {
    $nume = $variables->post->nume;   //$_POST['name']
    $email = $variables->post->email;
    $username = $variables->post->username;
    $password = $variables->post->password;
    $birthday = $variables->post->birthday;

    /** @var errors $erori */
    $erori = new errors();
    $erori->check_email('email', $email, 'email-ul e gresit');
    $erori->checkUsername('username', $username, 'username trebuie sa fie alfanumeric plus undeline');
    $erori->check_null('nume', $nume, 'completati numele');
    $erori->check_null('parola', $password, 'Completati parola');
    $erori->checkBirthday('birthday', $birthday, 'yyyy-mm-dd, minim 10 ani');
    if (utilizatori::check_if_exists('username', $username)) {
        $erori->add_error('username', 'username exista deja');
    }
    if (utilizatori::check_if_exists('email', $email)) {
        $erori->add_error('email', 'email-ul exista deja');
    }

    if ($erori->getStatus()) {
        $utilizator = new utilizatori();

        $utilizator->email = $email;
        $utilizator->nume = $nume;
        $utilizator->parola = md5($password);
        $utilizator->username = $username;
        $utilizator->birthday = $birthday;
        $utilizator->created = date('Y-m-d H:i:s');
        $utilizator->modified = date('Y-m-d H:i:s');

        $utilizator->create();

        $variables->add_session('user', $utilizator->id);
        relocate('home');
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
                    <div class="deja"> Vreau sa-mi deschid un cont in magazin :</div>

                    <div class="name">
                        Adresa ta de e-mail: <input type="text" name="email" value="<?php echo $email; ?>">
                        <?php if (isset($eroriGasite['email'])) { ?>
                            <br/>
                            <span class="error"><?php echo $eroriGasite['email']; ?></span>
                        <?php } ?>
                    </div>
                    <div class="name">
                        Nume: <input type="text" name="nume" value="<?php echo $nume; ?>">
                        <?php if (isset($eroriGasite['nume'])) { ?>
                            <br/>
                            <span class="error"><?php echo $eroriGasite['nume']; ?></span>
                        <?php } ?>
                    </div>
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
                    <div class="name">
                        Ziua de nastere:<input type="text" name="birthday" value="<?php echo $birthday; ?>">
                        <?php if (isset($eroriGasite['birthday'])) { ?>
                            <br/>
                            <span class="error"><?php echo $eroriGasite['birthday']; ?></span>
                        <?php } ?>
                    </div>
                    <div class="log"><input type="submit" name="one" value="Continua"
                                            onclick="window.location.href='logare';"></div>
                </form>
            </div>

            <div class="adresa">
                <div class="deschide">Intra in cont</div>
                <div class="restul">
                    Aici verifici statutul si istoricul comenzilor </br>
                    Poti vedea unde se gasete contul tau </br>
                    Primesti coduri care iti dau dreptul la reduceri
                </div>
                <div class="clear"></div>
                <div class="log"><input type="button" onclick="window.location.href='logare';" value="Logheaza"/></div>
            </div>
            <div class="clear"></div>
        </div>
    </section>
