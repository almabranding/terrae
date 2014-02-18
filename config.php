<?php

// Always provide a TRAILING SLASH (/) AFTER A PATH
define('LIBS', 'libs/');
define('TEMPDIR', '/');
define('URL', 'http://' . $_SERVER['HTTP_HOST'] . TEMPDIR);
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . TEMPDIR);
define('CACHE', ROOT . 'cache/');
define('UPLOAD', URL . 'uploads/');

define('DB_TYPE', 'mysql');
define('DB_HOST', '');
define('DB_NAME', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_PREFIX', 'book_');

define('TABLE_ROOMS', DB_PREFIX.'rooms');
define('TABLE_HOTELS', DB_PREFIX.'hotels');
define('TABLE_HOTELS_DESCRIPTION', DB_PREFIX.'hotels_description');
define('TABLE_ROOMS_DESCRIPTION', DB_PREFIX.'rooms_description');
define('HOTEL_IMAGE', URL.'intranet/PHPHotel/images/hotels/');
define('HOTEL_GALLERY', URL.'intranet/PHPHotel/images/rooms_icons/');
define('PASSWORDS_ENCRYPT_KEY', 'apphp_hotel_site');
define('EXPERIENCE', 'experience');
define('ACCOMMODATION', 'accommodation');

// The sitewide hashkey, do not change this because its used for passwords!
// This is for other hash keys... Not sure yet
define('HASH_GENERAL_KEY', '');

// This is for database passwords only
define('HASH_PASSWORD_KEY', '');
define('NUMPP', 35);

