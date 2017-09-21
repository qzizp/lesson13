<?php

  $host = "localhost";
  $user = "root";
  $pass = "";
  $name = "my_todolist";

  $connect =  new PDO("mysql: host=$host; dbname=$name; charset=utf8", $user, $pass);

  if (isset($_GET["submit"]) && !empty($_GET["business"])) {

    $newBusiness = $_GET["business"];

    $addBusiness = "INSERT INTO `tasks` (`description`, `is_done`) VALUES (?, ?)";
    $statement = $connect->prepare($addBusiness);
    $statement->execute([$newBusiness, 0]);
  }

  if (isset($_GET["id"]) && ($_GET["action"]) == "delete") {
    $deleteBusiness = "DELETE FROM `tasks` WHERE `id` = ?";
    $statement = $connect->prepare($deleteBusiness);
    $statement->execute([$_GET["id"]]);
  }

//$editBusiness = "UPDATE `tasks` SET `description` = ? WHERE `id` = ?";
//$statement = $connect->prepare($editBusiness);
//$statement->execute([$_GET["business"], $_GET["id"]]);

  $todolist = "SELECT * FROM `tasks`";
  $statement = $connect->prepare($todolist);
  $statement->execute();

  $results = [];

  while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $results[] = $row;
  }

//echo "<pre>";
//var_dump($results);
//echo "</pre>";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <link href="https://fonts.googleapis.com/css?family=PT+Serif:400,700&amp;subset=cyrillic" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>Список моих дел</title>
</head>
<body>
<div class="wrapper">
    <form action="">
        <input type="text" name="business" placeholder="Новая задача">
        <input type="submit" name="submit" value="Добавить задачу">
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
              <td><?php echo $row["description"] ?></td>
              <td><?php echo $status = ($row['is_done'] == 0) ? 'Не выполнено' : 'Выполнено'; ?></td>
              <td><?php echo $row["date_added"] ?></td>
              <td><a href="?id=<?php $row["id"] ?>&action=delete">Del</a><?php echo "<pre>";
                var_dump($row["id"]);
                echo "</pre>";?></td>
          </tr>

      <?php endforeach; ?>
    </table>

</div>
</body>
</html>
