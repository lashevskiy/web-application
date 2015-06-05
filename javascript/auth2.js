 function ajax2(form) {
        
        
        if(window.XMLHttpRequest){
            xmlhttp=new XMLHttpRequest();
        }
        else{
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
    
            if(xmlhttp.readyState==1){
                //document.getElementById('submit').value='Пожалуйста подождите...';
                
            }
            if(xmlhttp.readyState==4 && xmlhttp.status==200){
                
                var str=xmlhttp.responseText;

                if(str!='error'){                                                                                                                    
                
                
                    document.getElementById('password2').value=md5(md5(md5(document.getElementById('password2').value))+str);                                                       
                
                    //https://github.com/blueimp/JavaScript-MD5                   
                    
                }                
            }
            else{
                
            }
        }
        in_post='username='+document.getElementById('username2').value;
        xmlhttp.open("POST","ajax_auth.php",false);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;charset=UTF-8");
        xmlhttp.send(in_post);
    }