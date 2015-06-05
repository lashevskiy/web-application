<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Airlife</title>
	<meta charset="UTF-8"> 
	<link rel="shortcut icon" type="image/x-icon" href="../images/icon.png">
	<link rel="stylesheet" type="text/css" href="../css/style.css" media="all">		
	<script src="../javascript/jquery-1.11.3.min.js"></script>
	<script type="text/javascript">		

		$(document).ready(function(){
		    $("#one").click(function(){
		        $("#date_to_id").hide();
		    });
		    $("#two").click(function(){
		        $("#date_to_id").show();
		    });
		}); 


		$(document).ready(function(){
		    $("#select_destination").click(function(){
		        $("#destination_block").hide();		        
		        $("#number_block").show();
		        $("#delete_id").prop("disabled", false);
		        $("#change_id").prop("disabled", false);		        
		        $("#found_form_id").html("");
		        

		    });
		    $("#select_number").click(function(){
		        $("#number_block").hide();
		        $("#destination_block").show();
		        $("#delete_id").prop("disabled", true);
		        $("#change_id").prop("disabled", true);
		        $(".msg").html("");		        
		        
		    });
		});       

		function swap() {
	    	var flight_from = document.getElementById("flight_from_id");
	    	var flight_to = document.getElementById("flight_to_id");	    	
	    	var temp = flight_from.value;
	      	flight_from.value = flight_to.value;
	      	flight_to.value = temp;
	    }

	    function Date_toYMD(d)
		{
		    var year, month, day;
		    year = String(d.getFullYear());
		    month = String(d.getMonth() + 1);
		    if (month.length == 1) {
		        month = "0" + month;
		    }
		    day = String(d.getDate());
		    if (day.length == 1) {
		        day = "0" + day;
		    }
		    return year + "-" + month + "-" + day;
		}
	    function setDate()
	    {		    	
	    	var str = Date_toYMD(new Date());			
	    	document.getElementById("date_from").value=str;
	    	document.getElementById("date_from").min=str;
	    	document.getElementById("date_to").value=str;
	    	document.getElementById("date_to").min=str;
	    }

	   

		function checkValue() 
		{
			var inputs = document.querySelectorAll('input[list]');
			for (var i = 0; i < inputs.length; i++) {
			  // Когда значение input изменяется…
			  inputs[i].addEventListener('change', function() {
			    var optionFound = false,
			      datalist = this.list;
			    // Определение, существует ли option с текущим значением input.
			    for (var j = 0; j < datalist.options.length; j++) {
			        if (this.value == datalist.options[j].value) {
			            optionFound = true;
			            break;
			        }
			    }
			    // используйте функцию setCustomValidity API проверки ограничений валидации
			    // чтобы обеспечить ответ пользователю, если нужное значение в datalist отсутствует
			    if (optionFound) {
			      this.setCustomValidity('');
			    } else {
			      this.setCustomValidity('Выберите значение из списка.');
			    }
			  });
			}	
		}

		function ckeck()
		{
			
			var i,j,o,ok;
    		o=document.getElementsByName("flight_number[0]");    		
			ok=false;			
			for(j=0; j<o.length; j++)
			{
				if (o[j].checked) 
				{						
					ok=true; 
					break;
			    }
			}

			var i2,j2,o2,ok2;
    		o2=document.getElementsByName("flight_number[1]");    		    		
			ok2=false;
			for(j2=0; j2<o2.length; j2++)
			{
				if (o2[j2].checked) 
				{						
					ok2=true; 
					break;
			    }
			}

			if(o.length != 0 && o2.length != 0)
			{
				if ((!ok) || (!ok2))
				{
					alert("Выберите стоимость билетов.");
				}
			}
			else 
			{
				if (!ok)
				{
					alert("Выберите стоимость билетов.");
				}
			}
		}

		function setColor(obj)
		{			
			var table=document.getElementById(obj.parentNode.parentNode.parentNode.id);
			var length = table.rows.length;	
			var row = obj.parentNode.rowIndex;
			var cell = obj.cellIndex;	

			
			if(table.rows[row].cells[cell].children[0].children[0].disabled == false)
			{
				for(i=1; i<length; i++)
				{				
					table.rows[i].cells[0].children[0].style.background="white";
				}
				table.rows[row].cells[0].children[0].style.background="linear-gradient(to bottom, #d1e25c 0%, #b9d306 100%)";

			}
						
		}
		function l(event) {
                with(event.target || event.srcElement) {
                    var row = parentNode.rowIndex + 1;
                    var column = cellIndex + 1;
                }
                alert("строка:" + row + ", столбец:" + column);
            }
	
