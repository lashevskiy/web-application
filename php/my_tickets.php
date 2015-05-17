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


		if(isset($_GET['flight_date']))
		{		
			$flight_date = $_GET['flight_date'];	
			
			$user_id = $_SESSION['username'];
			//$query = "SELECT * FROM tickets WHERE user_id = (SELECT user_id FROM users WHERE username='$username')";	
			//$result = queryMysql($query);					
			//$num = $result->num_rows;
		}
		else
		{				
			$flight_date[1] = new DateTime(date("Y-m-d"));						
			$flight_date[1] = $flight_date[1]->format("Y-m-d");

			$flight_date[0] = new DateTime(date("Y-m-d"));
			$flight_date[0]->modify("-1 month");
			$flight_date[0] = $flight_date[0]->format("Y-m-d");
		}

echo<<<_END
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
						<form method="get" action="my_tickets.php">
							<h2>Мои бронирования в период</h2>
							<span>c</span>
							<input type="date" name="flight_date[0]" class="input width_0" value="$flight_date[0]" required>						
							<span>по</span>
							<input type="date" name="flight_date[1]" class="input width_0" 	value="$flight_date[1]" required>
							<input type="submit" class="button2" value="Показать">							
						</form>
					</div>				
				</div>				
				<div class="clear"></div>			
_END;
		if(isset($_GET['flight_date']))
		{		
			$flight_date = $_GET['flight_date'];	
			
			//$username = $_SESSION['username'];			
			//user_id = (SELECT user_id FROM users WHERE username='$username')
			$user_id = $_SESSION['user_id'];			

			$query = "SELECT tickets.*, flights.flight_from, flights.flight_to FROM tickets, flights WHERE (tickets.purchase_date BETWEEN '$flight_date[0]' AND '$flight_date[1]') AND user_id = '$user_id' AND flights.flight_number = tickets.flight_number";	
			$result = queryMysql($query);					
			$num = $result->num_rows;

			if ($num != 0) 
			{
				echo<<<_END
				<table class="table">
					<tr>						
			     		<th>Дата брони</th>
				 		<th>Номер</th>
				 		<th>Инофрмация о рейсе</th>				 						 						 		   					    
					    <th>Пассажир</th>					    
					    <th>Стоимость</th>			
				    </tr>	
_END;
				
				for ($i=0; $i < $num; $i++) 
				{
					$row = $result->fetch_array(MYSQLI_ASSOC);      						
					$ticket_number  = $row['ticket_number'];			
					$purchase_date= $row['purchase_date'];
					$flight_number= $row['flight_number'];
					$flight_date= $row['flight_date'];
					$time_up= $row['time_up'];
					$time_down= $row['time_down'];
					$time_flight= $row['time_flight'];
					$class= $row['class'];
					$price= $row['price'];
					$first_name= $row['first_name'];
					$last_name= $row['last_name'];
					$birthday= $row['birthday'];
					$sex= $row['sex'];
					$document_type= $row['document_type'];
					$document_number = $row['document_number'];

					$flight_from = $row['flight_from'];
					$flight_to = $row['flight_to'];

					echo<<<_OUT
					<tr>
						<td>$purchase_date</td>
						<td>$ticket_number</td>
						<td>
							<div><span>Номер: </span>$flight_number</div>
							<div><span>Дата: </span>$flight_date</div>
							<div><span>Откуда: </span>$flight_from</div>
							<div><span>Куда: </span>$flight_to</div>
							<div><span>Вылет: </span>$time_up</div>
							<div><span>Прилет: </span>$time_down</div>
							<div><span>В пути: </span>$time_flight</div>
						</td>					
						<td>
							<div><span>Имя: </span>$first_name</div>
							<div><span>Фамилия: </span>$last_name</div>
							<div><span>Дата рождения: </span>$birthday</div>
							<div><span>Пол: </span>$sex</div>							
							<div><span>Документ: </span>$document_type</div>
							<div><span>Номер документа: </span>$document_number</div>
						</td>
						<td>
							<div><span>Цена: </span>$price руб</div>
							<div><span>Класс: </span>$class</div>
						</td>
					</tr>
_OUT;
				}

				echo "</table>";		
			}
			else 
			{
				echo '
    				<div class="mg_top found_form center">За указанный период бронирований не было найдено.</div>
    			';	   
			}
		}

	?>

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