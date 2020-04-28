<?php

declare(strict_types=1);

$hostname = 'mysql';
$username = 'test';
$password = 'test123';
$dbname = 'testing';

$db = new \PDO('mysql:host=' . $hostname . ';dbname=' . $dbname . ';charset=utf8', $username, $password);

if (!$db) {
    die(sprintf('Connection failed: %s %s', $db->errorCode(), $db->errorInfo()));
}
