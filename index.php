<?php
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/vendor/larapack/dd/src/helper.php";


$db = new PDO("sqlite:db/database.sqlite3");
$sql = "SELECT * FROM `fruits`";
$data = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$counter = 1;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <div class="container">

        <div class="table">
            <input class="line" type="text" name="number" value="Номер">
            <input class="line" type="text" name="title" value="Наименование">
            <input class="line" type="text" name="unit" value="Ед. измерения">
            <input class="line" type="text" name="count" value="Количество">
            <input class="line" type="text" name="price" value="Цена">
            <br>
        <?php

        foreach ($data as $d) {
            ?>

            <form action="core/delete.php" method="post">
                <input type="text" name="number" value="<?= $counter++ ?>">
                <input type="text" name="title" value="<?= $d['title'] ?>">
                <input type="text" name="unit" value="<?= $d['unit'] ?>">
                <input type="text" name="count" value="<?= $d['count'] ?>">
                <input type="text" name="price" value="<?= $d['price'] ?>">
                <button type="submit" class="change_btn">удалить</button>
            </form>
            <br>

        <?php
        }
        ?>
        </div>
        <hr>
        <form action="core/add.php" method="post">
            <input type="text" name="title" placeholder="Наименование">
            <input type="text" name="unit" placeholder="Ед. измерения">
            <input type="text" name="count" placeholder="Количество">
            <input type="text" name="price" placeholder="Цена">
            <button type="submit">добавить</button>
        </form>
    </div>
</body>
</html>
