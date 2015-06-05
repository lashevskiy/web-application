<?php
	if (isset($_SESSION['admin']) and $_SESSION['admin'] == true) 
	{
echo<<<_END
<div class="middle">				
	<div class=" admin_menu">
		<nav class="menu">
			<ul
				><li><a href="flights_edit2.php">Рейсы</a></li				
				><li><a href="flights_edit3.php">Новый рейс</a></li
                ><li><a href="schedule_edit.php">Расписание</a></li                
                ><li><a href="schedule_edit3.php">Изменить расписание</a></li
			></ul>
		</nav>	        
    </div>       
</div>
_END;
	}
?>