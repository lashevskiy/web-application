<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="description" content="This is an HTML5 example">
  <meta name="keywords" content="HTML5, CSS3, JavaScript">
  <title>Best Airline</title>
  <link rel="shortcut icon" type="image/x-icon" href="../images/icon.png">
  <link rel="stylesheet" type="text/css" href="../css/style.css" media="all">   
  <script src="../javascript/jquery-1.11.3.min.js"></script> 
 
<script>
function showResult(obj) {
 
var str = obj.value; 
var name = obj.name;

alert(name);

var params='type=' + encodeURIComponent(name) + '&q=' + encodeURIComponent(str);

  if (str.length==0) { 
   
    return;
  }
  else if(str.length>0)
  {
        alert(str);
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

  
<?php
    require_once "functions.php";
   
?>      
        <datalist id='flight_from'></datalist>
        <input type='text' name='flight_from' list='flight_from' placeholder='Откуда' onkeypress='showResult(this)' autocomplete='off'>
       
        <datalist id="flight_to"></datalist>
        <input type="text" name="flight_to" list="flight_to" placeholder="Куда" onkeypress="showResult(this)" autocomplete="off">


</body>
</html>