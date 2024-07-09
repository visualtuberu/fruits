<?php
$db = new PDO("sqlite:../db/database.sqlite3");

$title = $_POST['title'];
$unit = $_POST['unit'];
$count = $_POST['count'];
$price = $_POST['price'];


$q = $db->query("INSERT INTO `fruits` (`title`, `unit`, `count`, `price` ) VALUES ('$title', '$unit', '$count', '$price')");
header('Location: /test_loc/index.php');