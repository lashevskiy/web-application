<!DOCTYPE html>
<html>
<head>
	<title>Airlife</title>
	<meta charset="UTF-8"> 
	<link rel="shortcut icon" type="image/x-icon" href="/MySite/images/icon.png">
	<link rel="stylesheet" type="text/css" href="/MySite/style.css" media="all">
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
	session_start();
	require_once "header.php";	
	require_once "menu.php";
	require_once "functions.php";


	if(isset($_GET['flight_number']))
	{

echo<<<_END
	<section class="content">
		<div class="middle ">
			<div class="fon parentbox">
_END;

		$purchase_date = date("Y-m-d");		
		$direction = $_GET['direction'];
		$count_peolpe = $_GET['count_peolpe'];	
		$class = $_GET['class'];
		
		$flight_date = $_GET['flight_date'];			
		$flight_number = $_GET['flight_number'];
		$price = $_GET['price'];
		$flight_from = $_GET['flight_from'];		
		$flight_to = $_GET['flight_to'];
		$time_up = $_GET['time_up'];
		$time_down = $_GET['time_down'];
		$time_flight = $_GET['time_flight'];
					
		$firstname = $_GET['firstname'];	
		$lastname = $_GET['lastname'];	
		$birthday = $_GET['birthday'];	
		$sex = $_GET['sex'];	
		$document_type = $_GET['document_type'];	
		$document_number = $_GET['document_number'];	



//		echo<<<_END
//			<div>$direction</div>
//			<div>$count_peolpe</div>
//			<div>$class</div>
//			<br>
//_END;
//		for ($i=0; $i < $direction; $i++) 
//		{ 	
//			echo<<<_END
//			<div>$flight_date[$i]</div>
//			<div>$flight_number[$i]</div>
//			<div>$price[$i]</div>
//			<div>$flight_from[$i]</div>
//			<div>$flight_to[$i]</div>
//			<div>$time_up[$i]</div>
//			<div>$time_down[$i]</div>
//			<div>$time_flight[$i]</div>
//			<br>
//_END;
//		}
//
//		for($i=0; $i<$count_peolpe; $i++)
//		{
//			echo<<<_END
//			<div>$firstname[$i]</div>
//			<div>$lastname[$i]</div>
//			<div>$birthday[$i]</div>
//			<div>$sex[$i]</div>
//			<div>$document_type[$i]</div>
//			<div>$document_number[$i]</div>
//			<br>
//_END;
//		}

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

	   	header("Refresh: 8; URL=/MySite/my_tickets.php?flight_date%5B0%5D=$purchase_date&flight_date%5B1%5D=$purchase_date");
	   	//header("Location: /MySite/my_tickets.php?flight_date%5B0%5D=$purchase_date&flight_date%5B1%5D=$purchase_date");  	       	    		   		
		
	}
?>
		<div>
			<span>Билеты забронированы.</span>
			<span>Переход в личный кабинет через </span>
			<span id="timer_inp">7</span>
			<span>...</span>
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