<?php
require 'resources/init.php';

if (!is_logged()) {
    relocate('logare');
}

$userId = $variables->session->user;

$favorite = favorite::getFavorites($userId);

require 'includes/start.php';
?>

    <title>Online Shop</title>

    <!-- script here -->

<?php require 'includes/header.php'; ?>
<?php require 'includes/menu.php'; ?>

    <section class="content">
        <?php if ($favorite) {
            /** @var favorite $favorit */
            foreach ($favorite as $favorit) {
                /** @var produse $produs */
               $produs = produse::get_by_id($favorit->product_id); ?>
                <div class="">
                    favorit #1 <?php echo $produs->nume; ?>
                </div>
            <?php }
        } else { ?>
            nici un favorit
        <?php } ?>
    </section>
<?php


require 'includes/footer.php';
require 'includes/end.php';
