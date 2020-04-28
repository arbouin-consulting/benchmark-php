<?php

declare(strict_types=1);

require_once 'connect_pdo.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';

$start = microtime(true);

for ($i = $size; $i < $size + 200; $i++) {
    $sql = sprintf('SELECT `name` FROM %s order by `name` DESC LIMIT %d', 'users_int', $i);
    $result = $db->query($sql);
}

echo 'pdo - primary key int - fetched rows in ' . number_format(microtime(true) - $start, 5) . " seconds\n";
