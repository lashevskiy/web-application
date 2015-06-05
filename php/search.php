<?php
    require_once "functions.php";
	
	
	if (isset($_GET['q'])) 
	{		
		$name = $_GET['type'];		
		$data = '%'.$_GET['q'].'%';
		$data2 = '%'.mb_strtolower($_GET['q']).'%';
		
		
		
		$query = "SELECT DISTINCT $name FROM flights WHERE $name LIKE '$data'";

		$result = queryMysql($query);
   		$num    = $result->num_rows;     		
				
			for ($j = 0 ; $j < $num ; ++$j)
			{		
				$row = $result->fetch_array(MYSQLI_ASSOC);      						
								
				echo "<option value=".$row[$name]." label=".$row[$name].">";				
			}	
	}	
	
?>