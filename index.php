<?php
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/vendor/larapack/dd/src/helper.php";

try {
    $db = new PDO("sqlite:db/database.sqlite3");
} catch (PDOException $e) {
    echo $e->getMessage();
    echo 'Ошибка подключения к базе данных';
}
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
<div class="container">

    <div class="table_wrapper">
        <table class="table">
            <tr>
                <th>Номер</th>
                <th>Наименование</th>
                <th>Ед. измерения</th>
                <th>Количество</th>
                <th>Цена</th>
                <th></th>
                <th></th>
            </tr>

            <?php foreach ($data as $d) :?>
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
            <?php endforeach; ?>
        </table>
        <hr>
        <form action="core/add.php" method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>Наименование</th>
                        <th>Единицы измерения</th>
                        <th>Количество</th>
                        <th>Цена</th>
                        <th>Добавить</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="title" placeholder="Наименование" required></td>
                        <td>
                            <select name="unit" id="unit">
                                <option value="Кг">Кг</option>
                                <option value="Шт">Шт</option>
                            </select>
                        </td>
                        <td><input type="number" name="count" min="0" placeholder="Количество" required></td>
                        <td><input type="number" name="price" min="0" placeholder="Цена" required></td>
                        <td><button type="submit" class="btn btn-success">добавить</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</body>

</html>
