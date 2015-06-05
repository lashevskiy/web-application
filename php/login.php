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
    <script src="../javascript/md5.min.js"></script>
    <script src="../javascript/auth.js"></script>  
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
        $password_check = sanitizeString($_POST['password']);
        
        
        if ($username == "" || $password_check == "")
            $error = "Not all fields were entered<br>";
        else
        {
            $result = queryMysql("SELECT user_id, username, password, time FROM users WHERE username='$username'");            
            $num    = $result->num_rows;      
            if ($num == 0)
            {           
                $result2 = queryMysql("SELECT user_id,username,password, time FROM admins WHERE username='$username'");
                $num2    = $result2->num_rows;
                if($num2==0)
                {
                    $error = "<span>Неверный логин/пароль</span>";                    
                }
                else
                {
                    $row = $result2->fetch_array(MYSQLI_ASSOC);                       
                    $user_id = $row['user_id'];  
                    $password = $row['password'];  
                    $time = $row['time']; 
                   

                    $password_current = md5($password.$time);   
                   
                   

                    if($password_current == $password_check) 
                    {
                        $_SESSION['password'] = $password;
                        $_SESSION['username'] = $username;          
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['admin'] = true;      
                                                              
                        header('Location: ' . $_SERVER['HTTP_REFERER']); 
                    }
                    else
                    {
                        $error = "<span>Неверный логин/пароль</span>";                    
                    }
                }
            }
            else
            {        

                $row = $result->fetch_array(MYSQLI_ASSOC);                       
                $user_id = $row['user_id'];  
                $password = $row['password'];  
                $time = $row['time']; 

                
                
                

                $password_current = md5($password.$time);   
                
                

                if($password_current == $password_check) 
                {
                    $_SESSION['password'] = $password;
                    $_SESSION['username'] = $username;          
                    $_SESSION['user_id'] = $user_id;      
                    $_SESSION['admin'] = false;    

                    header('Location: ' . $_SERVER['HTTP_REFERER']);

                }
                else
                {
                    $error = "<span>Неверный логин/пароль</span>";                    
                }
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
                        <form method="post" action="login.php" onsubmit="ajax(this)">$error                        
                            <div><input type="text" name="username" id="username" placeholder="Логин" class="input width_2" required pattern="[a-zA_Z0-9._]{5,}" title="Не менее 5 символов, содержащих символы из нижнего или верхнего регистра, цифры и символы '_', '.'"></div>
                            <div><input type="password" name="password" id="password" placeholder="Пароль" class="input width_2" required ></div>                                                                                                                
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