function showResult(obj) {

 
var str = obj.value; 
var name = obj.parentNode.children[2].id;


var params='type=' + encodeURIComponent(name) + '&q=' + encodeURIComponent(str);

  if (str.length==0) { 
   
    return;
  }
  else if(str.length>0)
  {
       
        if (window.XMLHttpRequest) {
          // code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
        } else {  // code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function() {
          if (xmlhttp.readyState==4 && xmlhttp.status==200) 
          {        
              
            document.getElementById(name).innerHTML=xmlhttp.responseText;
           
          }
        }
        xmlhttp.open("GET","search.php?"+params,true);
        xmlhttp.send();
    }
}



	</script>
</head>
<body>
<div class="page-wrapper">
<?php 
	require_once "header.php";
	require_once "menu.php";

	require_once "functions.php";

					$msg = "";
					date_default_timezone_set("Europe/Helsinki"); 		
					$today = date("Y-m-d");
					$date_from = $date_to = date("Y-m-d"); 
					$flag_destination_block = 'inline_block';	
					$flag_number_block = 'none';
					$checked_1 = "";
					$checked_2 = "checked";	
					if(isset($_POST['type']))
					{				
						if($_POST['type']=='2')
						{		
						
							$checked_1 = "";
							$checked_2 = "checked";	
							$flag_destination_block = 'inline_block';	
							$flag_number_block = 'none';
						}
						else if($_POST['type']=='1')
						{			
						
							$checked_2= "";
							$checked_1 = "checked";	
							$flag_destination_block = 'none';	
							$flag_number_block = 'inline_block';
						}										
					}	


					$flight_from = $flight_to = "";		
					if(isset($_POST['flight_from']))
					{
						$flight_from = $_POST['flight_from'];						
					}
					if(isset($_POST['flight_to']))
					{
						$flight_to = $_POST['flight_to'];
					}

					
					if(isset($_POST['old']))
					{					

						$flight_number = $_POST['flight_number'];	
						$date_from = $_POST['date_from'];							
												
						if(isset($_POST['time_up_schedule']) and !empty($_POST['time_up_schedule']))			
						{				
							$time_up_schedule = $_POST['time_up_schedule']; 
							$query  = "UPDATE schedule SET time_up = '$time_up_schedule' WHERE flight_number = '$flight_number' AND flight_date = '$date_from'";
							$result = queryMysql($query);
						}
						if(isset($_POST['time_down_schedule']) and !empty($_POST['time_down_schedule']))	
						{						
							$time_down_schedule = $_POST['time_down_schedule'];						
							$query  = "UPDATE schedule SET time_down = '$time_down_schedule' WHERE flight_number = '$flight_number' AND flight_date = '$date_from'";
							$result = queryMysql($query);
						}
						if(isset($_POST['price_economy_schedule']) and !empty($_POST['price_economy_schedule']))
						{							
							$price_economy_schedule = $_POST['price_economy_schedule'];
							$query  = "UPDATE schedule SET price_economy = '$price_economy_schedule' WHERE flight_number = '$flight_number' AND flight_date = '$date_from'";
							$result = queryMysql($query);
						}
						if(isset($_POST['price_standard_schedule']) and !empty($_POST['price_standard_schedule']))		
						{					
							$price_standard_schedule = $_POST['price_standard_schedule'];
							$query  = "UPDATE schedule SET price_standard = '$price_standard_schedule' WHERE flight_number = '$flight_number' AND flight_date = '$date_from'";
							$result = queryMysql($query);
						}
						if(isset($_POST['price_business_schedule']) and !empty($_POST['price_business_schedule']))				
						{
							$price_business_schedule = $_POST['price_business_schedule'];							
							$query  = "UPDATE schedule SET price_business = '$price_business_schedule' WHERE flight_number = '$flight_number' AND flight_date = '$date_from'";
							$result = queryMysql($query);
						}		
						
						$msg = "Изменения сохранены."; 
					}
					elseif(isset($_POST['flight_number']))
					{
						$flight_number = $_POST['flight_number'];
					}
					
					if(isset($_POST['delete']))
					{						
						if(isset($_POST['flight_number']))
						{
							$flight_number = $_POST['flight_number'];
						}
						elseif(isset($_POST['delete']))
						{
							$flight_number = $_POST['delete'];
						}
						$query  = "DELETE FROM flights WHERE flight_number = '$flight_number'";
						$result = queryMysql($query);	
						$msg = "Выбранный рейс успешно удален.";
					}


					if(isset($_POST['date_from']))
					{				
						$date_from = $_POST['date_from'];
					}



