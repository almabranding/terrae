<?php
################################################################################
##              -= YOU MAY NOT REMOVE OR CHANGE THIS NOTICE =-                 #
## --------------------------------------------------------------------------- #
##  ApPHP Hotel Site Pro version 4.0.3                                         #
##  Developed by:  ApPHP <info@apphp.com>                                      #
##  License:       GNU LGPL v.3                                                #
##  Site:          http://www.apphp.com/php-hotel-site/                        #
##  Copyright:     ApPHP Hotel Site (c) 2010-2012. All rights reserved.        #
##                                                                             #
##  Additional modules (embedded):                                             #
##  -- ApPHP EasyInstaller v2.0.5 (installation module)       http://apphp.com #
##  -- ApPHP Tabs v2.0.3 (tabs menu control)        		  http://apphp.com #
##  -- openWYSIWYG v1.4.7 (WYSIWYG editor)              http://openWebWare.com #
##  -- TinyMCE (WYSIWYG editor)                   http://tinymce.moxiecode.com #
##  -- Crystal Project Icons (icons set)               http://www.everaldo.com #
##  -- Securimage v2.0 BETA (captcha script)         http://www.phpcaptcha.org #
##  -- jQuery 1.4.2 (New Wave Javascript)             		 http://jquery.com #
##  -- Google AJAX Libraries API                  http://code.google.com/apis/ #
##  -- Lytebox v3.22                                       http://lytebox.com/ #
##  -- JsCalendar v1.0 (DHTML/JavaScript Calendar)      http://www.dynarch.com #
##  -- RokBox System 			  				   http://www.rockettheme.com/ #
##  -- VideoBox	  						   http://videobox-lb.sourceforge.net/ #
##  -- CrossSlide jQuery plugin v0.6.2 	                     by Tobia Conforto #
##  -- PHPMailer v5.2 https://code.google.com/a/apache-extras.org/p/phpmailer/ #
##  -- tFPDF v1.24 (PDF files generator (FPDF http://fpdf.org))    by Ian Back #
##                                                                             #
################################################################################

// *** check if database connection parameters file existsech

## uncomment, if your want to prevent 'Web Page exired' message when use $submission_method = 'post';
// session_cache_limiter('private, must-revalidate');    

// *** set flag that this is a parent file
define('APPHP_EXEC', 'access allowed');
require_once(dirname(__FILE__).'/../config.php');
require_once(dirname(__FILE__).'/include/base.inc.php');
require_once(dirname(__FILE__).'/include/connection_terrae.php');

?>