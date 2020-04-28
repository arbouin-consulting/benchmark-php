<?php

require_once 'vendor/autoload.php';

$faker = Faker\Factory::create();

$size = 10000;
$hostname = 'mysql';
$username = 'test';
$password = 'test123';
$dbname = 'testing';

$options = [
    \PDO::ATTR_ERRMODE                  => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE       => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES         => false,
    \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
];

$db = new PDO('mysql:host=' . $hostname . ';dbname=' . $dbname . ';charset=utf8', $username, $password, $options);

if (!$db) {
    die(sprintf('Connection failed: %s %s', $db->errorCode(), $db->errorInfo()));
}

$db->exec(
    "CREATE TABLE IF NOT EXISTS `users_int` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
);

$db->exec(
    "CREATE TABLE IF NOT EXISTS `users_uuid` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
);

$db->beginTransaction();
$progressBar = new ProgressBar\Manager(0, $size, 120);

$sql = 'INSERT INTO testing.users_int (name) VALUES (?)';
$stmt = $db->prepare($sql);

$sql2 = 'INSERT INTO testing.users_uuid (id, name) VALUES (?, ?)';
$stmt2 = $db->prepare($sql2);

for ($i = 0; $i < $size; $i++) {
    $name = $faker->name;
    $stmt->execute([$name]);
    $stmt2->execute([$faker->uuid, $name]);
    $progressBar->update($i + 1);
}
$db->commit();
echo "\n";
