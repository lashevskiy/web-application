<?php
require_once "functions.php";
//$login=rs('[^A-Za-z]',$_POST['login'],40);  //удаление запрещённых символов
$username = sanitizeString($_POST['username']);
if(!empty($username))
{
    $result = queryMysql("SELECT user_id FROM users WHERE username='$username'");
    $num    = $result->num_rows;

    if($num != 0)
    {
        $row = $result->fetch_array(MYSQLI_ASSOC);                              
        $user_id = $row['user_id'];
        $time=time();      

        $result = queryMysql("UPDATE users SET time = '$time' WHERE user_id='$user_id'");        
        echo "$time";
    }
    else
    {
        $result = queryMysql("SELECT user_id FROM admins WHERE username='$username'");
        $num    = $result->num_rows;
        
        if($num !=0)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);                              
            $user_id = $row['user_id'];
            $time=time();      

            $result = queryMysql("UPDATE admins SET time = '$time' WHERE user_id='$user_id'");                
            echo "$time";
        }
        else
        {
            echo "error";
        }

    }
    unset($time,$row,$username); //удаление переменных
    //mysql_close($db_my);        //закрываем конект к БД
}
else
{
    echo 'error';   //возвращаем ошибку в js, если поле логина пустое или оно стало пустым после обработки
}
?>