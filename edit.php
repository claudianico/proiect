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
//apoi trebuie sa fac cumva ca sa scriu numele de rochie etc , tot din php cam ca la adauga,
// sa dau pe imagine si sa apara una singura cu tot cu dat,sa salvez la favorite cu imagine galbena daca le-am salvat
// deja si paginarea adica sa pas pe o pagina un anumit nr de produse si nu mai multe restul sa se restituie
$nume = $produs->nume;
$descriere = $produs->descriere;
$pret = $produs->pret;
$image = $produs->imagine;

if (isset($variables->post->edit)) {
    $nume = $variables->post->nume;
    $descriere = $variables->post->descriere;
    $produs_imagine = $variables->files->imagine;
    $pret = $variables->post->pret;

    /** @var errors $erori */
    $erori = new errors();
    $erori->check_null('nume', $nume, 'Introduceti un nume');
    $erori->check_null('descrire', $descriere, 'Introduceti o descriere');
    $erori->check_null('pret', $pret, 'Introduceti un pret');

    if ($produs_imagine['name'] != '' && !in_array(getExtension($produs_imagine['name']), array('png', 'jpg', 'bmp', 'jpeg', 'gif', 'PNG', 'JPG', 'BMP', 'JPEG', 'GIF'))) {
        $erori->add_error('imangine', 'Nu ati selectat o imagine');
    }

    if ($erori->getStatus()) {
        if ($produs_imagine['name'] != '') {
            $upload = new upload($produs_imagine);

            if ($upload->uploaded) {
                $upload->image_resize = true;
                $upload->image_ratio = true;
                $upload->image_x = 220;
                $upload->image_y = 300;
                $upload->image_ratio_fill = true;
                $upload->image_background_color = '#FFFFFF';
                $upload->process('uploads/');
                if ($upload->processed) {
                    $image = $upload->file_dst_name;
                    $upload->clean();
                } else {
                    $erori->add_error($upload->error, 'Imaginea nu a fost incarcata');
                }

            } else {
                $erori->add_error($upload->error, 'Imaginea nu afost incarcata');
            }
        }

        if ($erori->getStatus()) {
            $produs->nume = $nume;
            $produs->descriere = $descriere;
            $produs->imagine = $image;
            $produs->pret = $pret;
            $produs->modified = date('Y-m-d H:i:s');
            $produs->update();
            relocate('admin-account');
        } else {
            $eroriGasite = $erori->getErrors();
        }

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
            <div class="cont">Adauga aici</div>

            <div class="adresa">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="deja"></div>

                    <div class="name">
                        Nume: <input type="text" name="nume" value="<?php echo $nume; ?>">

                    </div>

                    <div class="name1">
                        Descriere produs: <textarea name="descriere"
                                                    class="textarea"><?php echo $descriere; ?></textarea>
                    </div>
                    <div class="da">
                        <img alt="" src="uploads/<?php echo $image; ?>" height="50" align="right">
                        <div class="name">
                            Imagine: <input class="file" type="file" name="imagine" value="">
                        </div>
                    </div>
                    <div class="name">
                        Pret:<input type="text" name="pret" value="<?php echo $pret; ?>">

                    </div>
                    <div class="log"><input type="submit" name="edit" value="Editeaza">
                    </div>
                    <form>
            </div>
        </div>
    </section>
    <div class="clear"></div>
<?php
require 'includes/footer.php';
require 'includes/end.php';



