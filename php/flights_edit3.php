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

	$flight_number =  $flight_from = $flight_to = $time_up  = $time_down = $time_flight = $price_economy = $price_standard = $price_business = $msg = "";					

					if (isset($_POST['new']))
					{									
						$flight_number = $_POST['flight_number'];						
						$flight_from = $_POST['flight_from'];		
						$flight_to = $_POST['flight_to'];
						$time_up = $_POST['time_up'];
						$time_down = $_POST['time_down'];
						$time_flight = $_POST['time_flight'];
						$price_economy = $_POST['price_economy'];
						$price_standard = $_POST['price_standard'];
						$price_business = $_POST['price_business'];

						$query = "SELECT * FROM flights WHERE flight_number = '$flight_number'";
						$result = queryMysql($query);
						$num    = $result->num_rows;	

						if($num != 0)
						{
							$msg = "<h3>Рейс с таким номером уже существует. Попробуйте выбрать другой номер.</h3>";
						}
						else 
						{
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
							$msg = "<h3>Данный рейс успешно добавлен.</h3>";
						}

						
						
							
					}					
					

					
echo<<<_END
<section class="content">
	<div class="middle">
		<div class="fon">	
			<div class='found_form'>
				<div class="parentbox">	
					<form method="POST">
						<div class="info">
							<h2>Новый рейс</h2>
							<h3>На этой странице вы можете:</h3>
							<ul>													
								<li>Добавить новый рейс</li>
							</ul>
						</div>
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
						<div>$msg</div>
						<div>
							<input type="submit" class="button" name = "new" value="Сохранить">							
						</div>
					</form>
				</div>	
			</div>
			<div class="clear"></div>
_END;
					
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