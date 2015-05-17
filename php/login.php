<?php 
    session_start();
    require_once "checkNoAuth.php";
    require_once "functions.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Airlife</title>
    <meta charset="UTF-8"> 
    <link rel="shortcut icon" type="image/x-icon" href="../images/icon.png">
    <link rel="stylesheet" type="text/css" href="../css/style.css" media="all">         
</head>
<body>
<div class="page-wrapper">
    <?php 
        require_once "header.php";  
        require_once "menu.php";

    $error = $user = $pass = "";
    
    if (isset($_POST['username']) and isset($_POST['password'])) 
    {            
        $username = sanitizeString($_POST['username']);
        $password = sanitizeString($_POST['password']);
        
        if ($username == "" || $password == "")
            $error = "Not all fields were entered<br>";
        else
        {
            //$token = md5($password);
            $result = queryMysql("SELECT user_id,username,password FROM users WHERE username='$username' AND password='$password'");
            $num    = $result->num_rows;      
            if ($num == 0)
            {
                $error = "<span>Неверный логин/пароль</span>";
            }
            else
            {        
                $row = $result->fetch_array(MYSQLI_ASSOC);                       
                $user_id = $row['user_id'];  

                $_SESSION['password'] = $password;
                $_SESSION['username'] = $username;          
                $_SESSION['user_id'] = $user_id;      
                              
                header('Location: ' . $_SERVER['HTTP_REFERER']);                
            }
        }
    }
    else
    {
        
    }

    echo <<<_END
        <section class="content">
            <div class="mid parentbox">         
                <div class="fon inline_block">  
                    <div class="registration_block">                                    
                        <h2>Войдите в Личный кабинет</h2>   
                        <form method="post" action="login.php">$error
                            <div><input type="text" name="username" placeholder="Логин" class="input width_2" required></div>
                            <div><input type="password" name="password" placeholder="Пароль" class="input width_2" required></div>            
                            <div><input type="submit" value="Войти" class="submit width_3" id="submit"></div>
                        </form>                  
                    </div>
                </div>          
            </div>
        </section>
    <div class="page-buffer"></div>
</div>
_END;
   
   require_once "footer.php";
?>

</body>
</html>