<?php
	session_start();
	require_once "checkAuth.php";
?> 
<!DOCTYPE html>
<html>
<head>
	<title>Airlife</title>
	<meta charset="UTF-8"> 
	<link rel="shortcut icon" type="image/x-icon" href="../images/icon.png">
	<link rel="stylesheet" type="text/css" href="../css/style.css" media="all">			
	<script type="text/javascript">
	function timer(){
	 	var obj=document.getElementById('timer_inp');
	 	obj.innerHTML--;	 
	 	if(obj.innerHTML==0)
	 	{	 		
	 		setTimeout(function(){},1000);
		}
	 	else
	 	{
	 		setTimeout(timer,1000);
	 	}
	}
	setTimeout(timer,1000);
</script>
</head>
<body>
<div class="page-wrapper">

	<?php 
		require_once "header.php";
		require_once "menu.php";
		require_once "functions.php";
	?>

	<section class="content">
		<div class="middle parentbox">
			<div class="fon">		
				<aside class="personal_aside">
					<nav>
						<ul id="kokoko">							
							<li><a href="account.php"><h3>Личные данные</h3></a></li>
							<li><a href="my_tickets.php"><h3>Мои бронирования</h3></a></li>
						</ul>
					</nav>	
				</aside>		
				<div class="my_tickets">	
					<div class="content">						
<?php

    	$error = "";	
		echo "<h2>Изменение пароля</h2>";	
   		if (isset($_POST['save']) and $_POST['save']==tru`e) 
    	{      
    		$user_id = $_SESSION['user_id'];	

    	    $password_old_in = sanitizeString($_POST['password_old']);
    	    $password = sanitizeString($_POST['password']);
    	    $password_repeat = sanitizeString($_POST['password_repeat']);


    		$query = "SELECT password FROM users WHERE user_id = '$user_id'";   		
    		$result = queryMysql($query);       
    		$row = $result->fetch_array(MYSQLI_ASSOC);                       
            $password_old = $row['password']; 

            if($password_old_in != $password_old)
            {
            	$error = "Неверный пароль.";
            } 
            else
            {
            	if($password != $password_repeat)
            	{
            		$error = "Пароли не совпадают.";
            	}
            	else
            	{
    				$query = "UPDATE users SET password = '$password' WHERE users.user_id = '$user_id'";        		
    				$result = queryMysql($query);       
    				$error = "Пароль успешно изменен.<div>Переход в личный кабинет через <span id='timer_inp'>4</span><span>...</span></div>";   
					header("Refresh: 5; URL=account.php");
    	   	
            	}
            }
            echo<<<_OUT
	
						$error	
_OUT;

       	}
					
		{
echo<<<_OUT
					<form method="POST" action="change_password.php">																		
						<div>
							<input type="password" class="input width_2" name="password_old" placeholder="Старый пароль" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Пароль должен содержать как минимум одну цифру и одну заглавную и строчную букву, и состоять по крайней мере из 8 или более символов." required>						
						</div>
						<div>
							<input type="password" class="input width_2" name="password" placeholder="Новый пароль" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Пароль должен содержать как минимум одну цифру и одну заглавную и строчную букву, и состоять по крайней мере из 8 или более символов." required>						
						</div>
						<div>
							<input type="password" class="input width_2" name="password_repeat" placeholder="Повторите пароль, чтобы не ошибиться" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Пароль должен содержать как минимум одну цифру и одну заглавную и строчную букву, и состоять по крайней мере из 8 или более символов." required>						
						</div>							
						<div class="width_3">
							<input type="hidden" name="save" value="true">
							<input type="submit" class="button" value="Сохранить изменения">							
						</div>	
					</form>			
_OUT;
		}
?>
					</div>				
				</div>				

				<div class="clear"></div>			
			</div>
		</div>
	</section>	


	
<div class="page-buffer"></div>
</div>
	<?php 
		require_once "footer.php";
	?>
</body>
</html>