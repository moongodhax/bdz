<?php

require_once('MysqliWrapper.php');

$mysqli = MysqliWrapper::getMysqli();

$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $mysqli = MysqliWrapper::getMysqli();
    $stmt = $mysqli->prepare('DELETE FROM NaturalObjects WHERE objectId = ?');
    $stmt->bind_param("i", $_POST['delete_id']);
    $stmt->execute();
    $msg = 'Запись успешно удалена из таблицы NaturalObjects.';
}

$naturalObjects = $mysqli->query('SELECT * FROM NaturalObjects');
$joined = $mysqli->query('CALL join_tables_data("Position", "Objects")');

?>

<h1>Естественные объекты</h1>

<?php if ($msg) echo $msg; ?> <br />

<table>
    <tr>
        <th>ID объекта</th>
        <th>Тип</th>
        <th>Галактика</th>
        <th>Точность</th>
        <th>Световой поток</th>
        <th>Сопряженные объекты</th>
        <th>Примечание</th>
        <th>Ред.</th>
        <th>Уд.</th>
    </tr>

    <?php while ($row = $naturalObjects->fetch_assoc()) { ?>
        <tr>
            <?php foreach ($row as $value) { ?>
                <td><?=htmlspecialchars($value) ?></td>
            <?php } ?>
            <td><a href="edit.php?id=<?=$row['objectId']?>">Редактировать</a></td>
            <td>
                <form method="post" onsubmit="confirmDelete()">
                    <input type="hidden" name="delete_id" value="<?=$row['objectId']?>">
                    <input type="submit" value="Удалить">
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

<br />
<a href="add.php">Добавить новую запись</a>
<br /><br />

<h1>Объединение таблиц</h1>

<table>
    <tr>
        <th>ID положения</th>
        <th>Положние Земли</th>
        <th>Положение Солнца</th>
        <th>Положение Луны</th>
        <th>Тип объекта</th>
        <th>Точность</th>
        <th>Дата</th>
        <th>Время</th>
        <th>Примечания</th>
    </tr>

    <?php while ($row = $joined->fetch_assoc()) { ?>
        <tr>
            <td><?=htmlspecialchars($row['positionId'])?></td>
            <td><?=htmlspecialchars($row['EarthPosition'])?></td>
            <td><?=htmlspecialchars($row['SunPosition'])?></td>
            <td><?=htmlspecialchars($row['MoonPosition'])?></td>
            <td><?=htmlspecialchars($row['objectType'])?></td>
            <td><?=htmlspecialchars($row['accuracy'])?></td>
            <td><?=htmlspecialchars($row['detectedDate'])?></td>
            <td><?=htmlspecialchars($row['detectedTime'])?></td>
            <td><?=htmlspecialchars($row['notes'])?></td>
        </tr>
    <?php } ?>
</table>

<script>
    function confirmDelete() {
        return confirm('Вы действительно хотите удалить запись?');
    }
</script>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    table, td, th {
        border: 1px solid #000;
    }
    td {
        padding: 10px;
    }
</style>