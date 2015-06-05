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

		if(isset($_POST['flight_number']) and !isset($_POST['insert_tickets']))
		{	
			$direction = sanitizeString($_POST['direction']);
			$count_peolpe = sanitizeString($_POST['count_peolpe']);							
			$class = sanitizeString($_POST['class']);
			
			

			echo<<<_END
		 	<section class="content">
		 		<div class="middle">
					<div class="fon">								
						<div class="buy_form margin_bottom">
							<fieldset class="flights_table">
								<legend>Информация о рейсе</legend>
								<table class="select_flight">
									<tr>
										<th>Рейс</th>
										<th>Дата рейса</th>
										<th>Откуда</th>
										<th>Куда</th>
										<th>Вылет</th>
					    		    	<th>Прилет</th>					    		    	
					    		    	<th>В пути</th>
					    		    	<th>Класс</th>
					    		    	<th>Цена</th>					    		    	
				    				</tr>
				    						    				
_END;

									
								$flight_number = $_POST['flight_number'];				
								$flight_date = $_POST['flight_date'];
								for ($i=0; $i < count($flight_number); $i++) { 
									$flight_number[$i] = sanitizeString($flight_number[$i]);
								}	
								for ($i=0; $i < count($flight_date); $i++) { 
									$flight_date[$i] = sanitizeString($flight_date[$i]);
								}	
								
								for ($i=0; $i < $direction; $i++) 
								{ 					

									$query  = "SELECT DISTINCT flights.flight_from, flights.flight_to, flights.flight_from_code, flights.flight_to_code, IF(schedule.time_up IS NULL, flights.time_up, schedule.time_up) AS time_up, IF(schedule.time_down IS NULL, flights.time_down, schedule.time_down) AS time_down, flights.time_flight, flights.airplane_type, IF(schedule.price_economy IS NULL, flights.price_economy, schedule.price_economy) AS price_economy, IF(schedule.price_standard IS NULL, flights.price_standard, schedule.price_standard) AS price_standard, IF(schedule.price_business IS NULL, flights.price_business, schedule.price_business) AS price_business FROM flights, schedule WHERE flights.flight_number = schedule.flight_number AND schedule.flight_date = '$flight_date[$i]' AND flights.flight_number = '$flight_number[$i]'";
									$result = queryMysql($query);
   									$num    = $result->num_rows;   
   													
									for ($j = 0 ; $j < $num ; ++$j)
									{		
										$row = $result->fetch_array(MYSQLI_ASSOC);
						
										$flight_from[$i] = $row['flight_from'];  						
										$flight_to[$i] = $row['flight_to'];						
										$time_up[$i] = $row['time_up'];
										$time_down[$i] = $row['time_down'];
										$time_flight[$i] = $row['time_flight'];
										$price_economy[$i] = $row['price_economy'];
										$price_standard[$i] = $row['price_standard'];
										$price_business[$i] = $row['price_business']; 
									}		
						
									if($class == 'price_economy')
									{
										$price[$i] = $price_economy[$i];
										$flight_class[$i] = "Эконом";
									}
									else if($class == 'price_standard')
									{
										$price[$i] = $price_standard[$i];
										$flight_class[$i] = "Стандарт";
									}
									else 
									{
										$price[$i] = $price_business[$i];
										$flight_class[$i] = "Бизнес";
									}	

									echo <<<_LO
									<tr>
				    					<td>$flight_number[$i]</th>
				    					<td>$flight_date[$i]</th>
										<td>$flight_from[$i]</th>
					    		    	<td>$flight_to[$i]</td>
					    		    	<td>$time_up[$i]</td>
					    		    	<td>$time_down[$i]</td>
					    		    	<td>$time_flight[$i]</td>
					    		    	<td>$flight_class[$i]</td>
					    		    	<td>$price[$i]</td>					    		    	
				    				</tr>	
_LO;
									
								}

								echo<<<_END
				    			</table>								
							</fieldset>										
						</div>			
				
						<div class="buy_form parentbox margin_bottom">
							<form method="POST" action="buy_tickets.php">
								<input type="hidden" name="direction" value="$direction">
								<input type="hidden" name="count_peolpe" value="$count_peolpe">
								<input type="hidden" name="class" value="$class">
								
								

_END;
								for ($i=0; $i < $direction; $i++) 
								{
									$j = $i;
									echo<<<_END
									<input type="hidden" name="flight_date[$j]" value="$flight_date[$j]">
									<input type="hidden" name="flight_number[$j]" value="$flight_number[$j]">
									<input type="hidden" name="price[$j]" value="$price[$j]">								

									<input type="hidden" name="flight_from[$j]" value="$flight_from[$j]">
									<input type="hidden" name="flight_to[$j]" value="$flight_to[$j]">
									<input type="hidden" name="time_up[$j]" value="$time_up[$j]">
									<input type="hidden" name="time_down[$j]" value="$time_down[$j]">
									<input type="hidden" name="time_flight[$j]" value="$time_flight[$j]">
_END;
								}

			$document_type = array($count_peolpe);
			$document_number = array($count_peolpe);
			$firstname = array($count_peolpe);
			$lastname = array($count_peolpe);
			$sex = array($count_peolpe);
			$birthday = array($count_peolpe);

			for($i=0; $i < $count_peolpe; $i++)
			{
				$firstname[$i] = $lastname[$i] = $birthday[$i] = $document_number[$i] = "";						

				if($i==0)
				{
					$user_id = $_SESSION['user_id'];
					
					$query = "SELECT * FROM customers WHERE user_id = '$user_id'";
					$result = queryMysql($query);
					$num = $result->num_rows;
					$row = $result->fetch_array(MYSQLI_ASSOC);      						
					
					$firstname[$i]= $row['first_name'];
					$lastname[$i]= $row['last_name'];
					$birthday[$i]= $row['birthday'];										
					$document_number[$i] = $row['document_number'];					
				}


				$j = $i+1;
				echo<<<_END
				<div class="">	
					<fieldset>
  						<legend>Данные пассажира $j</legend>
						<div class="inline_block">
							<h3>Имя</h3>
							<input type="text" class="input width_1" name="firstname[$i]" value="$firstname[$i]" placeholder="Имя" autocomplete="off" required>							
						</div>		
						<div class="margin inline_block"></div>
						<div class="inline_block">
							<h3>Тип документа</h3>	
							<div class="select_class">	
								<select class="input" name="document_type[$i]" required>
									<option value="Паспорт РФ">Паспорт РФ</option>
									<option value="Загранпаспорт РФ">Загранпаспорт РФ</option>
									<option value="Свидетельство о рождении">Свидетельство о рождении</option>
									<option value="Другой документ">Другой документ</option>
								</select> 
							</div>
						</div>								
						<div class="clear_both"></div>			
						<div class="inline_block">
							<h3>Фамилия</h3>
							<input type="text" class="input width_1" name="lastname[$i]" value="$lastname[$i]" placeholder="Фамилия" autocomplete="off" onkeyup='checkValue()' required>												
						</div>
						<div class="margin inline_block"></div>
						<div class="inline_block">
							<h3>Номер документа</h3>
							<input type="number" class="input width_1" name="document_number[$i]" value="$document_number[$i]" placeholder="Номер документа" autocomplete="off" onkeyup='checkValue()' required>												
						</div>
						<div class="clear_both"></div>	
						<div class="date_from inline_block">
							<h3>Дата рождения</h3>
							<input type="date" name="birthday[$i]" value="$birthday[$i]" class="input width_1" id="date_from" required>
						</div>
						<div class="margin inline_block"></div>
						<div class="inline_block">
							<h3>Пол</h3>	
							<div class="select_class">
								<select class="input" name="sex[$i]" required>
									<option value="мужской">мужской</option>
									<option value="женский">женский</option>							
								</select> 
							</div>
						</div>			
					</fieldset>										
				</div>	
_END;
			}	
			echo '
													
						</div>
						<div>
							<input type="submit" class="button margin_top" value="Забронировать билеты">
							<input type="hidden" name="insert_tickets" value="true">
						</div>						
					</form>
				</div>
			</section>
			';


		}


	if(isset($_POST['insert_tickets']) and $_POST['insert_tickets'] == true)
	{

echo<<<_END
	<section class="content">
		<div class="middle ">
			<div class="fon parentbox">
_END;

		$purchase_date = date("Y-m-d");		
		$direction = sanitizeString($_POST['direction']);
		$count_peolpe = sanitizeString($_POST['count_peolpe']);							
		$class = sanitizeString($_POST['class']);
		
		$flight_date = $_POST['flight_date'];			
		$flight_number = $_POST['flight_number'];
		$price = $_POST['price'];
		$flight_from = $_POST['flight_from'];		
		$flight_to = $_POST['flight_to'];
		$time_up = $_POST['time_up'];
		$time_down = $_POST['time_down'];
		$time_flight = $_POST['time_flight'];
					
		$firstname = $_POST['firstname'];	
		$lastname = $_POST['lastname'];	
		$birthday = $_POST['birthday'];	
		$sex = $_POST['sex'];	
		$document_type = $_POST['document_type'];	
		$document_number = $_POST['document_number'];


		for ($i=0; $i < count($flight_date); $i++) { 
			$flight_date[$i] = sanitizeString($flight_date[$i]);
		}			
		for ($i=0; $i < count($flight_number); $i++) { 
			$flight_number[$i] = sanitizeString($flight_number[$i]);
		}
		for ($i=0; $i < count($flight_from); $i++) { 
			$flight_from[$i] = sanitizeString($flight_from[$i]);
		}
		for ($i=0; $i < count($flight_to); $i++) { 
			$flight_to[$i] = sanitizeString($flight_to[$i]);
		}
		for ($i=0; $i < count($time_up); $i++) { 
			$time_up[$i] = sanitizeString($time_up[$i]);
		}
		for ($i=0; $i < count($time_down); $i++) { 
			$time_down[$i] = sanitizeString($time_down[$i]);
		}
		for ($i=0; $i < count($time_flight); $i++) { 
			$time_flight[$i] = sanitizeString($time_flight[$i]);
		}
		for ($i=0; $i < count($firstname); $i++) { 
			$firstname[$i] = sanitizeString($firstname[$i]);
		}
		for ($i=0; $i < count($lastname); $i++) { 
			$lastname[$i] = sanitizeString($lastname[$i]);
		}
		for ($i=0; $i < count($birthday); $i++) { 
			$birthday[$i] = sanitizeString($birthday[$i]);
		}
		for ($i=0; $i < count($sex); $i++) { 
			$sex[$i] = sanitizeString($sex[$i]);
		}
		for ($i=0; $i < count($document_type); $i++) { 
			$document_type[$i] = sanitizeString($document_type[$i]);
		}
		for ($i=0; $i < count($document_number); $i++) { 
			$document_number[$i] = sanitizeString($document_number[$i]);
		}
		for ($i=0; $i < count($price); $i++) { 
			$price[$i] = sanitizeString($price[$i]);
		}

		if($class == 'price_economy')
			$class = "Эконом";
		else if($class == 'price_standard')			
			$class = "Стандарт";		
		else $class = "Бизнес";
	

		$user_id = $_SESSION['user_id'];

		for ($i=0; $i < $direction ; $i++) 
		{ 
			for ($j=0; $j < $count_peolpe; $j++) 
			{ 							
				$query = "INSERT INTO tickets (
									user_id,									
									purchase_date, 
									flight_number, 
									flight_date, 
									time_up, 
									time_down, 
									time_flight,
									class, 
									price, 
									first_name, 
									last_name,
									birthday, 
									sex, 
									document_type, 
									document_number
							)
								VALUES 
							(		
								'$user_id',
								'$purchase_date', 
								'$flight_number[$i]', 
								'$flight_date[$i]', 
								'$time_up[$i]', 
								'$time_down[$i]', 
								'$time_flight[$i]',
								'$class', 
								'$price[$i]', 
								'$firstname[$j]', 
								'$lastname[$j]', 
								'$birthday[$j]', 
								'$sex[$j]', 
								'$document_type[$j]', 
								'$document_number[$j]'
							)";
	
				$result = queryMysql($query);		
				$query = "UPDATE flights SET popular = popular + 1 WHERE flight_number = '$flight_number[$i]'";	
				$result = queryMysql($query);		
	   		}
	   	}

	   	header("Refresh: 5; URL=my_tickets.php");
      	    		   		
echo<<<_OUT
		<div>
			<span>Билеты забронированы.</span>
			<span>Переход в личный кабинет через </span>
			<span id="timer_inp">4</span>
			<span>...</span>
		</div>
	   		


<div class="clear"></div>

			</div>
		</div>
	</section>
_OUT;
	}
?>





<div class="page-buffer"></div>
</div>
	<?php 
		require_once "footer.php";
	?>
</body>
</html>