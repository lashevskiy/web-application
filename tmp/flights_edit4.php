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

					
					if (isset($_POST['new']))
					{	
						echo "new";				
						$flight_number = $_POST['flight_number'];						
						$flight_from = $_POST['flight_from'];		
						$flight_to = $_POST['flight_to'];
						$time_up = $_POST['time_up'];
						$time_down = $_POST['time_down'];
						$time_flight = $_POST['time_flight'];
						$price_economy = $_POST['price_economy'];
						$price_standard = $_POST['price_standard'];
						$price_business = $_POST['price_business'];

						echo "$flight_number -- $flight_from -- $flight_to -- $time_up -- $time_down -- $time_flight -- $price_economy -- $price_standard -- $price_business";

						$query  = "INSERT INTO flights (flight_number, 
														flight_from, 
														flight_to,
														time_up,
														time_down,
														time_flight,
														price_economy,
														price_standard,
														price_business
														) 
														VALUES 
														(
															'$flight_number',
															'$flight_from',
															'$flight_to',
															'$time_up',
															'$time_down',
															'$time_flight',
															'$price_economy',
															'$price_standard',
															'$price_business'
														)";
						$result = queryMysql($query);	    				
					}
					elseif(isset($_POST['old']))
					{
						echo "old";				
						$flight_number = $_POST['flight_number'];						
						$flight_from = $_POST['flight_from'];		
						$flight_to = $_POST['flight_to'];
						$time_up = $_POST['time_up'];
						$time_down = $_POST['time_down'];
						$time_flight = $_POST['time_flight'];
						$price_economy = $_POST['price_economy'];
						$price_standard = $_POST['price_standard'];
						$price_business = $_POST['price_business'];
						$flight_number_old = $_POST['flight_number_old'];

						echo "$flight_number --- $flight_number_old -- $flight_from -- $flight_to -- $time_up -- $time_down -- $time_flight -- $price_economy -- $price_standard -- $price_business";

						$query  = "UPDATE flights SET flight_number = '$flight_number',
														flight_from = '$flight_from',
															flight_to = '$flight_to',
															time_up = '$time_up',
															time_down = '$time_down',
															time_flight = '$time_flight',
															price_economy = '$price_economy',
															price_standard = '$price_standard',
															price_business = '$price_business'
														WHERE flight_number = '$flight_number_old'";

						$result = queryMysql($query);	    	

					}
					elseif(isset($_POST['flight_number']))
					{
						$flight_number = $_POST['flight_number'];
					}

echo<<<_END
	<section class="content">
		<div class="middle">
			<div class="fon">								
				<div class="found_form parentbox">	
					<form method="POST" >		
						<div class="info">
							<h2>Изменение рейсов</h2>
							<h3>На этой странице вы можете:</h3>
							<ul>					
								<li>Добавить новый рейс</li>
								<li>Именить детали существующего рейса</li>
							</ul>
						</div>
						<hr class="hr_search_tickets">						
						<div class="clear_both"></div>	
						
						<div class="inline_block">
							<h3>Номер рейса</h3>
							<div class="select_class">
								<select class="input" name="flight_number" required>
_END;

							$query  = "SELECT * FROM flights ORDER BY flight_number";
							$result = queryMysql($query);
	    					$num    = $result->num_rows;	

	    					for ($i=0; $i < $num; $i++) 
	    					{ 
	    						$row = $result->fetch_array(MYSQLI_ASSOC);      
	    						$number = $row['flight_number'];	
	    						$selected="";
	    						if($number == $flight_number)
	    						{
	    							$selected = "selected";
	    						}	    						
	    						echo<<<_END
	    						<option value=$number $selected>$number</option>
_END;

	    					}
								echo<<<_END
								</select> 
							</div>							
						</div>		
						<div class="clear_both"></div>	
						<div class="inline_block width_2">
							<input type="submit" class="button" name="chande_old" value="Изменить">							
						</div>	
						<div class="inline_block width_2">
							<input type="submit" class="button" name="chande_new" value="Добавить новый рейс">							
						</div>	
					</form>
				</div>
				

_END;


								echo<<<_END
								<form method="POST">
									<table class="table_online">
										<tr>
					    			   		<th>Рейс</th>
					    			   		<th>Маршрут</th>
					    			   		<th>Время</th>
					    			   		<th>В пути</th>
											<th>Эконом</th>
											<th>Стандарт</th>
											<th>Бизнес</th>
											<th></th>
				    					</tr>					    					
