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
echo<<<_OUT
						<h2>Изменение персональных данных</h2>	
						
_OUT;

   		if (isset($_POST['save']) and $_POST['save']==true) 
    	{      
    		$user_id = $_SESSION['user_id'];
			$first_name = $last_name = $birthday = $document_number = $document_type = $email = $sex = "";	

    	
    	    if(isset($_POST['firstname']))
    	    {
    	    	$firstname = sanitizeString($_POST['firstname']);    	    
    	    	$query  = "UPDATE customers SET first_name = '$firstname' WHERE user_id = '$user_id'";		        	    	    		        	
    	    	$result = queryMysql($query); 
    	    }
    	    if(isset($_POST['lastname']))
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
    	   	if(isset($_POST['sex']))
    	   	{
    	   		$sex = sanitizeString($_POST['sex']);    	    
    	   		$query  = "UPDATE customers SET sex = '$sex' WHERE user_id = '$user_id'";		        	    	    		        			        	    	    		       		
    	   		$result = queryMysql($query); 
    	   	}
    	   	if(isset($_POST['document_type']))
    	   	{
    	   		$document_type = sanitizeString($_POST['document_type']); 
    	   		$query  = "UPDATE customers SET document_type = '$document_type' WHERE user_id = '$user_id'";		        	    	    		        			        	    	    		       		   	    		        	    	    		       		
    	   		$result = queryMysql($query); 
    	   	}
    	   	if(isset($_POST['document_number']))
    	   	{
    	   		$document_number = sanitizeString($_POST['document_number']);    	    		        	
    	   		$query  = "UPDATE customers SET document_number = '$document_number' WHERE user_id = '$user_id'";		        	    	    		        	    	    		       	
    	   		$result = queryMysql($query); 
    	   	}   
    	   	if(isset($_POST['email']))
    	   	{
    	   		$email = sanitizeString($_POST['email']);    	    		        	
    	   		$query  = "UPDATE users SET email = '$email' WHERE user_id = '$user_id'";		        	    	    		        	    	    		       	
    	   		$result = queryMysql($query); 
    	   	}   	    		   
	    		
    	   	$error = "Данные успешно изменены.<div>Переход в личный кабинет через <span id='timer_inp'>4</span><span>...</span></div>";   
    	   	header("Refresh: 5; URL=account.php");
    	   	//header('Location: ' . "account.php?change_information=true");        	   	
echo<<<_OUT
	
						$error	
_OUT;
    	   	
    	}
    	 
    	{


						$user_id = $_SESSION['user_id'];
						$first_name = $last_name = $birthday = $document_number = $document_type = $email = $sex = "";						

						$query = "SELECT customers.*, users.email FROM customers, users WHERE users.user_id = customers.user_id AND users.user_id = '$user_id'";
						$result = queryMysql($query);
						$num = $result->num_rows;
						$row = $result->fetch_array(MYSQLI_ASSOC);      						
						
						$first_name= $row['first_name'];
						$last_name= $row['last_name'];
						$birthday= $row['birthday'];
						$sex= $row['sex'];
						$document_type= $row['document_type'];
						$document_number = $row['document_number'];
						$email = $row['email'];

echo<<<_OUT
					<form method="POST" action="change_information.php">						
						<h3>Личные данные</h3>	
						<div>
							<input type="text" class="input width_2" name="firstname" value="$first_name" placeholder="Имя" pattern="[a-zA_Zа-яА-ЯёЁ0-9._-]{1,}" title="Сдержать символы из нижнего или верхнего регистра, цифры, символы '_', '.', '-'">														
						</div>
						<div>
							<input type="text" class="input width_2" name="lastname" value="$last_name" placeholder="Фамилия" pattern="[a-zA_Zа-яА-ЯёЁ0-9._-]{1,}" title="Сдержать символы из нижнего или верхнего регистра, цифры, символы '_', '.', '-'">                           	
						</div>
						<div>
							<div>
								<select class="input width_3" name="sex" >
									<option value="мужской">мужской</option>
									<option value="женский">женский</option>							
								</select> 
							</div>
						<div>
							<input type="date" class="input width_2" name="birthday" value="$birthday" placeholder="Дата рождения">							
						</div>					
						<h3>Документы</h3>	
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
						<h3>Контакты</h3>	
						<div>
							<input type="email" class="input width_2" name="email" value="$email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Email должен быть в формате characters@characters.domain">												
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