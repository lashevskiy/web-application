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
//  					echo<<<_OUT
//  			
//                <div class="right_exit">                
//                	<a class="submit" href="exit.php">Выйти</a>
//                </div>												
//				<div id="menu_body">
//                    <ul>
//                        <li>
//                            <div class="avatar-in-header">                            	
//                            	<img class="round" src="/MySite/images/12.png">                            	
//                            </div>
//                            <ul>
//                            	<li><a href="account.php">Личные данные</a></li>
//                                <li><a href="my_tickets.php">Мои бронирования</a></li>                               
//                            </ul>
//                        </li>
//                    </ul>
//                </div>
//            
//
//_OUT;

  				
  				}
  				else
  				{
  					echo <<<_END
			      	<div class="topmenu">
						<aside class="login">
							<form method="post" action="login.php">
								<input type="text" name="username" placeholder="Логин" class="input width_header" required>
								<input type="password" name="password" placeholder="Пароль" class="input width_header" required>						
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