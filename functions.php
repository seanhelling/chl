<?php

/* 
    generate a shortlink meeting the parameters defined in config
 */

function generateRandomShortlink() {
    $str = '';
    foreach(range(1, SHORTLINK_CHAR_LENGTH) as $i) {
        $str .= VALID_CHAR_SPACE[array_rand(VALID_CHAR_SPACE)];
    }
    return $str;
}

/* 
    call generateRandomShortlink() and verify that the
    shortlink does not already exist in the database
    if it does, continue until we have a unique value
 */

function generateUniqueShortlink() {
    do {
        $candidate = generateRandomShortlink();
    } while (
        $GLOBALS['pdo']->get('SELECT * FROM records WHERE short = ?', [$candidate]) !== false
    );
    return $candidate;
}

/*
    convert a bare shortlink into a link to its info page
 */
function linkInfoPage($short) {
    return constant('SITE_URL').'~'.$short;
}

// top of page menu
function menu() {
    $siteName = constant('SITE_NAME');
    $siteUrl = constant('SITE_URL');
    return <<<HTML
    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="{$siteUrl}" class="navbar-brand flex-shrink-0">
                {$siteName}
            </a>
    </header>
    HTML;
}

function addHit($id) {
    return $GLOBALS['pdo']->do(
        'INSERT INTO hits (shortId, timestamp, addr, hostname, uagent) VALUES (?, ?, ?, ?, ?)',
        [
            $id,
            time(),
            $_SERVER['REMOTE_ADDR'] ?? false,
            constant('RECORD_HOSTNAMES') ? gethostbyaddr($_SERVER['REMOTE_ADDR']) : false,
            $_SERVER['HTTP_USER_AGENT'] ?? false
        ]
    );
}