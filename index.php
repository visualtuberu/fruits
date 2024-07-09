<?php
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/vendor/larapack/dd/src/helper.php";
try {
    $db = new PDO('mysql:host=localhost;dbname=wayup', 'root', 'root');
} catch (PDOException $e) {
    echo $e->getMessage();
}
// SELECT
//$query = $db->prepare("SELECT * FROM `articles` WHERE `id` = :id AND `category_id` = :category");
//$query->execute([
//    'id' => 3,
//    'category' => 1
//]);
//$data = $query->fetchAll(PDO::FETCH_ASSOC);
//dd($data);
$categoryID = 1;
$categoryName = 'JS';
$q = $db->prepare("UPDATE `categories` SET `name` = :name WHERE `id` = :id");
$q->execute([
    'name' => 'test2',
    'id' => $categoryID
]);