<?php
require 'resources/init.php';

if (is_logged()) {
    $variables->remove_all();
    relocate('logare');
} else {
    relocate('home');
}

require 'includes/start.php';
?>

    <title>Logout</title>

    <!-- script here -->

<?php require 'includes/header.php'; ?>
<?php require 'includes/menu.php'; ?>

    <section class="content">

    </section>

<?php
require 'includes/footer.php';
require 'includes/end.php';