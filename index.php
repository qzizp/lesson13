<?php

  // Подключаемся к базе
  require_once "db-connector.php";

  // Добавляем задачу
  if (isset($_GET["submit"]) && !empty($_GET["business"])) {

    $newBusiness = $_GET["business"];

    $addBusiness = "INSERT INTO `tasks` (`description`, `is_done`) VALUES (?, ?)";
    $statement = $connect->prepare($addBusiness);
    $statement->execute([$newBusiness, 0]);
  }

  // Удаляем задачу
  if (isset($_GET["id"]) && ($_GET["action"]) == "delete") {
    $deleteBusiness = "DELETE FROM `tasks` WHERE `id` = ?";
    $statement = $connect->prepare($deleteBusiness);
    $statement->execute([$_GET["id"]]);
  }

  // Присваиваем задаче статус "Сделано!"
  if (isset($_GET["id"]) && ($_GET["action"]) == "complete") {
    $completeBusiness = "UPDATE `tasks` SET `is_done` = 1 WHERE `id` = ?";
    $statement = $connect->prepare($completeBusiness);
    $statement->execute([$_GET["id"]]);
  }

  // Редактируем задачу
  if(!empty($_POST["business"]) && isset($_POST["edit"]) && isset($_GET["id"])){
    $editTask = "UPDATE `tasks` SET `description` = ? WHERE `id`=?";
    $statement = $connect->prepare($editTask);
    $statement->execute([$_POST["business"], $_GET["id"]]);
  }

  // Сортируем
  if (isset($_GET["sorting"]) && isset($_GET["sort"])) {

    if ($_GET["sort"] == "by-status") {
        $typeOfSort = "is_done";
    } elseif ($_GET["sort"] == "by-description") {
        $typeOfSort = "description";
    }

    $sortedTasks = "SELECT * FROM `tasks` ORDER BY $typeOfSort";
    $statement = $connect->prepare($sortedTasks);
    $statement->execute([$typeOfSort]);
  }

  // Делаем выборку из базы
  $todolist = "SELECT * FROM `tasks`";
  $statement = $connect->prepare($todolist);
  $statement->execute();

  $results = [];

  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $results[] = $row;
  }

?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <link href="https://fonts.googleapis.com/css?family=PT+Serif:400,700&amp;subset=cyrillic" rel="stylesheet">
  <link rel="stylesheet" href="./css/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <title>Список моих дел</title>
</head>
<body>
<div class="wrapper">
  <?php if(isset($_GET['id']) && ($_GET['action']) == 'edit') :?>
      <form method="POST" action="index.php?id=<?= $_GET["id"] ?>">
          <input type="text" name="business" placeholder="Обновить запись" value="">
          <input type="submit" name="edit" value="Изменить">
      </form>
  <?php else : ?>
      <form action="">
          <input type="text" name="business" placeholder="Новая задача">
          <input type="submit" name="submit" value="Добавить задачу">
      </form>
  <?php endif ?>

    <form action="">
        <label for="sort">Отсортировать дела по:</label>
            <select name="sort" id="sort">
                <option value="by-date">По дате постановки</option>
                <option value="by-status">По статусу выполнения</option>
                <option value="by-description">По описанию</option>
            </select>
        <input type="submit" name="sorting" value="Отсортировать">


    </form>

    <table>
        <tr>
            <th>Задача</th>
            <th>Статус выполнения</th>
            <th>Дата постановки</th>
            <th>Действия</th>
        </tr>
      <?php foreach ($results as $row): ?>
          <tr>
              <td class="task"><?= $row["description"] ?></td>
              <td><?= $status = ($row["is_done"] == 0) ? "Не сделано" : "Сделано"; ?></td>
              <td><?= $row["date_added"] ?></td>
              <td class="todo-actions">
                  <a class="complete" href="?id=<?= $row["id"] ?>&action=complete" title="Сделано!"><i class="fa fa-check-square-o" aria-hidden="true"></i></a>
                  <a class="edit" href="?id=<?= $row["id"] ?>&action=edit" title="Изменить задачу"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                  <a class="delete" href="?id=<?= $row["id"] ?>&action=delete" title="Удалить задачу"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
              </td>
          </tr>

      <?php endforeach; ?>
    </table>

</div>
</body>
</html>
