<?php
$db = new PDO("sqlite:../db/database.sqlite3");

$title = $_POST['title'];
$unit = $_POST['unit'];
$count = $_POST['count'];
$price = $_POST['price'];


$q = $db->prepare("INSERT INTO `fruits` (`title`, `unit`, `count`, `price` ) VALUES (:title, :unit, :count, :price)");
$q->execute([
    ':title' => $title,
    ':unit' => $unit,
    ':count' => $count,
    ':price' => $price
]);
header('Location: ../index.php');