echo<<<_END
	<section class="content">
		<div class="middle">
			<div class="fon">								
				<div class="found_form parentbox">	
					<form method="POST" >
						<input type="hidden" name="flight_number_old" value="flight_number">								
						<div class="info">
							<h2>Изменение рейсов</h2>
							<h3>На этой странице вы можете:</h3>
							<ul>													
								<li>Именить детали рейса в расписании на определенную дату</li>
							</ul>
						</div>
						<hr class="hr_search_tickets">						
						<div class="clear_both"></div>	
						<div class="radio_choise">							
							<input type="radio" name="type" value="2" id="select_number" $checked_2><span><label for="select_number">Направление рейса</label></span>							
							<input type="radio" name="type" value="1" id="select_destination" $checked_1><span><label for="select_destination">Номер рейса</label></span>							
						</div>			
						<div class="date_from inline_block">
							<h3>Дата</h3>
							<input type="date" name="date_from" class="input width_11" value="$date_from" required >
						</div>
						<div class="margin inline_block"></div>														
						<div class="clear_both"></div>			
						<div id="number_block" style = "display: $flag_number_block">
							<div class="inline_block">
								<h3>Номер рейса</h3>
								<div class="select_class">
									<select class="input select_cl" name="flight_number" required>
_END;

	    			$disabled_1 = $disabled_2 = "";
	    			if($flag_number_block == "none")
	    			{
	    				$disabled_1 = "disabled";
	    				$disabled_2 = "disabled";
	    			}

					$query  = "SELECT * FROM flights ORDER BY flight_number";
					$result = queryMysql($query);
	    			$num    = $result->num_rows;	


	    			if(isset($_POST['flight_number']))
	    			{
	    				$flight_number = $_POST['flight_number'];
	    			}

	    					for ($i=0; $i < $num; $i++) 
	    					{ 
	    						$row = $result->fetch_array(MYSQLI_ASSOC);      
	    						$number = $row['flight_number'];	
	    						$selected="";
	    						if(isset($_POST['flight_number']))
	    						{
	    							if($number == $flight_number)
	    							{
	    								$selected = "selected";
	    							}	    						
	    						}   						
	    						echo<<<_END
	    						<option value=$number $selected>$number</option>
_END;

	    					}


									echo<<<_END
									</select> 
									<div class="clear_both"></div>
									<div><h3 class="msg">$msg</h3></div>
									<div class="inline_block width_2">
										<input type="submit" class="button" name="change" value="Изменить" id="change_id" $disabled_1>							
									</div>										
								</div>							
							</div>	
						</div>	
						<div id="destination_block" style = "display: $flag_destination_block">									
							<div class="inline_block owerflow_hide">
								<h3>Город вылета</h3>
								<input type="text" class="input width_11 " name="flight_from" list="flight_from" id="flight_from_id" placeholder="Откуда?"  value = "$flight_from" autocomplete="off" onkeypress='showResult(this)'>	
								<datalist id='flight_from'></datalist>
							</div>							
							<div class="inline_block button_swap_wrapper">	
								<input type="button" class="button_swap" onclick="swap()" value="&harr;">																						
							</div>								
							<div class="inline_block owerflow_hide">
								<h3>Город назначения</h3>
								<input type="text" class="input width_11" name="flight_to" list="flight_to" id="flight_to_id" placeholder="Куда?"  value = "$flight_to" autocomplete="off" onkeypress='showResult(this)'>												
								<datalist id='flight_to'></datalist>
							</div>			
							<div class="clear_both"></div>	
							<div><h3 class="msg">$msg</h3></div>
							<div class="clear_both"></div>
							<div class="">
								<input type="submit" class="button" name="found" value="Найти">							
							</div>								
						</div>						
					</form>
				</div>
				

