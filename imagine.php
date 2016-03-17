<?php
require 'resources/init.php';
$produs_id = $variables->get->id;

/** @var produse $produs */
$produs = produse::get_by_id($produs_id);

require 'includes/start.php';
?>

    <title>Online Shop</title>

    <!-- script here -->

<?php require 'includes/header.php'; ?>
<?php require 'includes/menu.php'; ?>

    <section class="content">
    <!--content here -->

        <div class="dress">
            <div class="dress_image">
                <a href="#" class="dress_link1"><img alt="rochie" src="uploads/<?php echo $produs->imagine; ?>"></a>
            </div>
            <div class="dress_info">
                <div class="dress_title"><?php echo $produs->nume; ?> <br/></div>
                <div class="dress_title"><?php echo $produs->descriere; ?> <br/></div>
                <div class="dress_price"><?php echo $produs->pret; ?></div>
            </div>
            <div class="dress_favorite">
                <a href="http://localhost/proiect/logare" class="star"><img src="images/stelu.png" title="Salveaza ca favorite"></a>
            </div>
        </div>
        <div class="clear"></div>
     </section>
<?php


require 'includes/footer.php';
require 'includes/end.php';
