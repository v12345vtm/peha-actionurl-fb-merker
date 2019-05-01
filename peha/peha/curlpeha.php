<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
<"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Action-C-url</title>
     
    </head>
<body>  
 <?php 
function testt(){
	
	echo "<BR>testfunctie die niks doet of hierboven debug info toont";
}
function sendtopeha($parameterurl)
{ 
  // Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $parameterurl  ,
	 CURLOPT_HEADER => "Access-Control-Allow-Origin: *" ,
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
]);
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl); 
echo "*******" ;
echo $resp ; 
echo "*******" ;
 }
 ?>  
   <!-- toon de waardes die un config.inc zitten-->
<?php
//include('config.inc');

	
		 if (isset($_GET['submit']) ){
 $ipadres =$_GET['ipadres'];
	  $poort =$_GET['poort'];
	   $stm =$_GET['stm'];
	    $module =$_GET['module'];
		 $channel =$_GET['channel'];
		  $event =$_GET['event'];
echo	 "<font color=\"red\"> parameters voor actionurl@80: "  ; 	   
	 echo $ipadres . " " ;
	echo  $poort . " ";
	 echo  $stm . " " ;
	  echo  $module . " " ;
		echo $channel . " " ;
		echo  $event . " " ;		
	echo 	"</font> <br> " ; 

$template =   "http://" .  $ipadres    . ":" . $poort  . "/postEvent.html?action=input&STM=". $stm     . "&MOD="  . $module . "&CHA=" . $channel .  "&EVT="   .  $event   ;


	echo "<hr>" .  $template . "<hr> " ;
testt();
sendtopeha($template);

	 }

?>





<p><a href="curlpeha.php  ">curlpeha.php</a>werk php die actionurl stuurt</p>
<p><a href="curlpeha.html  ">curlpeha.html</a>GUI met knoppen</p>
<p><a href="fb6680.php  ">fb.php</a>php die aan poort 6680 fb vraagt</p>
     
 <form id="form1" name="form1" method="get" action="">  
 livingbol   formaat vd actionurl : http://192.168.1.2:80/postEvent.html?action=input&STM=0&MOD=0&CHA=0&EVT=2  <hr>
 grootraamled : k="hitEndpoint('http://192.168.1.2:80/postEvent.html?action=input&STM=0&MOD=0&CHA=3&EVT=2')">IMD.00.03 - LIVING  :knop  E  orange : grootraam 	<hr>
	
	
	 
<label>IP (via config.inc geinitialiseerd)
       <input name="ipadres" type="text" id="ipadres" value="192.168.1.2" />
     </label>
	  <br>
	 	<label>poort
       <input name="poort" type="text" id="poort"  value="80" />
     </label>
 <br>
	<label>stm(0-7)
       <input name="stm" type="text" id="stm" value="0" />
     </label>
   <br>
     <label>module (0-255)
       <input name="module" type="text" id="module" value="0" />
     </label>
	 
    <br>
	 <label>channel (0-16)
     <input name="channel" type="text"   id="channel" value="0" /> 
    </label>
	
	    <br>
	 <label>event (knopgedrag)
     <input name="event" type="text"   id="event" value="2" /> 
    </label>
  
    <br>
	 <br>
     <label>submit
       <input type="submit" name="submit" id="submit" value="Submit" />
     </label>
  
   <p>
action-url generator  : and deze pagina doet een request via http naar de stm module van de peha (CURL installeren op de raspi !!)

   </p>
   <p>&nbsp;</p>
</form>
  
   
  
  
</body>
</html>