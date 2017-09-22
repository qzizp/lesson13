<?php

  $host = "localhost";
  $user = "root";
  $pass = "";
  $name = "my_todolist";

  $connect =  new PDO("mysql: host=$host; dbname=$name; charset=utf8", $user, $pass);

?>