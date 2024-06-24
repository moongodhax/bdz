<?php

require_once('MysqliWrapper.php');

$msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $middle_name = $_POST['middle_name'];
    $passport = $_POST['passport'];
    $tax_id = $_POST['tax_id'];
    $pension_id = $_POST['pension_id'];
    $driver_license = $_POST['driver_license'];
    $additional_docs = $_POST['additional_docs'];
    $notes = $_POST['notes'];

    $mysqli = MysqliWrapper::getMysqli();
    $stmt = $mysqli->prepare('INSERT INTO Individuals (first_name, last_name, middle_name, passport, tax_id, pension_id, driver_license, additional_docs, notes) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param("sssssssss", $first_name, $last_name, $middle_name, $passport, $tax_id, $pension_id, $driver_license, $additional_docs, $notes);
    $stmt->execute();

    $msg = 'Запись успешно добавлена в таблицу Individuals.';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Добавить новую запись</title>
    </head>

    <body>
        <h1>Добавить новую запись</h1>
        <a href="/">На главную</a><br /><br />

        <?php if ($msg) echo $msg; ?><br /><br />

        <form method="post" action="">
            <div>
                <label for="first_name">Имя:</label><br>
                <input type="text" id="first_name" name="first_name"><br><br>

                <label for="last_name">Фамилия:</label><br>
                <input type="text" id="last_name" name="last_name"><br><br>

                <label for="middle_name">Отчество:</label><br>
                <input type="text" id="middle_name" name="middle_name"><br><br>

                <label for="passport">Паспорт:</label><br>
                <input type="text" id="passport" name="passport"><br><br>

                <label for="tax_id">ИНН:</label><br>
                <input type="text" id="tax_id" name="tax_id"><br><br>
            </div>

            <div>
                <label for="pension_id">Номер пенсионного свидетельства:</label><br>
                <input type="text" id="pension_id" name="pension_id"><br><br>

                <label for="driver_license">Водительское удостоверение:</label><br>
                <input type="text" id="driver_license" name="driver_license"><br><br>

                <label for="additional_docs">Дополнительные документы:</label><br>
                <textarea id="additional_docs" name="additional_docs"></textarea><br><br>

                <label for="notes">Примечания:</label><br>
                <textarea id="notes" name="notes"></textarea><br><br>

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
