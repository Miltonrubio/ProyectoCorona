
<?php

$servidor=gethostname();
if( $servidor == "linux-gaxp"){
    if (!defined('SERVIDOR')) define('SERVIDOR', '169.254.16.187');
    if (!defined('DATABASE')) define('DATABASE', 'notas');
    if (!defined('USERNAME')) define('USERNAME', 'root');
    if (!defined('PASSWORD')) define('PASSWORD', 'admin');
    if (!defined('URL')) define('URL', 'http://192.168.1.204/tallergeorgio/imagenes/');
        if (!defined('URLAPI')) define('URLAPI', 'http://169.254.16.246/apinotasmayoreo/Panel.php');
    if (!defined('DSN')) define('DSN', 'mysql:host='.SERVIDOR.';dbname='.DATABASE.';charset=utf8mb4');
}else{
    if (!defined('SERVIDOR')) define('SERVIDOR', 'localhost');
    if (!defined('DATABASE')) define('DATABASE', 'coronahidalgo');
    if (!defined('USERNAME')) define('USERNAME', 'root');
    if (!defined('PASSWORD')) define('PASSWORD', '');
    if (!defined('URL')) define('URL', 'http://tallergeorgio.hopto.org:5613/tallergeorgio/imagenes/');
    if (!defined('URLAPI')) define('URLAPI', 'http://hidalgo.no-ip.info:5628/apinotasmayoreo/Panel.php');
    if (!defined('DSN')) define('DSN', 'mysql:host='.SERVIDOR.';dbname='.DATABASE.';charset=utf8mb4');
}

?>
