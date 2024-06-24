<?php

require_once('MysqliWrapper.php');

$mysqli = MysqliWrapper::getMysqli();

$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $mysqli = MysqliWrapper::getMysqli();
    $stmt = $mysqli->prepare('DELETE FROM Individuals WHERE id = ?');
    $stmt->bind_param("i", $_POST['delete_id']);
    $stmt->execute();
    $msg = 'Запись успешно удалена из таблицы Individuals.';
}

$individuals = $mysqli->query('SELECT * FROM Individuals');

?>

<h1>Физические Лица</h1>

<?php if ($msg) echo $msg; ?> 

<table>
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Отчество</th>
        <th>Паспорт</th>
        <th>ИНН</th>
        <th>СНИЛС</th>
        <th>Вод. Права</th>
        <th>Доп. Документы</th>
        <th>Примечание</th>
        <th>Ред.</th>
        <th>Уд.</th>
    </tr>

    <?php while ($row = $individuals->fetch_assoc()) { ?>
        <tr>
            <?php foreach ($row as $value) { ?>
                <td><?=htmlspecialchars($value) ?></td>
            <?php } ?>
            <td><a href="edit.php?id=<?=$row['id']?>">Редактировать</a></td>
            <td>
                <form method="post" onsubmit="confirmDelete()">
                    <input type="hidden" name="delete_id" value="<?=$row['id']?>">
                    <input type="submit" value="Удалить">
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

<br />
<br />

<a href="add.php">Добавить новую запись</a>

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