<script src="../javascript/md5.min.js"></script>
<script src="../javascript/auth2.js"></script>
<header class="header">
	<div class="middle">
		<div class="">				
			<div class="logo" id="left">
				<a href="index.php">
	        		<img src='../images/3.png' alt="Логотип сайта" title="Главная страница" onmouseover="this.src='../images/2.png'" onmouseout="this.src='../images/3.png'" border="0">
	      		</a>		
			</div>	
			<?php
				if (isset($_SESSION['user_id']))
				{
			    	$user_id     = $_SESSION['user_id'];
			    	$loggedin = TRUE;				    	
			  	}
  				else $loggedin = FALSE;

  				if ($loggedin)
  				{
  					echo <<<_END
  					<div class="account login" id="right">  	      		
	      				<a class="account_in" href="../php/account.php">Личный кабинет</a>     
	      	 			<a class="account_img" href="../php/account.php"></a>	      	 			
	      	 			<a class="submit in" href="../php/exit.php">Выйти</a>												
					</div>
_END;

  				
  				}
  				else
  				{
  					echo <<<_END
			      	<div class="topmenu">
						<aside class="login">
							<form method="post" action="login.php" onsubmit="ajax2(this)">
								<input type="text" name="username" id="username2" placeholder="Логин" class="input width_header" required pattern="[a-zA_Z0-9._]{5,}" title="Не менее 5 символов, содержащих символы из нижнего или верхнего регистра, цифры и символы '_', '.'">
								<input type="password" name="password" id="password2" placeholder="Пароль" class="input width_header" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Не менее восьми символов, содержащих хотя бы одну цифру и символы из верхнего и нижнего регистра.">														
								<input type="submit" value="Войти" class="submit">
							</form>
						</aside>								
						<aside class="logup">
							<a href="../php/registration.php">Регистрация</a>												
						</aside>
					</div>
_END;
  				}
			?>	
		</div>
	</div>
</header>