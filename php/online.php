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


					if(isset($_POST['submit']))
					{	
						$flight_from = $_POST['flight_from'];						
						$flight_to = $_POST['flight_to'];
						
						$flight_date = $_POST['flight_date'];													
					}
					else 
					{											
						$flight_from[0] = $flight_to[0] = "";	
						
						$flight_date[0] = new DateTime(date("Y-m-d"));						
						$flight_date[0] = $flight_date[0]->format("Y-m-d");						
					}
					$today = date("Y-m-d");

echo<<<_END
	<section class="content">
		<div class="middle">
			<div class="fon">								
				<div class="found_form parentbox">	
					<form method="POST" action="online.php">		
						<div class="info">
							<h2>Табло рейсов</h2>
							<h3>На этой странице вы можете:</h3>
							<ul>								
								<li>Посмотреть, какие рейсы есть  по нужному направлению, их статус, время посадки и вылета самолёта. Для этого задайте дату (по умолчанию стоит сегодня) и направление.</li>
								<li>Получить информацию обо всех рейсах (вылетах и прилётах) аэропорта. Для этого укажите дату и заполните только одно поле направления – город вылета.</li>								
								<li>Перейти к бронированию билетов.</li>
							</ul>
						</div>
						<hr class="hr_search_tickets">						
						<div class="clear_both"></div>	
						
						<div class="inline_block owerflow_hide">
							<h3>Город вылета</h3>
							<input type="text" class="input " name="flight_from[0]" list="flight_from" id="flight_from_id" placeholder="Откуда?"  value = "$flight_from[0]" autocomplete="off" onkeypress='showResult(this)'>	
							<datalist id='flight_from'></datalist>
						</div>								
						<div class="inline_block button_swap_wrapper">	
							<input type="button" class="button_swap" onclick="swap()" value="&harr;">				
						</div>					
						<div class="inline_block owerflow_hide">
							<h3>Город назначения</h3>
							<input type="text" class="input " name="flight_to[0]" list="flight_to" id="flight_to_id" placeholder="Куда?"  value = "$flight_to[0]" autocomplete="off" onkeypress='showResult(this)'>												
							<datalist id='flight_to'></datalist>
						</div>
						<div class="inline_block owerflow_hide">
							<h3>Дата</h3>
							<input type="date" name="flight_date[0]" class="input date_from" id="date_from" min='$today' value="$flight_date[0]" required>
						</div>						
						<div class="clear_both"></div>			
						<div>
							<input type="submit" class="button" name="submit" value="Показать">							
						</div>		
					</form>
				</div>
				<div class="clear"></div>
