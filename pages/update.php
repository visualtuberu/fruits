<?php
$db = new PDO("sqlite:../db/database.sqlite3");
$id = $_POST['id'];
$sql = "SELECT * FROM `fruits` WHERE id = $id";
$data = $db->query($sql)->fetch(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Update</title>
</head>
<body>
<form action="../core/update.php" method="post">
    <input type="hidden" name="id" value="<?= $data['id']?>">
    <input type="text" name="title" placeholder="Наименование" value="<?=$data['title']?>" required>
    <select name="unit" id="unit">
        <option value="Кг">Кг</option>
        <option value="Шт">Шт</option>
    </select>
    <input type="number" name="count" placeholder="Количество" min="0" value="<?=$data['count']?>" required>

    <input type="number" name="price" placeholder="Цена" min="0" value="<?=$data['price']?>" required>
    <button type="submit" class="btn btn-warning">Изменить</button>
</form>
</body>
</html>
