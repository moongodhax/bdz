<?php
require_once('MysqliWrapper.php');

$mysqli = MysqliWrapper::getMysqli();

$msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objectId = $_POST['objectId'];
    $type = $_POST['type'];
    $galaxy = $_POST['galaxy'];
    $accuracy = $_POST['accuracy'];
    $lightFlux = $_POST['lightFlux'];
    $associatedObjects = $_POST['associatedObjects'];
    $note = $_POST['note'];

    $stmt = $mysqli->prepare('UPDATE NaturalObjects SET type = ?, galaxy = ?, accuracy = ?, lightFlux = ?, associatedObjects = ?, note = ? WHERE objectId = ?');
    $stmt->bind_param("ssssssi", $type, $galaxy, $accuracy, $lightFlux, $associatedObjects, $note, $objectId);
    $stmt->execute();

    $msg = 'Запись успешно обновлена в таблице NaturalObjects.';
}

if (isset($_GET['id'])) {
    $stmt = $mysqli->prepare('SELECT * FROM NaturalObjects WHERE objectId = ?');
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo 'Запись не найдена';
    }
    else {
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Редактирование записи</title>
    </head>
    <body>
        <h1>Редактирование записи</h1>

        <a href="/">На главную</a><br /><br />

        <?php if ($msg) echo $msg; ?><br /><br />

        <form method="POST">
            <input type="hidden" name="objectId" value="<?= $row['objectId'] ?>">
            <div>
                <label for="type">Тип:</label><br>
                <input type="text" id="type" name="type" value="<?= $row['type'] ?>"><br><br>
                <label for="galaxy">Галактика:</label><br>
                <input type="text" id="galaxy" name="galaxy" value="<?= $row['galaxy'] ?>"><br><br>
                <label for="accuracy">Точность:</label><br>
                <input type="text" id="accuracy" name="accuracy" value="<?= $row['accuracy'] ?>"><br><br>
                <label for="lightFlux">Поток света:</label><br>
                <input type="text" id="lightFlux" name="lightFlux" value="<?= $row['lightFlux'] ?>"><br><br>
            </div>
            <div>
                <label for="associatedObjects">Связанные объекты:</label><br>
                <input type="text" id="associatedObjects" name="associatedObjects" value="<?= $row['associatedObjects'] ?>"><br><br>
                <label for="note">Примечание:</label><br>
                <textarea id="note" name="note"><?= $row['note'] ?></textarea><br><br>
                <button type="submit">Сохранить</button>
            </div>
        </form>

        <style>
            div {
                float: left;
                width: 270px;
            }
        </style>
    </body>
</html>

<?php
    }
} else {
    echo 'Не указан Идентификатор записи';
}
?>