_END;
    					 					 	    			    							
	
							$query  = "SELECT * FROM flights ORDER BY flight_number";
							$result = queryMysql($query);
	    					$num    = $result->num_rows;	

	    					for ($i=0; $i < $num; $i++) 
	    					{
	    						$row = $result->fetch_array(MYSQLI_ASSOC);
	    						$flight_number = $row['flight_number'];						
								$flight_from = $row['flight_from'];		
								$flight_to = $row['flight_to'];
								$time_up = $row['time_up'];
								$time_down = $row['time_down'];
								$time_flight = $row['time_flight'];
								$price_economy = $row['price_economy'];
								$price_standard = $row['price_standard'];
								$price_business = $row['price_business'];    
									echo <<<_END
	      							<tr>	      							
										<td rowspan="2">$flight_number</td>
										<td>$flight_from</td>
										<td>$time_up</td>													
										<td rowspan="2">$time_flight</td>
										<td rowspan="2">$price_economy</td>
										<td rowspan="2">$price_standard</td>
										<td rowspan="2">$price_business</td>
										<td rowspan="2">										
											<button type="submit" value="$flight_number" name="number" class="button_online">Изменить</button>					
										</td>		
									</tr>	
									<tr>
										<td>$flight_to</td>
										<td>$time_down</td>										
									</tr>
_END;
	    					}
       						
	      						
	      						echo "</table></form>";	
	      				
								
								
					if(isset($_POST['chande_old']) or isset($_POST['chande_new']))
					{	

						$flight_number =  $flight_from = $flight_to = $time_up  = $time_down = $time_flight = $price_economy = $price_standard = $price_business = "";
						echo "<div class='found_form'>";	
						if(isset($_POST['chande_old']))
						{		
							echo "chande_old";					
							$flight_number = $_POST['flight_number'];
							$query  = "SELECT * FROM flights WHERE flight_number = '$flight_number'";
							$result = queryMysql($query);
	    					$num    = $result->num_rows;
	
	    					$row = $result->fetch_array(MYSQLI_ASSOC);      						
      						$flight_number = $row['flight_number'];      						
      						$flight_from = $row['flight_from'];
      						$flight_to = $row['flight_to'];
      						$time_up = $row['time_up'];
      						$time_down = $row['time_down'];
							$time_flight = $row['time_flight'];	      							      						
							$price_economy = $row['price_economy'];									
							$price_standard = $row['price_standard'];
							$price_business = $row['price_business'];
						echo<<<_END
						
						<table class="table_online">
							<tr>
								<th>Рейс</th>
								<th>Откуда</th>
								<th>Куда</th>
								<th>Вылет</th>
								<th>Прилет</th>
								<th>В пути</th>
								<th>Эконом</th>
								<th>Стандарт</th>
								<th>Бизнес</th>
							</tr>
							<tr>
								<td>$flight_number</td>
								<td>$flight_from</td>
								<td>$flight_to</td>
								<td>$time_up</td>
								<td>$time_down</td>
								<td>$time_flight</td>
								<td>$price_economy</td>
								<td>$price_standard</td>
								<td>$price_business</td>
							</tr>
						</table>
_END;
					
						}
						
						
						
						
		
						echo<<<_END

						<div>
						</div>
				
										
				<div class="parentbox">	
					<form method="POST">
						<input type="hidden" name="flight_number_old" value="$flight_number">						
						<hr class="hr_search_tickets top_margin">	
						<div class="inline_block">
							<h3>Номер рейса</h3>
							<input type="number" class="input width_4" name="flight_number" placeholder="Только цифры?"  value = "$flight_number" autocomplete="off" required>			
						</div>														
						<div class="inline_block">
							<h3>Город вылета</h3>
							<input type="text" class="input width_4" name="flight_from" placeholder="Откуда?"  value = "$flight_from" autocomplete="off" required>						
						</div>																		
						<div class="inline_block">
							<h3>Город назначение</h3>
							<input type="text" class="input width_4" name="flight_to" placeholder="Куда?"  value = "$flight_to" autocomplete="off" required>						
						</div>		
						<div class="clear_both"></div>	
						<div class="date_from inline_block">
							<h3>Вылет</h3>
							<input type="time" name="time_up" class="input width_4" value="$time_up"  required>
						</div>				
						<div class="date_to inline_block" id="date_to_id">
							<h3>Прилет</h3>
							<input type="time" name="time_down" class="input width_4" value="$time_down" required>
						</div>
						<div class="date_from inline_block">
							<h3>В пути</h3>
							<input type="time" name="time_flight" class="input width_4" value="$time_flight"  required>
						</div>					
						<div class="clear_both"></div>	
						<div class="date_from inline_block">
							<h3>Эконом цена</h3>
							<input type="number" name="price_economy" class="input width_4" value="$price_economy"  required>
						</div>				
						<div class="date_to inline_block" id="date_to_id">
							<h3>Стандарт цена</h3>
							<input type="number" name="price_standard" class="input width_4" value="$price_standard"  required>
						</div>
						<div class="date_from inline_block">
							<h3>Бизнес цена</h3>
							<input type="number" name="price_business" class="input width_4" value="$price_business"  required>
						</div>					
						<div class="clear_both"></div>		
_END;
						if(isset($_POST['chande_new']))
						{
							$type = "new";
						}	
						elseif(isset($_POST['chande_old']))
						{
							$type= "old";
						}
						echo<<<_END
						<div>
							<input type="submit" class="button" name = $type value="Сохранить">							
						</div>
					</form>
				</div>	
				</div>
				<div class="clear"></div>
_END;
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