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
    <script type="text/javascript">     
    function crypt_pass(forma) {             
        document.getElementById('password').value=md5(md5(document.getElementById('password').value));               
        document.getElementById('password_repeat').value=md5(md5(document.getElementById('password_repeat').value));                               
    }  
    </script>	
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

    	    $username = sanitizeString($_POST['username']);
    	    $password = sanitizeString($_POST['password']);
    	    $password_repeat = sanitizeString($_POST['password_repeat']);
    	    $email = sanitizeString($_POST['email']);    
   	    	if(isset($_POST['firstname']) and !empty($_POST['firstname']))
    	    {
    	    	$firstname = sanitizeString($_POST['firstname']);    	    	    	
    	    }
    	    if(isset($_POST['lastname']) and !empty($_POST['lastname']))
    	    {
    	    	$lastname = sanitizeString($_POST['lastname']);    	    	
    	    }
    	    if(isset($_POST['birthday']) and !empty($_POST['birthday']))
    	    {
    	    	$birthday = sanitizeString($_POST['birthday']);    	    		        	    	    		       		
    	    }
    	    if(isset($_POST['sex']) and !empty($_POST['sex']))
    	    {
    	    	$sex = sanitizeString($_POST['sex']);    	    
    	    }
    	    if(isset($_POST['document_type']) and !empty($_POST['document_type']))
    	    {
    	    	$document_type = sanitizeString($_POST['document_type']); 
    	    }
    	    if(isset($_POST['document_number']) and !empty($_POST['document_number']))
    	    {
    	    	$document_number = sanitizeString($_POST['document_number']);    	    		        	
    	    }   	    		 



	
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


                			$query = "INSERT INTO customers (user_id) VALUES ( '$user_id')";
    	    		        $result = queryMysql($query); 

    	    		        $_SESSION['password'] = $password;
    	    		        $_SESSION['username'] = $username;    
    	    		        $_SESSION['user_id'] = $user_id;   
				

    	    		        if(isset($_POST['firstname']) and !empty($_POST['firstname']))
    	    		        {
    	    		        	$firstname = sanitizeString($_POST['firstname']);    	    
    	    		        	$query  = "UPDATE customers SET first_name = '$firstname' WHERE user_id = '$user_id'";		        	    	    		        	
    	    		        	$result = queryMysql($query); 
    	    		        }
    	    		        if(isset($_POST['lastname']) and !empty($_POST['lastname']))
    	    		        {
    	    		        	$lastname = sanitizeString($_POST['lastname']);    		        	    	    		        	
    	    		        	$query  = "UPDATE customers SET last_name = '$lastname' WHERE user_id = '$user_id'";		        	    	    		        	
    	    		        	$result = queryMysql($query); 
    	    		        }
    	    		       	if(isset($_POST['birthday']) and !empty($_POST['birthday']))
    	    		       	{
    	    		       		$birthday = sanitizeString($_POST['birthday']);    	    		        	    	    		       		
    	    		       		$query  = "UPDATE customers SET birthday = '$birthday' WHERE user_id = '$user_id'";		        	    	    		        	
    	    		       		$result = queryMysql($query); 
    	    		       	}
    	    		       	if(isset($_POST['sex']) and !empty($_POST['sex']))
    	    		       	{
    	    		       		$sex = sanitizeString($_POST['sex']);    	    
    	    		       		$query  = "UPDATE customers SET sex = '$sex' WHERE user_id = '$user_id'";		        	    	    		        			        	    	    		       		
    	    		       		$result = queryMysql($query); 
    	    		       	}
    	    		       	if(isset($_POST['document_type']) and !empty($_POST['document_type']))
    	    		       	{
    	    		       		$document_type = sanitizeString($_POST['document_type']); 
    	    		       		$query  = "UPDATE customers SET document_type = '$document_type' WHERE user_id = '$user_id'";		        	    	    		        			        	    	    		       		   	    		        	    	    		       		
    	    		       		$result = queryMysql($query); 
    	    		       	}
    	    		       	if(isset($_POST['document_number']) and !empty($_POST['document_number']))
    	    		       	{
    	    		       		$document_number = sanitizeString($_POST['document_number']);    	    		        	
    	    		       		$query  = "UPDATE customers SET document_number = '$document_number' WHERE user_id = '$user_id'";		        	    	    		        	    	    		       	
    	    		       		$result = queryMysql($query); 
    	    		       	}   	    		   
    	    		        	    		        	  	    		    	    	    		    	
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
					<form method="POST" action="registration.php" onsubmit="crypt_pass(this)">$error
						<h3>Доступ в личный кабинет</h3>
						<div>
							<input type="text" class="input width_2" name="username" value="$username" placeholder="Логин" required pattern="[a-zA_Z0-9._]{5,}" title="Не менее 5 символов, содержащих символы из нижнего или верхнего регистра, цифры и символы '_', '.'">							
						</div>
						<div>
							<input type="email" class="input width_2" name="email" value="$email" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Email должен быть в формате characters@characters.domain">							
						
						<div>
							<input type="password" class="input width_2" name="password" id="password" placeholder="Пароль" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Не менее восьми символов, содержащих хотя бы одну цифру и символы из верхнего и нижнего регистра." required>						
						</div>                                                                                
						<div>
							<input type="password" class="input width_2" name="password_repeat" id="password_repeat" placeholder="Повторите пароль" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Не менее восьми символов, содержащих хотя бы одну цифру и символы из верхнего и нижнего регистра." required>                     
						</div>					
						<h3>Личные данные (опционально)</h3>	
						<div>
							<input type="text" class="input width_2" name="firstname" value="$firstname" placeholder="Имя" pattern="[a-zA_Zа-яА-ЯёЁ0-9._-]{1,}" title="Сдержать символы из нижнего или верхнего регистра, цифры, символы '_', '.', '-'">							
						</div>
						<div>
							<input type="text" class="input width_2" name="lastname" value="$lastname" placeholder="Фамилия" pattern="[a-zA_Zа-яА-ЯёЁ0-9._-]{1,}" title="Сдержать символы из нижнего или верхнего регистра, цифры, символы '_', '.', '-'">                           
						</div>
						<div>
								<select class="input width_3" name="sex">
									<option value="мужской">мужской</option>
									<option value="женский">женский</option>							
								</select> 
							</div>
						<div>
							<input type="date" class="input width_2" name="birthday" value="$birthday" placeholder="Дата рождения">							
						</div>					
						<div>
							<select class="input width_3" name="document_type">
								<option value="Паспорт">Паспорт</option>
								<option value="Загран паспорт">Загран паспорт</option>													
								<option value="Другой документ">Другой документ</option>
							</select>
						</div>	
						<div class="right">
							<input type="text" class="input width_2" name="document_number" value="$document_number" placeholder="Номер документа" pattern="[0-9]{1,}" title="Сдержать цифры без пробелов">                           
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