_END;
			
								
					if(isset($_POST['change']))
					{	
						
						$flight_number =  $flight_from = $flight_to = $time_up  = $time_down = $time_flight = $price_economy = $price_standard = $price_business = "";
						echo "<div class='found_form'>";							
														
							$flight_number = $_POST['change'];
							if(isset($_POST['flight_number']))
							{
								$flight_number = $_POST['flight_number'];
							}
							elseif(isset($_POST['change'])) 
							{
								$flight_number = $_POST['change'];	
							}
							
							$query = "SELECT 	flights.flight_from AS flight_from,
													flights.flight_to AS flight_to,
													flights.flight_number AS flight_number,
													flights.time_up AS time_up_flights,
													flights.time_down AS time_down_flights,
													flights.time_flight AS time_flight_flights,
													schedule.time_up AS time_up_schedule,
													schedule.time_down AS time_down_schedule,												
													flights.price_economy AS price_economy_flights,
													flights.price_standard AS price_standard_flights,
													flights.price_business AS price_business_flights,
													schedule.price_economy AS price_economy_schedule,
													schedule.price_standard AS price_standard_schedule,
													schedule.price_business AS price_business_schedule
													FROM flights, schedule WHERE flights.flight_number = '$flight_number' AND
													 schedule.flight_number = flights.flight_number AND
													 schedule.flight_date = '$date_from'";
							$result = queryMysql($query);
	    					$num    = $result->num_rows;
	
	    					$row = $result->fetch_array(MYSQLI_ASSOC);      						
      						$flight_number = $row['flight_number'];      						
      						$flight_from = $row['flight_from'];
      						$flight_to = $row['flight_to'];
      						$time_up_flights = $row['time_up_flights'];
      						$time_down_flights = $row['time_down_flights'];
							$time_flight_flights = $row['time_flight_flights'];	      							      						
							$price_economy_flights = $row['price_economy_flights'];									
							$price_standard_flights = $row['price_standard_flights'];
							$price_business_flights = $row['price_business_flights'];
							$time_up_schedule = $row['time_up_schedule'];
      						$time_down_schedule = $row['time_down_schedule'];							
							$price_economy_schedule = $row['price_economy_schedule'];									
							$price_standard_schedule = $row['price_standard_schedule'];
							$price_business_schedule = $row['price_business_schedule'];
							


							
						

						echo<<<_END

						
						<table class="table_online">
							<tr>
								<th>Рейс</th>
								<th>Откуда</th>
								<th>Куда</th>
								<th>Вылет (план)</th>
								<th>Прилет (план)</th>
								<th>В пути</th>
								<th>Эконом (план)</th>
								<th>Стандарт (план)</th>
								<th>Бизнес (план)</th>
							</tr>
							<tr>
								<td>$flight_number</td>
								<td>$flight_from</td>
								<td>$flight_to</td>
								<td>$time_up_flights</td>
								<td>$time_down_flights</td>
								<td>$time_flight_flights</td>
								<td>$price_economy_flights</td>
								<td>$price_standard_flights</td>
								<td>$price_business_flights</td>
							</tr>
						</table>
						<div>
						</div>
				
										
				<div class="parentbox">	
					<form method="POST">
						<input type="radio" name="type" value="2" $checked_2 style = "display: none">
						<input type="radio" name="type" value="1" $checked_1 style = "display: none">
						<input type="hidden" name="flight_number_old" value="$flight_number">
						<input type="hidden" name="date_from" value="$date_from">						
						<hr class="hr_search_tickets top_margin">	
						<div class="inline_block">
							<h3>Номер рейса</h3>
							<input type="number" class="input width_4" name="flight_number" placeholder="Только цифры?"  value = "$flight_number" autocomplete="off" disabled>			
							<input type="hidden" name="flight_number" value = "$flight_number">			
						</div>														
						<div class="inline_block">
							<h3>Город вылета</h3>
							<input type="text" class="input width_4" name="flight_from" placeholder="Откуда?"  value = "$flight_from" autocomplete="off" disabled>						
						</div>																		
						<div class="inline_block">
							<h3>Город назначение</h3>
							<input type="text" class="input width_4" name="flight_to" placeholder="Куда?"  value = "$flight_to" autocomplete="off" disabled>						
						</div>		
						<div class="clear_both"></div>	
						<div class="date_from inline_block">
							<h3>Вылет (план)</h3>
							<input type="time" name="time_up_flights" class="input width_4" value="$time_up_flights"  disabled>
						</div>				
						<div class="date_to inline_block" id="date_to_id">
							<h3>Прилет (план)</h3>
							<input type="time" name="time_down_flights" class="input width_4" value="$time_down_flights" disabled>
						</div>
						<div class="date_from inline_block">
							<h3>В пути</h3>
							<input type="time" name="time_flight_flights" class="input width_4" value="$time_flight_flights"  disabled>
						</div>					
						<div class="clear_both"></div>	
						<div class="date_from inline_block">
							<h3>Эконом цена (план)</h3>
							<input type="number" name="price_economy_flights" class="input width_4" value="$price_economy_flights"  disabled>
						</div>				
						<div class="date_to inline_block" id="date_to_id">
							<h3>Стандарт цена (план)</h3>
							<input type="number" name="price_standard_flights" class="input width_4" value="$price_standard_flights"  disabled>
						</div>
						<div class="date_from inline_block">
							<h3>Бизнес цена (план)</h3>
							<input type="number" name="price_business_flights" class="input width_4" value="$price_business_flights"  disabled>
						</div>					
						<div class="clear_both"></div>	
						<div class="date_from inline_block">
							<h3>Эконом цена (факт)</h3>
							<input type="number" name="price_economy_schedule" class="input width_4" value="$price_economy_schedule"  >
						</div>				
						<div class="date_to inline_block" id="date_to_id">
							<h3>Стандарт цена (факт)</h3>
							<input type="number" name="price_standard_schedule" class="input width_4" value="$price_standard_schedule"  >
						</div>
						<div class="date_from inline_block">
							<h3>Бизнес цена (факт)</h3>
							<input type="number" name="price_business_schedule" class="input width_4" value="$price_business_schedule"  >
						</div>					
						<div class="clear_both"></div>	
						<div class="date_from inline_block">
							<h3>Вылет (факт)</h3>
							<input type="time" name="time_up_schedule" class="input width_4" value="$time_up_schedule">
						</div>				
						<div class="date_to inline_block" id="date_to_id">
							<h3>Прилет (факт)</h3>
							<input type="time" name="time_down_schedule" class="input width_4" value="$time_down_schedule">
						</div>
						<div class="clear_both"></div>						
						<div class="">
							<input type="submit" class="button" name = "old" value="Сохранить">							
						</div>										
					</form>
				</div>	
				</div>
				<div class="clear"></div>
_END;
					}


					if(isset($_POST['found']))
					{	
																	
						$flight_number =  $time_up  = $time_down = $time_flight = $price_economy = $price_standard = $price_business = "";



						if(isset($_POST['flight_from']))
						{
							$flight_from = $_POST['flight_from'];						
						}
						if(isset($_POST['flight_to']))
						{
							$flight_to = $_POST['flight_to'];
						}

						if(isset($_POST['found']))
						{	
							
							$found = "";							

							//if(!empty($flight_to) or !empty($flight_from))
							{

								$date_from = $_POST['date_from'];
								

								echo "<div id='found_form_id'>";
								echo "<div class='found_form'>";	
								if(!empty($flight_to))
								{
									$found.="flight_to = '$flight_to' AND ";
								}
								if(!empty($flight_from))
								{
									$found.="flight_from = '$flight_from' AND ";	
								} 		
	
								$query = "SELECT 	flights.flight_from AS flight_from,
													flights.flight_to AS flight_to,
													flights.flight_number AS flight_number,
													flights.time_up AS time_up_flights,
													flights.time_down AS time_down_flights,
													flights.time_flight AS time_flight_flights,
													schedule.time_up AS time_up_schedule,
													schedule.time_down AS time_down_schedule,												
													flights.price_economy AS price_economy_flights,
													flights.price_standard AS price_standard_flights,
													flights.price_business AS price_business_flights,
													schedule.price_economy AS price_economy_schedule,
													schedule.price_standard AS price_standard_schedule,
													schedule.price_business AS price_business_schedule
													FROM flights, schedule WHERE $found 
													 schedule.flight_number = flights.flight_number AND
													 schedule.flight_date = '$date_from' ORDER BY time_up_flights";
								$result = queryMysql($query);
	    						$num    = $result->num_rows;	
	
	    						
	
	    						if($num == 0)
	    						{
    								echo "Попробуйте выбрать другой маршрут.";	    						
	    						}
	    						else
	    						{
	    							
								echo<<<_END
								
									<form method="POST">
										<input type="hidden" name="flight_from" value="$flight_from">
										<input type="hidden" name="flight_to" value="$flight_to">
										<input type="hidden" name="date_from" value="$date_from">
										<table class="table_online">
											<tr>
					    				   		<th rowspan="2">Рейс</th>
					    				   		<th rowspan="2">Маршрут</th>			    				   		
					    				   		<th colspan="2">Время (вылет/прилет)</th>		
					    				   		<th rowspan="2">В пути</th>
					    				   		<th colspan="3">Цена (план/факт)</th>		
												<th rowspan="2"></th>											
				    						</tr>	
				    						<tr>
				    							<th>План</th>
				    							<th>Факт</th>
												<th>Эконом</th>
												<th>Стандарт</th>
												<th>Бизнес</th>				    							
				    						</tr>				    					
_END;
    					 					 	    			    							
	
							

	    						for ($i=0; $i < $num; $i++) 
	    						{
	    							$row = $result->fetch_array(MYSQLI_ASSOC);
	    							$flight_number = $row['flight_number'];						
									$flight_from = $row['flight_from'];		
									$flight_to = $row['flight_to'];
									$time_up_flights = $row['time_up_flights'];
									$time_down_flights = $row['time_down_flights'];
									$time_flight_flights = $row['time_flight_flights'];
									$time_up_schedule = $row['time_up_schedule'];
									$time_down_schedule = $row['time_down_schedule'];
									$price_economy_flights = $row['price_economy_flights'];
									$price_standard_flights = $row['price_standard_flights'];
									$price_business_flights = $row['price_business_flights'];  
									$price_economy_schedule = $row['price_economy_schedule'];
									$price_standard_schedule = $row['price_standard_schedule'];
									$price_business_schedule = $row['price_business_schedule'];   
										echo <<<_END
	      								<tr>	      							
											<td rowspan="2">$flight_number</td>
											<td>$flight_from</td>
											<td>$time_up_flights</td>										
											<td>$time_up_schedule</td>			
											<td rowspan="2">$time_flight_flights</td>
											<td >$price_economy_flights</td>
											<td >$price_standard_flights</td>
											<td >$price_business_flights</td>
											<td rowspan="2">										
												<button type="submit" value="$flight_number" name="change" class="button_online_height2 button_online">Изменить</button>					
											</td>	
										</tr>	
										<tr>
											<td>$flight_to</td>
											<td>$time_down_flights</td>	
											<td>$time_down_schedule</td>
											<td >$price_economy_schedule</td>
											<td >$price_standard_schedule</td>
											<td >$price_business_schedule</td>												
										</tr>
_END;
	    						}
       						
	      						
	      							echo "</table></form></div>";	

	      						}
	      					}
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