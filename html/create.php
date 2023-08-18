<?php

namespace Sean\CHL;
require_once __DIR__.'/../bootstrap.php';
$http = new \Staticflux\HTTP;

// No data sent
if (!isset($_POST['url']) || empty($long = $_POST['url'])) {
    $http
        ->addResponseCode('400')
        ->addRedirect($_SERVER['HTTP_REFERER']);
    return;
}
// Data sent is not a valid URL
elseif (!filter_var($long, FILTER_VALIDATE_URL)) {
    $http
        ->addResponseCode('403')
        ->addRedirect($_SERVER['HTTP_REFERER']);
    return;
}
// Data sent represents an existing object
elseif (($short = $GLOBALS['pdo']->get('SELECT * FROM records WHERE long = ?', [$long])) !== false) {
    $http
        ->addResponseCode('307')
        ->addRedirect(linkInfoPage($short['short']));
    return;
}
// Data sent is valid and a new object should be created
else {
    $GLOBALS['pdo']->do(
        'INSERT INTO records (short, long, timestamp) VALUES (?, ?, ?)',
        [
            $short = generateUniqueShortlink(),
            $long,
            time()
        ]
    );
    $http
        ->addResponseCode('302')
        ->addRedirect(linkInfoPage($short));
    return;
}