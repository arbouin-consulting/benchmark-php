<?php

declare(strict_types=1);

include_once 'connect_pdo.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';

$db->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
$stmt = $db->query('SELECT * FROM users_int');
$mem = memory_get_usage();
while ($row = $stmt->fetch()) {
    ;
}
echo 'Memory used: ' . getSizeName(memory_get_usage() - $mem) . "\n";

$db->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
$stmt = $db->query('SELECT * FROM users_int');
$mem = memory_get_usage();
dump($mem);
while ($row = $stmt->fetch()) {
    ;
}
echo 'Memory used: ' . getSizeName(memory_get_usage() - $mem) . "\n";
function getSizeName($octet)
{
    // Array contenant les differents unités
    $unite = ['octet', 'ko', 'mo', 'go'];

    if ($octet < 1000) { // octet
        return $octet . $unite[0];
    }

    if ($octet < 1000000) { // ko
        $ko = round($octet / 1024, 2);

        return $ko . $unite[1];
    }

    if ($octet < 1000000000) { // Mo
        $mo = round($octet / (1024 * 1024), 2);

        return $mo . $unite[2];
    }

    $go = round($octet / (1024 * 1024 * 1024), 2); // Go

    return $go . $unite[3];
}
