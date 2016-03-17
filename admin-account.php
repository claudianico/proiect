<?php
require 'resources/init.php';

if (!admin_is_logged()) {
    relocate('admin');
}

$produse = produse::get_all();


require 'includes/start.php';
?>

    <title>Online Shop</title>

    <!-- script here -->

<?php require 'includes/header.php'; ?>
<?php require 'includes/menu.php'; ?>


    <section class="content">
        <!--content here -->
        <div class="lista">
            <?php if ($produse) { ?>
                <div class="products_holder">
                    <div class="product_item_id">#</div>
                    <div class="product_item_nume">Nume</div>
                    <div class="product_item_data">Data</div>
                    <div class="product_item_actiuni">Actiuni</div>
                    <div class="clear"></div>
                </div>
                <?php
                /** @var produse $produs */
                foreach ($produse as $produs) { ?>
                    <div class="products_holder">
                        <div class="product_item_id"><?php echo $produs->id; ?></div>
                        <div class="product_item_nume"><?php echo $produs->nume; ?>&nbsp;</div>
                        <div
                            class="product_item_data"><?php echo date('d-m-Y H:i:s', strtotime($produs->modified)); ?></div>
                        <div class="product_item_actiuni">
                            <a href="edit?id=<?php echo $produs->id; ?>">Edit</a> | <a
                                href="delete?id=<?php echo $produs->id; ?>">Delete</a>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php }
            } else { ?>
                <div>Nu exista produse</div>
            <?php } ?>
        </div>
        <a href="adauga" class="adauga">Adauga produse</a>
    </section>
<?php
require 'includes/footer.php';
require 'includes/end.php';