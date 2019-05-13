<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>via 6680xml stringcommand</title>
</head>

<body>
 
 <?php 
//      http://192.168.1.6/ir?code=33448095
 


function testt(){
	
	echo "iuil";
}


function sendtopeha()
{ 
    try  
    {  
     // do something that can go wrong  
	 $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);	
	   socket_set_option($socket,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>1,"usec"=>0)); //updata timeout  1sec als peha de moxa niet beanwoord van feedback  vith7sept2014 brugie
$result = socket_connect($socket, "192.168.1.2" ,6680);	
socket_write($socket, "<methodCall><methodName>service.stm.simInputEvent</methodName><params><param><value><i4>0</i4></value></param><param><value><i4>0</i4></value></param><param><value><i4>0</i4></value></param><param><value><i4>2</i4></value></param><param><value><i4>4</i4></value></param></params></methodCall>");

socket_recv($socket, $result_message, 2048, MSG_WAITALL);
socket_close($socket);	
 echo  $result_message;
return $result_message;//=header http 200 ok +xml string}
    }  
    catch (Exception $e)  
    {  
     throw new Exception( 'Something really gone wrong', 0, $e);  
    }  
 }

 ?>
  
   <!-- toon de waardes die un config.inc zitten-->

<?php //include('buttons.php'); //functies php  ?>
<?php
	 if (isset($_GET['submit']) ){
 $stm =$_GET['stm'];
$modadres=$_GET['module'];
$kanaal=$_GET['kanaal'];


echo "<br /><h2><div id=\"feedbackbit\">$kanaal</div></h2><br />";// kanaal

testt();
sendtopeha();




	 }

 

	

	
?>
   
  
 <form id="form1" name="form1" method="get" action="">
   <p>
     <label>stm(0-7)
       <input name="stm" type="text" id="stm" value="0" />
     </label>
   (goed invullen in config.inc)</p>
   <p>
     <label>module (0-255)
       <input name="module" type="text" id="mod" value="64" />
     </label>
   ingang0 , multi32 , uitgang64 , analoog96 , box128 , dim160</p>
   <p>kanaal (0-1)of (0-32)of (0-7)  
     <input name="kanaal" type="text"   id="kanaal" value="0" /> 
   (deze parameter word gebruikt in een functie om het antwoord te filteren van 255 naar 00001111 )</p>
   <p>
     <label>c1 feedbackconstante =1
       <input name="c1" type="text" disabled="disabled" id="c1" value="1" />
     </label>
   </p>
   <p>
     <label>submit
       <input type="submit" name="submit" id="submit" value="Submit" />
     </label>
   </p>
   <p>uitleg pagina , : deze pagina maakt het tcp commando om feedback te vragen aan de peha , en uit het andwoord van peha , gaan we filteren welk kanaal men wil<br />
     dit is dan een 0of 1 of (0-255 bij dimmers)<br />
     die waarde tonen we in deze pagina , zodat ajax die opgeroepen word in index.php, dit kan gebruiken , en op zijn beurt kan 
   info op index.php zetten dmv getElementbyID , </p>
   <p>&nbsp;</p>
</form>
  
   
  
  
</body>
</html>