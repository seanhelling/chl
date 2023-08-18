<?php

namespace Sean\CHL;
require_once __DIR__.'/../bootstrap.php';

$http = new \Staticflux\HTTP;

// check if we have a shortlink to look up.
// sanitize it if we do.

if (!isset($_GET['s'])) {
    $http
        ->addResponseCode(403)
        ->addRedirect(constant('SITE_URL'));
    return;
}
elseif (($result = $GLOBALS['pdo']->get('SELECT * FROM records WHERE short = ?', [$_GET['s']])) === false) {
    $http
        ->addResponseCode(404)
        ->addRedirect(constant('SITE_URL'));
    return;
}
else {
    $id = $result['id'];
    $long = $result['long'];
    addHit($id);
    $http
        ->addResponseCode(307)
        ->addRedirect($long);
    return;
}