<?php

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/config.php';

if (!file_exists(constant('DATABASE_PATH'))) {
    $GLOBALS['pdo'] = new \Staticflux\SQLite(constant('DATABASE_PATH'));
    $GLOBALS['pdo']->do(<<<SQL
    CREATE TABLE IF NOT EXISTS 'records' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'short' TEXT, 'long' TEXT, 'timestamp' INTEGER);
    SQL);
    $GLOBALS['pdo']->do(<<<SQL
    CREATE TABLE IF NOT EXISTS 'hits' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'shortId' INTEGER, 'timestamp' INTEGER, 'addr' TEXT, 'hostname' TEXT, 'uagent' TEXT);
    SQL);
}
else {
    $GLOBALS['pdo'] = new \Staticflux\SQLite(constant('DATABASE_PATH'));
}

require_once __DIR__.'/functions.php';