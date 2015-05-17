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
</head>
<body>
<div class="page-wrapper">

	<?php 
		require_once "header.php";
		require_once "menu.php";
		require_once "functions.php";
	?>

	<section class="content">
		<div class="middle">
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

					$user_id = $_SESSION['user_id'];
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
						<h2>Личные данные</h2>								
						<h3>Персональные данные<div class="change"><a href="change_information.php">(изменить)</a></div></h3>	
						<fieldset>
							<div><div class="field">Имя:</div><span>$first_name</span></div>
							<div><div class="field">Фамилия:</div><span>$last_name</span></div>
							<div><div class="field">Дата рождения:</div><span>$birthday</span></div>
							<div><div class="field">Пол:</div><span>$sex</span></div>
						</fieldset>
						<h3>Документы<div class="change"><a href="change_information.php">(изменить)</a></div></h3>	
						<fieldset>							
							<div><div class="field">Тип документа:</div><span>$document_type</span></div>
							<div><div class="field">Номер документа:</div><span>$document_number</span></div>							
						</fieldset>
						<h3>Контакты<div class="change"><a href="change_information.php">(изменить)</a></div></h3>	
						<fieldset>
							<div><div class="field">Email:</div><span>$email</span></div>		
						</fieldset>
						<h3>Изменение пароля<div class="change"><a href="change_password.php">(изменить)</a></div></h3>		
_OUT;
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