<?php
require_once('MysqliWrapper.php');

$msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $galaxy = $_POST['galaxy'];
    $accuracy = $_POST['accuracy'];
    $lightFlux = $_POST['lightFlux'];
    $associatedObjects = $_POST['associatedObjects'];
    $note = $_POST['note'];

    $mysqli = MysqliWrapper::getMysqli();
    $stmt = $mysqli->prepare('INSERT INTO NaturalObjects (type, galaxy, accuracy, lightFlux, associatedObjects, note) 
        VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param("ssssss", $type, $galaxy, $accuracy, $lightFlux, $associatedObjects, $note);
    $stmt->execute();

    $msg = 'Запись успешно добавлена в таблицу NaturalObjects.';
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Добавить новую запись в NaturalObjects</title>
    </head>

    <body>
        <h1>Добавить новую запись</h1>

        <a href="/">На главную</a><br /><br />

        <?php if ($msg) echo $msg; ?><br /><br />

        <form method="post">
            <div>
                <label for="type">Тип:</label><br>
                <input type="text" id="type" name="type"><br><br>

                <label for="galaxy">Галактика:</label><br>
                <input type="text" id="galaxy" name="galaxy"><br><br>

                <label for="accuracy">Точность:</label><br>
                <input type="text" id="accuracy" name="accuracy"><br><br>

                <label for="lightFlux">Световой поток:</label><br>
                <input type="text" id="lightFlux" name="lightFlux"><br><br>
            </div>

            <div>
                <label for="associatedObjects">Ассоциированные объекты:</label><br>
                <input type="text" id="associatedObjects" name="associatedObjects"><br><br>

                <label for="note">Примечание:</label><br>
                <textarea id="note" name="note"></textarea><br><br>

                <input type="submit" value="Добавить запись">
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