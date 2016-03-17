<?php
require 'resources/init.php';

if (!is_logged()) {
    relocate('logare');
}

$produs_id = $variables->get->id;
$action = $variables->get->action;

if ($action == 'salveaza') {
    $favorit = new favorite();

    $favorit->product_id = $produs_id;
    $favorit->user_id = $variables->session->user;
    $favorit->created = date('Y-m-d H:i:s');
    $favorit->modified = date('Y-m-d H:i:s');
    $favorit->create();
    relocate('home');
} elseif ($action == 'sterge') {
    $favoritTemp = favorite::verificaFavorit($variables->session->user, $produs_id);

    /** @var favorite $favorit */
    $favorit = favorite::get_by_id($favoritTemp->id);

    $favorit->delete();
    relocate('home');
}
relocate('home');

require 'includes/start.php';
?>

    <title>Online Shop</title>

    <!-- script here -->

<?php require 'includes/header.php'; ?>
<?php require 'includes/menu.php'; ?>

    <section class="content">

    </section>
<?php


require 'includes/footer.php';
require 'includes/end.php';
