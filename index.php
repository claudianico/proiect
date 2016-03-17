<?php
require 'resources/init.php';

$produse = produse::get_all();

require 'includes/start.php';
?>

    <title>Online Shop</title>

    <!-- script here -->

<?php require 'includes/header.php'; ?>
<?php require 'includes/menu.php'; ?>

    <section class="content">
        <!--content here -->
        <div class="anunt">
            <b>
                <div class="rochii">Rochii</div>
            </b>
            </br>
            </br>
            În rochia "little black dress" vei avea garanţia că te prezinţi minunat. Cusută în stil clasic, această
            rochie
            din colecţia rochiilor de seară, nu va ieşi niciodată din modă. Sau poate doreşti una mai lungă? Dantelele,
            motivele florale şi încreţiturile o fac accesibilă atât pe timp de toamnă sau iarnă.
        </div>
        <?php
        /** @var produse $produs */
        foreach ($produse as $produs) { ?>
            <div class="dress">
                <div class="dress_image">
                    <a href="imagine/<?php echo $produs->id; ?>" class="dress_link"><img alt="rochie"
                                                                                         src="uploads/<?php echo $produs->imagine; ?>"></a>
                </div>
                <div class="dress_info">
                    <div class="dress_title"><?php echo $produs->nume; ?> <br/></div>
                    <div class="dress_title"><?php echo $produs->descriere; ?> <br/></div>
                    <div class="dress_price"><?php echo $produs->pret; ?></div>
                </div>
                <?php if (is_logged()) {
                    $favorit = favorite::verificaFavorit($variables->session->user, $produs->id);
                    if ($favorit) { ?>
                        <div class="dress_favorite">
                            <a href="favorite?id=<?php echo $produs->id; ?>&action=sterge" class="star">
                                <img src="images/stalb.png" title="Sterge din favorite"></a>
                        </div>
                    <?php } else { ?>
                        <div class="dress_favorite">
                            <a href="favorite?id=<?php echo $produs->id; ?>&action=salveaza" class="star">
                                <img src="images/stelu.png" title="Salveaza ca favorite"></a>
                        </div>
                    <?php }
                } else { ?>
                    <div class="dress_favorite">
                        <a href="logare" class="star">
                            <img src="images/stelu.png" title="Salveaza ca favorite"></a>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="clear"></div>
        <ul class="pagination">
            <li><a href="http://localhost/proiect/" class="numar">1</a></li>
            <li><a href="http://localhost/proiect/accesorii" class="numar2">2</a></li>
        </ul>

        <div class="clear"></div>
    </section>

<?php

//echo is_logged() ? 'codul pentru salvare' : 'logare';

//if (is_logged()) {
//  echo 'codul pentru salvare';
//} else {
//    echo 'logare';
//}

require 'includes/footer.php';
require 'includes/end.php';