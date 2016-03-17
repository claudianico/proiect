<?php
require 'resources/init.php';

if (!admin_is_logged()) {
    relocate('admin');
}

$produs_id = $variables->get->id;

/** @var produse $produs */
$produs = produse::get_by_id($produs_id);//il ia pe cel cu  id corespunzator

if (!$produs instanceof produse) {
    relocate('admin-account');
}
$produs->delete();
relocate('admin-account');

require 'includes/start.php';
?>

    <title>Online Shop</title>

    <!-- script here -->

<?php require 'includes/header.php'; ?>
<?php require 'includes/menu.php'; ?>

<?php
require 'includes/footer.php';
require 'includes/end.php';

