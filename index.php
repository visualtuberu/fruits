<?php
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/vendor/larapack/dd/src/helper.php";

try {
    $db = new PDO("sqlite:db/database.sqlite3");
} catch (PDOException $e) {
    echo $e->getMessage();
    echo 'Ошибка подключения к базе данных';
}
$isFilter = 0;

if(isset($_GET['isFilter'])) {
    $isFilter = 1;
    var_dump($_GET['isFilter']);
}
// Сброс фильтра
if ($_GET['reset'] == 1) {
    $isFilter = 0;
    $_GET['isFilter'] = NULL;
}

if($_SERVER['offset'] != 0){
    $offset = $_SERVER['offset'];
} else{
    $offset = 0;
}
//$forward = 0;
//$back = 0;

if($_GET["forward"] == 1){
       $_SERVER['offset'] = $offset + 5;
       $offset = $_SERVER['offset'];
       $_GET['forward'] = NULL;
       echo 'offset ' . $offset;
}
if($_GET["back"] == 1){
    $_SERVER['offset'] = $offset - 5;
    $offset = $_SERVER['offset'];
    $_GET['back'] = NULL;
    echo $offset;
}

$filterQuery = $db->query("SELECT MAX(price), MIN(price), MAX(count), MIN(count) FROM `fruits` LIMIT 5 ");
$filteredData = $filterQuery->fetch(PDO::FETCH_ASSOC);

["MAX(price)" => $maxPrice, "MIN(price)" => $minPrice, "MAX(count)"=> $maxCount, "MIN(count)"=> $minCount] = $filteredData;

if (!$isFilter) {

    $sql = "SELECT * FROM `fruits` LIMIT 5 OFFSET $offset";
    $data = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

}

if ($isFilter) {
    $sql = "SELECT * FROM `fruits`  WHERE price >= :minPrice and price <= :maxPrice and count >= :minCount and count <= :maxCount LIMIT 5 ";
    $q = $db->prepare($sql);
    $q->execute([
        'minPrice' => $_GET['minPrice'],
        'maxPrice' => $_GET['maxPrice'],
        'minCount' => $_GET['minCount'],
        'maxCount' => $_GET['maxCount']
    ]);
    $data = $q->fetchAll(PDO::FETCH_ASSOC);

    // Обновляем данные в инпутах фильтра
    $minPrice = $_GET['minPrice'];
    $maxPrice = $_GET['maxPrice'];
    $minCount = $_GET['minCount'];
    $maxCount = $_GET['maxCount'];

}




$counter = 1;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <div class="container">

    <form action="index.php" method="get">
        <label for="priceMin">Цена от</label>
        <input type="number" name="minPrice" min="0" placeholder="Цена от" id="minPrice" value="<?= $minPrice ?>">
        <label for="priceMax">Цена до</label>
        <input type="number" name="maxPrice" min="0" placeholder="Цена до" id="maxPrice" value="<?= $maxPrice ?>">
        <br>
        <label for="countMin">Количество от</label>
        <input type="number" name="minCount" min="0" placeholder="Количество от" id="minCount" value="<?= $minCount ?>">
        <label for="countMax">Количество до</label>
        <input type="number" name="maxCount" min="0" placeholder="Количество до" id="maxCount" value="<?= $maxCount ?>">
        <br> <br>
        <input type="hidden" name="isFilter" value="<?= $isFilter ?>">
        <button type="submit" class="btn btn-success">Применить фильтр</button>
    </form>
    <br>
    <form action="index.php" method="get">
        <input type="hidden" name="reset" value="1">
        <input type="submit" class="btn btn-warning" value="Сбросить фильтр">
    </form>

    <div class="table_wrapper">
        <table class="table">
            <tr>
                <th>Номер</th>
                <th>Наименование</th>
                <th>Ед. измерения</th>
                <th>Количество</th>
                <th>Цена</th>
            </tr>

            <?php

            foreach ($data as $d) {
            ?>
            <tr>
                <td><?= $counter++ ?></td>
                <td><?= $d['title'] ?></td>
                <td><?= $d['unit'] ?></td>
                <td><?= $d['count'] ?></td>
                <td><?= $d['price'] ?></td>
                <td>
                    <form action="core/delete.php" method="post">
                        <input type="hidden" name="id" value=<?= $d['id'] ?>>
                        <button type="submit" class="btn btn-danger">удалить</button>
                    </form>
                </td>
                <td>
                    <form action="pages/update.php" method="post">
                        <input type="hidden" name="id" value=<?= $d['id'] ?>>
                        <button type="submit" class="btn btn-warning">изменить</button>
                    </form>
                </td>

            </tr>


            <?php
            }
            ?>
        </table>
        <div class="control" >
            <form class="control-form" action="index.php" method="get">
                <input type="hidden" name="back" value="1">
                <button>Назад</button>
            </form>
            <form class="control-form" action="index.php" method="get">
                <input type="hidden" name="forward" value="1">
                <button>Вперед</button>
            </form>
        </div>
        <hr>
        <form action="core/add.php" method="post" >
            <input type="text" name="title" placeholder="Наименование" required>
            <select name="unit" id="unit">
                <option value="Кг">Кг</option>
                <option value="Шт">Шт</option>
            </select>
            <input type="number" name="count" min="0" placeholder="Количество" required>

            <input type="number" name="price" min="0" placeholder="Цена" required>
            <button type="submit" class="btn btn-success">добавить</button>
        </form>
    </div>
    <?= var_dump($isFilter)?>
    <?= var_dump($_GET['isFilter'])?>
</body>
</html>
