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
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $connection->real_escape_string($var);
  }

  function showProfile($user)
  {
    if (file_exists("$user.jpg"))
      echo "<img src='$user.jpg' style='float:left;'>";

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if ($result->num_rows)
    {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
    }
  }

function found_path($flight_from, $kuda_idu, $found)
{
    echo "<br>------------------------------<br>";
    echo "$flight_from -- $kuda_idu -- $found<br>";                            
    $query = "SELECT DISTINCT flight_from, flight_to FROM flights WHERE flight_from = '$flight_from'";
    $result = queryMysql($query);
    $num    = $result->num_rows;
    echo "$num <br>";                    
    for ($j = 0 ; $j < $num ; ++$j)
    {   
        $row = $result->fetch_array(MYSQLI_ASSOC);  
        $kuda_idu_new = $row['flight_to'];        
        echo "$j --- $flight_from -- $kuda_idu_new -- $found<br>";                            

        if($kuda_idu_new == $found)
        {
            echo "OKKKKK!";
            break;
        }         
        else         
        {   
            if($kuda_idu != $kuda_idu_new)
            {                   
                found_path($kuda_idu_new, $flight_from, $found);
            }
            else 
            {
                echo "уже был в: $kuda_idu <br>";
            }
        }
    }           
}

?>
