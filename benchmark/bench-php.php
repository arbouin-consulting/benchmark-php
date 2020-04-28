<?php

set_time_limit(1000);

test_pdo_buffered(100, 'users_int');

test_mysqli_buffered(100, 'users_int');

test_pdo_buffered(100, 'users_uuid');

test_mysqli_buffered(100, 'users_uuid');

test_pdo_buffered(10, 'users_int');

test_mysqli_buffered(10, 'users_int');

test_pdo_buffered(10, 'users_uuid');

test_mysqli_buffered(10, 'users_uuid');


function test_mysqli_buffered($size, $table)
{

    $start = microtime(true);

    $conn = new mysqli($hostname, $username, $password, $dbname);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    for ($i = $size; $i < $size + 200; $i++) {
        $sql = sprintf('SELECT `name` FROM %s order by `name` DESC LIMIT %d', $table, $i);
        $result = $conn->query($sql);
    }

    $conn->close();

    echo 'mysqli ' . $table . ' - fetched rows in ' . number_format(microtime(true) - $start, 5) . " seconds\n";
}

function test_pdo_buffered($size, $table)
{
    $options = [
//        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
//        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
//        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $start = microtime(true);


    for ($i = $size; $i < $size + 200; $i++) {
        $sql = sprintf('SELECT `name` FROM %s order by `name` DESC LIMIT %d', $table, $i);
        $result = $db->query($sql);
    }

    echo 'pdo ' . $table . ' - fetched rows in ' . number_format(microtime(true) - $start, 5) . " seconds\n";
}
