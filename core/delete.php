<?php
$db = new PDO("sqlite:../db/database.sqlite3");

$id = $_POST['id'];
$q = $db->prepare("DELETE FROM fruits WHERE id = ?");
$q->execute([$id]);
header('Location: /test_loc/index.php');
