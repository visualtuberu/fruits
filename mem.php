<?php
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/vendor/larapack/dd/src/helper.php";

try {
    $db = new PDO("sqlite:db/database.sqlite3");
} catch (PDOException $e) {
    echo $e->getMessage();
    echo 'Ошибка подключения к базе данных';
}

// Сброс фильтра
if($_GET['reset'] == 1){
    $_GET = [];
}

$sql = "SELECT * FROM `fruits`";

$data = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$priceArr = [];
$countArr = [];
foreach ($data as $key => $value) {
    array_push($priceArr, $value['price']);
    array_push($countArr, $value['count']);
}
$countMin = min($countArr);
$countMax = max($countArr);

$priceMin = min($priceArr);
$priceMax = max($priceArr);

$counter = 1;


if(!empty($_GET)){

    $_GET['priceMin'] >= 0 ? $_GET['priceMin'] : 0;
    $myMin = $_GET['priceMin'];

    $_GET['priceMax'] <= $priceMax ? $_GET['priceMax'] : $priceMax;
    $myMax = $_GET['priceMax'];

    $_GET['countMin'] >= 0 ? $_GET['countMin'] : 0;
    $myCountMin = $_GET['countMin'];

    $_GET['countMax'] <= $priceMax ? $_GET['countMax'] : $priceMax;
    $myCountMax = $_GET['countMax'];

    $tempData = [];
    foreach ($data as $key => $value) {
        if ($value['price'] >= $myMin && $value['price'] <= $myMax &&  $value['count'] >= $myCountMin && $value['count'] <= $myCountMax){
            array_push($tempData, $value);
        }
    }

    $data = $tempData;
    $priceMin = $myMin;
    $priceMax = $myMax;
    $countMin = $myCountMin;
    $countMax = $myCountMax;

}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
<div class="container">

    <form action="index.php" method="get">
        <label for="priceMin">Цена от</label>
        <input type="number" name="priceMin" min="0"  placeholder="Цена от" id="priceMin" value="<?=$priceMin?>">
        <label for="priceMax">Цена до</label>
        <input type="number" name="priceMax" min="0"  placeholder="Цена до" id="priceMax" value="<?=$priceMax?>">
        <br>
        <label for="countMin">Количество от</label>
        <input type="number" name="countMin" min="0"  placeholder="Количество от" id="countMin" value="<?=$countMin?>">
        <label for="countMax">Количество до</label>
        <input type="number" name="countMax" min="0"  placeholder="Количество до" id="priceMax" value="<?=$countMax?>">
        <br> <br>
        <button type="submit" class="btn btn-success">Применить фильтр</button>
    </form>
    <br>
    <form action="index.php" method="get">
        <input type="hidden" name="reset" value="1" >
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
                            <input type="hidden"  name="id" value=<?= $d['id'] ?>>
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
        <hr>
        <form action="core/add.php" method="post">
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
</body>
</html>
