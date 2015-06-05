<?php 
  $dbhost  = 'localhost';  // изменить здесь по необходимости
  $dbuser  = 'root';   //имя пользователя БД. изменить здесь по необходимости
  $dbpass  = '';   // пароль пользователя . изменить здесь по необходимости
  $dbname  = 'airlife';    

  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($connection->connect_error) die($connection->connect_error);

  queryMysql("SET NAMES 'utf8'"); 
  queryMysql("SET CHARACTER SET 'utf8'"); 
  queryMysql("SET SESSION collation_connection = 'utf8_general_ci'"); 
 

  function queryMysql($query)
  {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    return $result;
  }
  

  function destroySession()
  {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
      setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
  }

  function sanitizeString($var)
  {
    global $connection;
    $var = trim($var); //Удаляем пробелы
    $var = strip_tags($var); //Удаляет HTML и PHP-теги из строки
    $var = htmlentities($var); //Преобразует все возможные символы в соответствующие HTML-сущности
    $var = stripslashes($var); //Удаляет экранирование символов
    $var = trim($var);
    return $connection->real_escape_string($var);
  }


?>
