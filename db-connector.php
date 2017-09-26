<?php

  $host = "localhost";
  $user = "user";
  $pass = "pass";
  $name = "my_todolist";

  $connect =  new PDO("mysql: host=$host; dbname=$name; charset=utf8", $user, $pass);

?>