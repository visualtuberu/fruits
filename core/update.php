<?php
$db = new PDO("sqlite:../db/database.sqlite3");

$id = $_POST['id'];
//print_r($_POST);
//die();
$q = $db->prepare("UPDATE fruits SET title = :title, unit = :unit, count = :count, price = :price WHERE id = :id");
$q->execute([
    ':title' => $_POST['title'],
    ':unit' => $_POST['unit'],
    ':count' => $_POST['count'],
    ':price' => $_POST['price'],
    ':id' => $id
]);
header('Location: ../index.php');