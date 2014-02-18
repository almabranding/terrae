<?php

//error_reporting(0);
require 'config.php';
require 'util/Strip.php';
require 'util/Util.php';
require 'libs/html2pdf/html2pdf.class.php';

ini_set('include_path', 'util/PEAR');
// Also spl_autoload_register (Take a look at it if you like)
function __autoload($class) {
    if (file_exists(LIBS . $class . ".php"))
        require LIBS . $class . ".php";
    else if (file_exists(ROOT . 'intranet/PHPHotel/include/classes/' . $class . '.class.php'))
        require_once(ROOT . 'intranet/PHPHotel/include/classes/' . $class . '.class.php');

    if ($class == 'PHPMailer') {
        require_once(ROOT . 'intranet/PHPHotel/modules/phpmailer/class.phpmailer.php');
    } else if ($class == 'tFPDF') {
        require_once(ROOT . 'intranet/PHPHotel/modules/tfpdf/tfpdf.php');
    } else {
        
    }
}

// Load the Bootstrap!
$bootstrap = new Bootstrap();

// Optional Path Settings
//$bootstrap->setControllerPath();
//$bootstrap->setModelPath();
//$bootstrap->setDefaultFile();
//$bootstrap->setErrorFile();

$bootstrap->init();
//$bootstrap->end();
