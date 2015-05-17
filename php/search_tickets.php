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

    //document.getElementById("livesearch").innerHTML="";    
    //document.getElementById("livesearch").style.border="0px";
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

  
<?php
    require_once "functions.php";
    //echo "<datalist id='flight_from_list'>";
        //$query = "SELECT DISTINCT flight_from FROM flights";
        //$result = queryMysql($query);
        //$num    = $result->num_rows;                    
        //for ($j = 0 ; $j < $num ; ++$j)
        //{       
        //    $row = $result->fetch_array(MYSQLI_ASSOC);                              
        //                    
        //    echo "<option value=".$row['flight_from']." label=".$row['flight_from'].">";                
        //}   
   //     echo "</datalist>";


  //echo  "<input type='text' name='flight_from' list='flight_from_list' placeholder='Откуда'' onkeyup='showResult(this)' autocomplete='off'>";
 //echo "<br>";

?>      
        <datalist id='flight_from'></datalist>
        <input type='text' name='flight_from' list='flight_from' placeholder='Откуда' onkeypress='showResult(this)' autocomplete='off'>
       
        <datalist id="flight_to"></datalist>
        <input type="text" name="flight_to" list="flight_to" placeholder="Куда" onkeypress="showResult(this)" autocomplete="off">


</body>
</html>