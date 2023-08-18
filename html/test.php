<?php
namespace Sean\CHL;
require_once __DIR__.'/../bootstrap.php';

(new \Staticflux\HTTP)->addRedirect(constant('SITE_URL'));

// echo '<pre>' . var_export(
//     str_split(constant('VALID_CHAR_SPACE'))
// , true) . '</pre>';
// var_export($GLOBALS['pdo']->get('SELECT * FROM records WHERE short = ?', ['nothing']));

// echo implode('', VALID_CHAR_SPACE);