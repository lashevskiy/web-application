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
		        $("#date_to_id").css('visibility', 'hidden');
		    });
		    $("#two").click(function(){
		        $("#date_to_id").css('visibility', 'visible');
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

					
			
			

			//alert(table.rows[row].cells[cell].children[0].children[0].disabled);

			if(table.rows[row].cells[cell].children[0].children[0].disabled == false)
			{
				for(i=1; i<length; i++)
				{				
					table.rows[i].cells[0].children[0].style.background="white";
				}
				table.rows[row].cells[0].children[0].style.background="linear-gradient(to bottom, #d1e25c 0%, #b9d306 100%)";

			}
			
			
			//document.getElementById("time_up").value = table.rows[row].cells[1].innerHTML;
			//document.getElementById("time_down").value = table.rows[row].cells[2].innerHTML;
			//document.getElementById("flight_number").value = table.rows[row].cells[3].innerHTML;


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

    //document.getElementById("livesearch").innerHTML="";    
    //document.getElementById("livesearch").style.border="0px";
    return;
  }
  else if(str.length>=1)
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
           // document.getElementById("livesearch").size=5;
            //document.getElementById("resultTable").style.border="1px solid #A5ACB2";
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

	//found_path("Санкт-Петербург", NULL, "Иркутск");
	



					if(isset($_POST['flight_from']) or isset($_POST["number"]))
					{							
						$today = date("Y-m-d");
						if(isset($_POST["number"]))
						{		
							
							$number = $_POST["number"];							
							
							$query  = "SELECT DISTINCT flight_from, flight_to FROM flights WHERE flight_number = '$number'";
							$result = queryMysql($query);
	    					$num    = $result->num_rows;	    					
	    					for ($i=0; $i < $num; $i++) 
	    					{	    						 
	    						$row = $result->fetch_array(MYSQLI_ASSOC);      						
	    						$flight_from[0] = $row['flight_from'];						
								$flight_to[0] = $row['flight_to'];
	    					}
						}
						else
						{								
							$flight_from = $_POST['flight_from'];						
							$flight_to = $_POST['flight_to'];
						}


						
						$flight_date = $_POST['flight_date'];						
						$count_peolpe = $_POST['count_peolpe'];	
						$class = $_POST['class'];

						
						

						$selected = array(3);
						$disabled = array(3);
						$selected['price_economy'] = $selected['price_standard'] = $selected['price_business'] = "";
						$disabled['price_economy'] = $disabled['price_standard'] = $disabled['price_business'] = "disabled";
						$selected[$class] = "selected";
						$disabled[$class] = "";

						if(isset($_POST['direction']))
						{								
							if($_POST['direction']=='2')
							{								
								$checked_1 = "";
								$checked_2 = "checked";	
								$flag = 'inline_block';	
							}
							else if($_POST['direction']=='1')
							{									
								$checked_2= "";
								$checked_1 = "checked";	
								$flag = 'hidden';
							}										
						}						
					}
					else 
					{	
						$today = date("Y-m-d");										
						$flight_from[0] = $flight_from[1] = $flight_to[0] = $flight_to[1] = "";	
						$count_peolpe = "1";					
						
						$flight_date[0] = new DateTime(date("Y-m-d"));						
						$flight_date[0] = $flight_date[0]->format("Y-m-d");

						$flight_date[1] = new DateTime($flight_date[0]);		
						$flight_date[1]->modify("+7 day");
						$flight_date[1] = $flight_date[1]->format("Y-m-d");


						$checked_1 = "";
						$checked_2 = "checked";	

						$flag = 'inline_block';		

						$selected = array(3);								
						$selected['price_economy'] = $selected['price_standard'] = $selected['price_business'] = "";												
						$selected['price_economy'] = "selected";						

					}




	//echo "<datalist id='flight_from_list' size='3'>";
	//$query = "SELECT DISTINCT flight_from FROM flights";
	//$result = queryMysql($query);
   	//$num    = $result->num_rows;    				
	//for ($j = 0 ; $j < $num ; ++$j)
	//{		
	//	$row = $result->fetch_array(MYSQLI_ASSOC);      						
	//					
	//	echo "<option value=".$row['flight_from']." label=".$row['flight_from'].">";				
	//}	
	//echo "</datalist>";

	//echo "<datalist id='flight_to_list'>";
	//$query = "SELECT DISTINCT flight_to FROM flights";
	//$result = queryMysql($query);
   	//$num    = $result->num_rows;    				
	//for ($j = 0 ; $j < $num ; ++$j)
	//{		
	//	$row = $result->fetch_array(MYSQLI_ASSOC);      						
	//					
	//	echo "<option value=".$row['flight_to']." label=".$row['flight_to'].">";				
	//}	
	//echo "</datalist>";

echo<<<_END
	<section class="content">
		<div class="middle">
			<div class="fon">								
				<div class="found_form parentbox">	
					<form method="POST" action="tickets.php">
						<div class="info_tickets info">
							<h2>Авиабилеты</h2>
							<h3>На этой странице вы можете:</h3>
							<ul>								
								<li>Найти билеты в нужном направлении на определенную дату. Для этого задайте направление и дату (по умолчанию стоит сегодня).</li>
								<li>Сравнить и выбрать наиболее подходящий класс перелета по стоимоси билетов.</li>								
								<li>Забронировать понравившиеся билеты.</li>
							</ul>
						</div>
						<hr class="hr_search_tickets">
						<div class="radio_choise">
							<div class="inline_block">								
								<input type="radio" name="direction" value="2" id="two" $checked_2><span><label for="two">Туда и обратно</label></span>
							</div>
							<div class="inline_block">
								<input type="radio" name="direction" value="1" id="one" $checked_1><span><label for="one">В одну сторону</label></span>								
							</div>
							<div class="inline_block href">
								<a href="#">Составной</a>
							</div>
						</div>
							
						<div class="inline_block owerflow_hide">
							<h3>Город вылета</h3>
							<input type="text" class="input width_1" name="flight_from[0]" list="flight_from" id="flight_from_id" placeholder="Откуда?"  value = "$flight_from[0]" autocomplete="off" onkeyup='checkValue()' onkeypress='showResult(this)' required>							
							<datalist id='flight_from'></datalist>
						</div>								
						<div class="inline_block button_swap_wrapper">	
							<input type="button" class="button_swap" onclick="swap()" value="&harr;">																						
						</div>					
						<div class="inline_block owerflow_hide">
							<h3>Город назначения</h3>
							<input type="text" class="input width_1" name="flight_to[0]" list="flight_to" id="flight_to_id" placeholder="Куда?"  value = "$flight_to[0]" autocomplete="off" onkeyup='checkValue()' onkeypress='showResult(this)' required>												
							<datalist id='flight_to'></datalist>
						</div>
						<div class="clear_both"></div>	
						<div class="date_from inline_block">
							<h3>Дата туда</h3>
							<input type="date" name="flight_date[0]" class="input width_1" id="date_from" value="$flight_date[0]" min='$today' required>
						</div>
						<div class="margin inline_block"></div>
						<div class="date_to inline_block" id="date_to_id" style = "visibility: $flag">
							<h3>Дата обратно</h3>
							<input type="date" name="flight_date[1]" class="input width_1" id="date_to" value="$flight_date[1]" min='$today' required>
						</div>					
						<div class="clear_both"></div>			
						<div class="inline_block">
							<h3>Количество мест</h3>						
							<input type="number" class="input width_1" name="count_peolpe" min="1" max="5" value=$count_peolpe required>
						</div>
						<div class="margin inline_block"></div>
						<div class="inline_block">
							<h3>Класс перелета</h3>	
							<div class="select_class">
								<select class="input" name="class" required>
									<option $selected[price_economy] value="price_economy">Эконом</option>
									<option $selected[price_standard] value="price_standard">Стандарт</option>
									<option $selected[price_business] value="price_business">Бизнес</option>
								</select> 
							</div>
						</div>
						<div class="clear_both"></div>			
						<div>
							<input type="submit" class="button" value="Найти билеты">							
						</div>
					</form>
				</div>
				<div class="clear"></div>
_END;
					if(isset($_POST['flight_from']) or isset($_POST['number']))
					{
						if(isset($_POST["number"]))
						{				
							$number = $_POST["number"];							
							$query  = "SELECT DISTINCT flight_from, flight_to FROM flights WHERE flight_number = '$number'";
							$result = queryMysql($query);
	    					$num    = $result->num_rows;	    					
	    					for ($i=0; $i < $num; $i++) 
	    					{	    						 
	    						$row = $result->fetch_array(MYSQLI_ASSOC);      						
	    						$flight_from[0] = $row['flight_from'];						
								$flight_to[0] = $row['flight_to'];
	    					}
						}
						else
						{								
							$flight_from = $_POST['flight_from'];						
							$flight_to = $_POST['flight_to'];
						}


						
						$flight_date = $_POST['flight_date'];
						$direction = $_POST['direction'];

						//if($direction == "one")
						//{
						
						
						
					
						
						
						$query = array(2);
						$result = array(2);
						$num = array(2);


						date_default_timezone_set("Europe/Helsinki");
    					$date = date("Y-m-d");
    					$time = date("H:i:s");

    					$flag = true;

						if($direction == "1")
						{						
							$query[0]  = "SELECT DISTINCT schedule.flight_date, flights.flight_number, flights.flight_from, flights.flight_to, flights.flight_from_code, flights.flight_to_code, IF(schedule.time_up IS NULL, flights.time_up, schedule.time_up) AS time_up, IF(schedule.time_down IS NULL, flights.time_down, schedule.time_down) AS time_down, flights.time_flight, flights.airplane_type, IF(schedule.price_economy IS NULL, flights.price_economy, schedule.price_economy) AS price_economy, IF(schedule.price_standard IS NULL, flights.price_standard, schedule.price_standard) AS price_standard, IF(schedule.price_business IS NULL, flights.price_business, schedule.price_business) AS price_business FROM flights, schedule WHERE flights.flight_number = schedule.flight_number AND flight_from = '$flight_from[0]' AND flight_to = '$flight_to[0]' AND schedule.flight_date = '$flight_date[0]' AND IF($flight_date[0] = $date, IF(schedule.time_up IS NULL, flights.time_up, schedule.time_up) > '$time', true) ORDER BY time_up";
							$result[0] = queryMysql($query[0]);
	    					$num[0]    = $result[0]->num_rows;				
	    					

	    					if($num[0] == 0)
	    					{
	    						$flag = false;
	    					}				
	    					
						}
						if($direction == "2")
						{					
							$query[0]  = "SELECT DISTINCT schedule.flight_date, flights.flight_number, flights.flight_from, flights.flight_to, flights.flight_from_code, flights.flight_to_code, IF(schedule.time_up IS NULL, flights.time_up, schedule.time_up) AS time_up, IF(schedule.time_down IS NULL, flights.time_down, schedule.time_down) AS time_down, flights.time_flight, flights.airplane_type, IF(schedule.price_economy IS NULL, flights.price_economy, schedule.price_economy) AS price_economy, IF(schedule.price_standard IS NULL, flights.price_standard, schedule.price_standard) AS price_standard, IF(schedule.price_business IS NULL, flights.price_business, schedule.price_business) AS price_business FROM flights, schedule WHERE flights.flight_number = schedule.flight_number AND flight_from = '$flight_from[0]' AND flight_to = '$flight_to[0]' AND schedule.flight_date = '$flight_date[0]' AND IF($flight_date[0] = $date, IF(schedule.time_up IS NULL, flights.time_up, schedule.time_up) > '$time', true) ORDER BY time_up";
							$result[0] = queryMysql($query[0]);
	    					$num[0]    = $result[0]->num_rows;	
							
							$query[1]  = "SELECT DISTINCT schedule.flight_date, flights.flight_number, flights.flight_from, flights.flight_to, flights.flight_from_code, flights.flight_to_code, IF(schedule.time_up IS NULL, flights.time_up, schedule.time_up) AS time_up, IF(schedule.time_down IS NULL, flights.time_down, schedule.time_down) AS time_down, flights.time_flight, flights.airplane_type, IF(schedule.price_economy IS NULL, flights.price_economy, schedule.price_economy) AS price_economy, IF(schedule.price_standard IS NULL, flights.price_standard, schedule.price_standard) AS price_standard, IF(schedule.price_business IS NULL, flights.price_business, schedule.price_business) AS price_business FROM flights, schedule WHERE flights.flight_number = schedule.flight_number AND flight_from = '$flight_to[0]' AND flight_to = '$flight_from[0]' AND schedule.flight_date = '$flight_date[1]' AND IF($flight_date[1] = $date, IF(schedule.time_up IS NULL, flights.time_up, schedule.time_up) > '$time', true) ORDER BY time_up";
							$result[1] = queryMysql($query[1]);
	    					$num[1]    = $result[1]->num_rows;

	    					if($num[0] == 0 or $num[1]==0)
	    					{
	    						$flag = false;    							    						
	    					}				
	    				
						}

						if($flag == true)
						{    					
							echo '<form method="POST" action="buy_tickets.php">';
							for ($i=0; $i < $direction; $i++) 					
    						{
    							if($i!=0)
    							{
    								$flight_from_str = $flight_to[0];
    								$flight_to_str = $flight_from[0];
    							}
    							else
    							{
    								$flight_from_str = $flight_from[0];
    								$flight_to_str = $flight_to[0];
    							}
								echo <<< _END
								<div class="select_flights ">	
									<div>
										<h3>Выберите рейс: $flight_from_str - $flight_to_str</h3>								
									</div>
								</div>	
								<table class="" id="$i">
									<tr>
										<th colspan="2">Вылет</th>
					    		   		<th>Прилет</th>
					    		   		<th>Рейс</th>
					    		   		<th>В пути</th>
					    		   		<th>Эконом</th>
					    		   		<th>Стандарт</th>
					    		   		<th>Бизнес</th>
				    				</tr>	
_END;
    					 		
    					 	

       							for ($j = 0 ; $j < $num[$i] ; ++$j)
    							{
      								$row = $result[$i]->fetch_array(MYSQLI_ASSOC);      						
      								$flight_number[$j] = $row['flight_number'];      						
      								$time_up = $row['time_up'];
      								$time_down = $row['time_down'];
									$time_flight = $row['time_flight'];
									$price_economy = $row['price_economy'];
									$price_standard = $row['price_standard'];
									$price_business = $row['price_business']; 	
      							
	      							$time_down_obj = new DateTime($time_down);
									$time_up_obj = new DateTime($time_up);
									$time_flight = new DateTime($time_flight);		
										
									
									if($time_flight->format('G') == '0')
										$time_flight = $time_flight->format('iм');	
									else $time_flight = $time_flight->format('Gч iм');

									
									$id1 = $j * 3;
									$id1 = $i . "_" . $id1;
												$id2 = $j * 3 + 1;
									$id2 = $i . "_" . $id2;
												$id3 = $j * 3 + 2;
									$id3 = $i . "_" . $id3;		
   																	echo <<<_END
	      							<tr>
	      								<td class="active_td"><div class="active"></div></td>
										<td>$time_up</td>
										<td>$time_down</td>
										<td>$flight_number[$j]</td>
										<td>$time_flight</td>								
										<td class="td_price2" onclick="setColor(this)">
											<div class="radio_buttons2">
												<input type="radio" name="flight_number[$i]" value="$flight_number[$j]" id="$id1" required $disabled[price_economy]>										
												<label for="$id1" ><div>$price_economy руб</div></label>
											</div>
										</td>
										<td class="td_price2" onclick="setColor(this)">
											<div class="radio_buttons2">
												<input type="radio" name="flight_number[$i]" value="$flight_number[$j]" id="$id2" required $disabled[price_standard]>
												<label for="$id2"><div>$price_standard руб</div></label>
											</div>
										</td>
										<td class="td_price2" onclick="setColor(this)">
											<div class="radio_buttons2">
												<input type="radio" name="flight_number[$i]" value="$flight_number[$j]" id="$id3" required $disabled[price_business]>
												<label for="$id3"><div>$price_business руб</div></label>
											</div>
										</td>
									</tr>	
_END;
									
	      						}	
	      						echo "</table>";		      				
	      					}   
	      				

	      					
	      					
							echo <<<_END
							<div>					
								<input type="hidden" name="flight_date[0]" value="$flight_date[0]">
								<input type="hidden" name="flight_date[1]" value="$flight_date[1]">																					
								<input type="hidden" name="count_peolpe" value="$count_peolpe">
								<input type="hidden" name="class" value="$class">
								<input type="hidden" name="direction" value="$direction">
_END;

								if(isset($loggedin) and $loggedin==true)
								{
									echo '<input type="submit" class="button" value="Перейти к оформлению билетов" onclick="ckeck()">';
								}
								else 
								{
									echo '<a href="login.php"><input type="button" class="button" value="Войти для бронирования"></a>';
								}
	
								echo <<<_END
								</div>
								</form>															
								<div class="clear"></div>
_END;
							
						}
						else
						{
							echo '
    							<div class="found_form center">На сегодня рейсов уже нет. Попробуйте выбрать другой маршрут или дату.</div>
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
<script type="text/javascript">
	//setDate();
	//setRadio();
</script>
</body>
</html>