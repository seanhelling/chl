<?php

namespace Sean\CHL;
require_once __DIR__.'/../bootstrap.php';

$http = new \Staticflux\HTTP;

// check if we have a shortlink to look up.
// sanitize it if we do.

if (isset($_GET['l'])) {
    $sanitized = filter_var($_GET['l'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
}
else {
    // if we do not, throw a 400 and die.
    $http->addResponseCode(400); return;
}

// perform lookup
$result = $GLOBALS['pdo']->get('SELECT * FROM records WHERE short = ?', [$sanitized]);
// if we find nothing matching, throw a 404 and die.
if (!$result) {
    $http->addResponseCode(404); return;
}
// if we find a match, perform a 307 Temporary Redirect
// this will preserve the request type and body
// and forward to the new location
elseif ($result && isset($result['long']) && filter_var($result['long'], FILTER_VALIDATE_URL)) {
    header('HTTP/1.1 307 Temporary Redirect');
    header('Location: '.$result['long']);
}