_END;
					if(isset($_POST['submit']))
					{						
						$flight_from = $_POST['flight_from'];		
						$flight_to = $_POST['flight_to'];					
						$flight_date = $_POST['flight_date'];
						$direction = 1;
						$class = "price_economy";


						$flight_date[1] = new DateTime($flight_date[0]);		
						$flight_date[1]->modify("+7 day");
						$flight_date[1] = $flight_date[1]->format("Y-m-d");

						if(!empty($flight_to[0]) or !empty($flight_from[0]))
						{						
							$found = "";
							if(!empty($flight_to[0])) 
							{
								$found.="flight_to = '$flight_to[0]' AND ";
							}
							if(!empty($flight_from[0]))
							{
								$found.="flight_from = '$flight_from[0]' AND ";	
							} 
				
												
							$query[0]  = "SELECT DISTINCT schedule.flight_date, 
														flights.flight_number, 
														flights.flight_from, 
														flights.flight_to, 
														flights.flight_from_code, 
														flights.flight_to_code, 
														IF(schedule.time_up IS NULL, flights.time_up, schedule.time_up) AS time_up, 
														IF(schedule.time_down IS NULL, flights.time_down, schedule.time_down) AS time_down, 
														flights.time_flight, 
														flights.airplane_type, 
														IF(schedule.price_economy IS NULL, flights.price_economy, schedule.price_economy) AS price_economy, 
														IF(schedule.price_standard IS NULL, flights.price_standard, schedule.price_standard) AS price_standard, 
														IF(schedule.price_business IS NULL, flights.price_business, schedule.price_business) AS price_business 
														FROM flights, schedule WHERE 
														flights.flight_number = schedule.flight_number AND 														
														$found
														schedule.flight_date = '$flight_date[0]' 
														ORDER BY time_up";

							$result[0] = queryMysql($query[0]);
	    					$num[0]    = $result[0]->num_rows;				
	    					if($num[0] == 0)
	    					{
    							echo '
    								<div class="found_form center">Билетов не найдено. Попробуйте выбрать другой маршрут.</div>
    							';	    						
	    					}
	    					else 
	    					{							
								echo<<<_END
								<form method="POST" action="tickets.php">
									<table class="table_online">
										<tr>
					    			   		<th rowspan="2">Рейс</th>
					    			   		<th rowspan="2">Маршрут</th>
					    			   		<th colspan="2">Время (план/факт)</th>
					    			   		<th rowspan="2">В пути</th>
											<th rowspan="2">Статус</th>
											<th rowspan="2"></th>
				    					</tr>	
				    					<tr>
					    			   		<th>Плановое</th>
					    			   		<th>Фактическое</th>  		   							    		   		
					    			   	</tr>
_END;
    					 					 	    					
    					 		//иначе функци-я date("H:i:s"); выводит с разницей в час ?! ы
    							date_default_timezone_set("Europe/Helsinki"); 
	
	
       							for ($j = 0 ; $j < $num[0] ; ++$j)
    							{
      								$row = $result[0]->fetch_array(MYSQLI_ASSOC);      						
      								$flight_number[$j] = $row['flight_number'];      						
      								$flight_from[$j] = $row['flight_from'];
      								$flight_to[$j] = $row['flight_to'];
      								$time_up = $row['time_up'];
      								$time_down = $row['time_down'];
									$time_flight = $row['time_flight'];	      							      						
									
									$time_flight = new DateTime($time_flight);			
									if($time_flight->format('G') == '0')
										$time_flight = $time_flight->format('iм');	
									else $time_flight = $time_flight->format('Gч iм');
	
									$time = date("H:i:s");	

											
									$flag = false;
									if($time < $time_up)
									{
										$status = "По<br>расписанию";	
										$time_up_fact = "-";
										$time_down_fact = "-";
										$flag = true;
									}
									else if($time >= $time_up and $time < $time_down)
									{
										$status = "Вылетел";
										$time_up_fact = $time_up;
										$time_down_fact = "-";
									}
									else 
									{	
										$status = "Совершил<br>посадку";
										$time_up_fact = $time_up;
										$time_down_fact = $time_down;
									}
									

																
   								
									echo <<<_END
	      							<tr>	      							
										<td rowspan="2">$flight_number[$j]</td>
										<td>$flight_from[$j]</td>
										<td>$time_up</td>
										<td>$time_up_fact</td>			
										<td rowspan="2">$time_flight</td>
										<td rowspan="2">$status</td>												
										<td rowspan="2">										
											<button type="submit" value="$flight_number[$j]" name="number" class="button_online">Купить</button>					
										</td>		
									</tr>	
									<tr>
										<td>$flight_to[$j]</td>
										<td>$time_down</td>
										<td>$time_down_fact</td>																
									</tr>
_END;
	      						}	
	      						echo "</table>";	
	      				
								echo <<<_END
								<div>					
									<input type="hidden" name="flight_date[0]" value="$flight_date[0]">
									<input type="hidden" name="flight_date[1]" value="$flight_date[1]">								
									<input type="hidden" name="direction" value="1">
									<input type="hidden" name="count_peolpe" value="1">
									<input type="hidden" name="class" value="price_economy">	
								</div>
								</form>															
								<div class="clear"></div>
_END;
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