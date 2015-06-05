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
	<script src="http://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript">
$(function(){
    var url = window.location.pathname.split("/");
    var menuItems = $('.menu ul li a');
    var activated = false;

    while(url.length) {
        u = url.join("/");
        menuItems.each(function() {
            if(u === this.pathname){
                $(this).parent().addClass('selected');
                activated = true;
            }
        });

        if (activated) {
            break;
        } else {
            url.pop(); // remove "" element
            url.pop();
            url.push(""); // add "" element
        }
    }
});
</script>
	<script>
var myCenter=new google.maps.LatLng(60.007357,30.37289);

function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:15,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker=new google.maps.Marker({
  position:myCenter,
  });

marker.setMap(map);

var infowindow = new google.maps.InfoWindow({
  content:"Санкт-Петербург, ул.Политехническая, д.29, Airlife Company."
  });

infowindow.open(map,marker);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>
<body>
<div class="page-wrapper">
<?php 
	require_once "header.php";
	require_once "menu.php";
	require_once "functions.php";
?>
<section class="content">
		<div class="middle">
			<div class="fon">
				<div class="found_form none_margin">
					<h2>Информация о нас</h2>
					<h3>Мы на карте</h3>
					<div>Адрес: г.Санкт-Петербург, ул.Политехническая, д.29</div>
					<h3>Телефон</h3>
					<div>8-800-333-22-11</div>
				</div>
				<div id="googleMap" style="width:920px;height:400px;"></div>
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