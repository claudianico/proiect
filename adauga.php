<?php
require 'resources/init.php';

if (!admin_is_logged()) {
    relocate('admin');
}

if (isset($variables->post->continua)) {
    $nume = $variables->post->nume;
    $descriere = $variables->post->descriere;
    $imagine = $variables->files->imagine;
    $imagin = $variables->files->imagine2;
    $pret = $variables->post->pret;

    /** @var errors $erori */
    $erori = new errors();
    $erori->check_null('nume', $nume, 'introduce un nume ');
    $erori->check_null('descriere', $descriere, 'introdice o descriere');
    $erori->check_null('imagine', $imagine['name'], 'introdice o imagine');
    $erori->check_null('pret', $pret, 'introdice un pret');

    if (!in_array(getExtension($imagine['name']), array('png', 'jpg', 'bmp', 'jpeg', 'gif', 'PNG', 'JPG', 'BMP', 'JPEG', 'GIF'))) {
        $erori->add_error('imagine', 'Nu ati selectat o imagine');

    }
    if (!in_array(getExtension($imagin['name']), array('png', 'jpg', 'bmp', 'jpeg', 'gif', 'PNG', 'JPG', 'BMP', 'JPEG', 'GIF'))) {
        $erori->add_error('imagine', 'Nu ati selectat o imagine');
    }

    if (produse::check_if_exists('nume', $nume)) {
        $erori->add_error('nume', 'numele exista deja');
    }


    if ($erori->getStatus()) {
        $upload = new upload($imagine);

        if ($upload->uploaded) {
            $upload->image_resize = true;
            $upload->image_ratio = true;
            $upload->image_x = 220;
            $upload->image_y = 300;
            $upload->image_ratio_fill = true;
            $upload->image_background_color = '#FFFFFF';
            $upload->process('uploads/');
            if ($upload->processed) {
                $image = $upload->file_dst_name;  //numemle imaginii cu tot cu extensie
                $upload->clean();
            } else {
                $erori->add_error($upload->error, 'Imaginea nu s-a salvat');
            }
        } else {
            $erori->add_error($upload->error, 'Imaginea nu s-a salvat');
        }
        if ($erori->getStatus()) {
            $upload = new upload($imagin);

            if ($upload->uploaded) {
                $upload->image_resize = true;
                $upload->image_ratio = true;
                $upload->image_x = 500;
                $upload->image_y = 600;
                $upload->image_ratio_fill = true;
                $upload->image_background_color = '#FFFFFF';
                $upload->process('uploads/');
                if ($upload->processed) {
                    $image = $upload->file_dst_name;  //numemle imaginii cu tot cu extensie
                    $upload->clean();
                } else {
                    $erori->add_error($upload->error, 'Imaginea nu s-a salvat');
                }
            } else {
                $erori->add_error($upload->error, 'Imaginea nu s-a salvat');
            }
            if ($erori->getStatus()) {
                /** @var produse $produs */
                $produs = new produse();
                $produs->nume = $nume;
                $produs->descriere = $descriere;
                $produs->imagine = $image;
                $produs->imagin = $image;
                $produs->pret = $pret;
                $produs->created = date('Y-m-d H:i:s');
                $produs->modified = date('Y-m-d H:i:s');
                $produs->create();
                relocate('admin_acount');
            } else {
                $eroriGasite = $erori->getErrors();
            }
        } else {
            $eroriGasite = $erori->getErrors(); //variabila???
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
            <div class="cont">Adauga aici</div>

            <div class="adresa">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="deja"></div>


                    <div class="name">
                        Nume: <input type="text" name="nume" value="">

                    </div>

                    <div class="name1">
                        Descriere produs: <textarea name="descriere" class="textarea"></textarea>
                    </div>
                    <div class="da">
                        <div class="name">
                            Imagine: <input class="file" type="file" name="imagine" value="">
                        </div>
                    </div>
                    <div class="da">
                        <div class="name">
                            Imagine: <input class="file" type="file" name="imagin" value="">
                        </div>
                    </div>
                    <div class="name">
                        Pret:<input type="text" name="pret" value="">

                    </div>
                    <div class="log"><input type="submit" name="continua" value="Continua"
                                            onclick="window.location.href='admin-account';">
                    </div>
                    <form>
            </div>
        </div>
    </section>
    <div class="clear"></div>
<?php
require 'includes/footer.php';
require 'includes/end.php';