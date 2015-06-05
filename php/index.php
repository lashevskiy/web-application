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
		
</head>
<body>
<div class="page-wrapper">
	<?php 
		require_once "../php/header.php";	
		require_once "../php/menu.php";
	?>
			
	<section class="content">
		<div class="middle">
			<div class="fon">
				<div class="block">
					<a href="#">
						<div class="anons">
							<section>
								<img src="../images/1.jpg" width="400" height="225" alt="Анимация1">
								<h3>Купить билеты дешево.</h3>
								<p>У нас самые дешевые билеты. Покупай срочно!</p>
							</section>
						</div>
					</a>
				</div>
				<div class="block">
					<a href="#">
						<div class="anons">
							<section>
								<img src="../images/03.jpg" width="400" height="225" alt="Анимация2">
								<h3>Купить билеты дешево. Быстро.</h3>
								<p>У нас самые дешевые билеты. Покупай срочно!</p>
							</section>
						</div>
					</a>
				</div>
				<div class="block">
					<a href="#">
						<div class="anons">
							<section>
								<img src="../images/04.jpg" width="400" height="225" alt="Анимация1">
								<h3>Здесь могла быть ваша реклама</h3>
								<p>Описание вашего товара будет здесь</p>
							</section>
						</div>
					</a>
				</div>
				<div class="block">
					<a href="#">
						<div class="anons">
							<section>
								<img src="../images/1.jpg" width="400" height="225" alt="Анимация1">
								<h3>Купить билеты дешево</h3>
								<p>У нас самые дешевые билеты. Покупай срочно!</p>
							</section>
						</div>
					</a>
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