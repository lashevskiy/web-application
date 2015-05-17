<div class="menu">				
	<div class="middle">
		<nav>
			<ul
				><li><a href="../php/main.php">Главная</a></li
				><li><a href="../php/tickets.php">Авиабилеты</a></li
				><li><a href="../php/online.php">Табло рейсов</a></li
				><li><a href="../php/flights.php">Информация о рейсах</a></li
				><li><a href="../php/about_us.php">О нас</a></li
			></ul>
		</nav>	
	</div>
</div>
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
	//$("div.menu li").each(function func () {
	//	var link = location.href;		
	//	if (this.getElementsByTagName("a")[0].href == link) 
	//		this.className = "selected";
	//});

</script>