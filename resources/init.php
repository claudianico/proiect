<?php
ini_set('session.name', 'proiect');
ini_set('session.save_handler', 'files');
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 0);

session_start();
ob_start();
require 'configuration.php';

require 'resources/classes/database.class.php';
require 'resources/classes/table.class.php';
require 'resources/classes/pagination.class.php';
require 'resources/classes/variables.class.php';
require 'resources/classes/mails.class.php';
require 'resources/classes/errors.class.php';
require 'resources/classes/dirs.class.php';
require 'resources/classes/class.upload.php';

require 'resources/classes/configs.class.php';
require 'resources/classes/produse.class.php';
require 'resources/classes/utilizatori.class.php';
require 'resources/classes/admini.class.php';
require 'resources/classes/favorite.class.php';

require 'resources/functions.php';