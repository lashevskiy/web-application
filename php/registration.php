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
	?>

	<?php

		$error = $username = $password = $password_repeat = "";
		$firstname = $lastname = $birthday = $document_number = $email = $sex = "";
    
    	if (isset($_POST['username']) and isset($_POST['password']) and isset($_POST['email']) and isset($_POST['password_repeat']) and !empty($_POST['username']) and !empty($_POST['password']) and !empty($_POST['email']) and !empty($_POST['password_repeat'])) 
    	{      
    		$username = $password = $password_repeat = $email = $firstname = $lastname  = $document_type = $document_number = $sex = "";
    		$birthday = '2015-05-05';

    	    $username = sanitizeString($_POST['username']);
    	    $password = sanitizeString($_POST['password']);
    	    $password_repeat = sanitizeString($_POST['password_repeat']);
    	    $email = sanitizeString($_POST['email']);
    	    $firstname = sanitizeString($_POST['firstname']);
    	    $lastname = sanitizeString($_POST['lastname']);
    	    $birthday = sanitizeString($_POST['birthday']);
    	    $document_type = sanitizeString($_POST['document_type']);
    	    $document_number = sanitizeString($_POST['document_number']);
    	    $sex = sanitizeString($_POST['sex']);
	
    		$query = "SELECT username,password FROM users WHERE username='$username'";
    	   	$result = queryMysql($query);        
    	   	$num = $result->num_rows;    	   	

    	   	if($num == 0)
    	   	{
    	    	if($password_repeat != $password)
    	    	{
    	    		$error = "<span>Пароли не совпадают.</span>";    	    	
    	    	}
    	    	else
    	    	{
    	    		if ($username == "" || $password == "")
    	    		    $error = "Not all fields were entered<br>";
    	    		else
    	    		{
    	    		    //$token = md5($password);
    	    		    $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    	    		    $result = queryMysql($query);    	        
    	    		    	
    	    		    if ($result == 0)
    	    		    {
    	    		        $error = "<span>Неверный логин/пароль</span>";
    	    		    }
    	    		    else
    	    		    {             
    	    		    	$result = queryMysql("SELECT user_id FROM users WHERE username='$username'");
            				$num    = $result->num_rows;   
            				$row = $result->fetch_array(MYSQLI_ASSOC);                       
                			$user_id = $row['user_id'];  



    	    		        $_SESSION['password'] = $password;
    	    		        $_SESSION['username'] = $username;    
    	    		        $_SESSION['user_id'] = $user_id;   

    	    		        $query = "INSERT INTO customers (user_id, first_name, last_name, birthday, sex, document_type, document_number) VALUES ( '$user_id', '$firstname', '$lastname', '$birthday', '$sex', '$document_type', '$document_number')";
    	    		        $result = queryMysql($query);   	    		        	  	    		    	    	    		    	
    	    		        header('Location: index.php');  	                	    		   		
    	    		    }
    	    		}
    			}
    		}
    		else
    		{
    			$error = "<span>Пользователем с таким логином существует.</span>";    	    	
    		}
    	}

echo<<<_END
	<section class="content">
		<div class="middle parentbox">			
			<div class="fon inline_block">	
				<div class="registration_block">
					<h2>Регистрация пользователя</h2>   									
					<form method="POST" action="registration.php">$error
						<h3>Доступ в личный кабинет</h3>
						<div>
							<input type="text" class="input width_2" name="username" value="$username" placeholder="Логин" required>							
						</div>
						<div>
							<input type="email" class="input width_2" name="email" value="$email" placeholder="Email" required>							
						</div>						
						<div>
							<input type="password" class="input width_2" name="password" placeholder="Пароль" required>						
						</div>
						<div>
							<input type="password" class="input width_2" name="password_repeat" placeholder="Повторите пароль" required>						
						</div>					
						<h3>Личные данные</h3>	
						<div>
							<input type="text" class="input width_2" name="firstname" value="$firstname" placeholder="Имя" required>							
						</div>
						<div>
							<input type="text" class="input width_2" name="lastname" value="$lastname" placeholder="Фамилия" required>							
						</div>
						<div>
								<select class="input width_3" name="sex" required>
									<option value="мужской">мужской</option>
									<option value="женский">женский</option>							
								</select> 
							</div>
						<div>
							<input type="date" class="input width_2" name="birthday" value="$birthday" placeholder="Дата рождения" required>							
						</div>					
						<div>
							<select class="input width_3" name="document_type" required>
								<option value="Паспорт">Паспорт</option>
								<option value="Загран паспорт">Загран паспорт</option>													
								<option value="Другой документ">Другой документ</option>
							</select>
						</div>	
						<div class="right">
							<input type="number" class="input width_2" name="document_number" value="$document_number" placeholder="Номер документа" required>							
						</div>										
						<div class="width_3">
							<input type="submit" class="button" value="Зарегистрироваться">							
						</div>				
					</form>
				</div>
		    </div>		    
		</div>
	</section>
_END;
?>

<div class="page-buffer"></div>
</div>
	<?php 
		require_once "footer.php";
	?>
</body>
</html>