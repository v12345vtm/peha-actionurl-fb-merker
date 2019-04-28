<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
<"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Action-C-url-merker</title>
     
    </head>

<body>
  <?php 
function testt(){
	
	////echo   "<BR>testfunctie die niks doet of hierboven debug info toont";
}
function sendURLtopeha($parameterurl)
{ 

////echo   "<BR>starting CURL request to peha@80";
////echo   $parameterurl ;
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
////echo   "*******" ;
////echo   $resp ; 
////echo   "CURL BEIINDIGD" ;
 }
 ?> 
 <?php 
//
function fbvragen3($ip , $stm , $module )
{// xml fb opvragen

$data= '<methodCall><methodName>service.stm.sendTelegram</methodName><params><param><value><i4>'.  $stm .'</i4></value></param><param><value><i4>'.  $module .'</i4></value></param><param><value><i4>'.  "1" .'</i4></value></param></params></methodCall>';
$xmlrespons = sendtopeha($ip , $data);// naar peha sturen en respons XML binnennemen
$module = (int)$module ; //string naar integer
//echo   ("</br>fbDOTphp met funtie:fbvragen3"." ipadres ".$ip." module".$module);

if (strstr($xmlrespons , "faultCode"))
		{return "error commando";
		 }
 else{
$ters= decodeerxml3($xmlrespons , $module);// vb 2dimmer wardes van een module vb 255;255
 }
return $ters; //we geven de uitdraai van de functie door..vb 000000001
  
}

 


function fbvanMerkervragen($ip , $stm , $merker )
{// xml fb merker opvragen
//$merkertemplate= ' <methodCall><methodName>service.stm.getMarker</methodName><params><param><value><i4>'.  $stm .'</i4></value></param><param><value><i4>2</i4></value></param><param><value><i4>'.  $merker . '</i4></value></param></params></methodCall> ';

$data= ' <methodCall><methodName>service.stm.getMarker</methodName><params><param><value><i4>'.  $stm .'</i4></value></param><param><value><i4>2</i4></value></param><param><value><i4>'.  $merker . '</i4></value></param></params></methodCall> ';

$xmlrespons = sendtopeha($ip , $data);// naar peha sturen en respons XML binnennemen
$module = (int)$module ; //string naar integer
 //echo   ("</br>fbvanMerkervragen met funtie:fbvanMerkervragen"." ipadres ".$ip." merker".$merker);
 
 //echo  "</br>" .  $xmlrespons  . "<hr>" ;

if (strstr($xmlrespons , "faultCode"))
		{return "error commando";
		 }
 else{
$ters= decodeerxmlMerker($xmlrespons );// vb 2dimmer wardes van een module vb 255;255
 }
return $ters; //we geven de uitdraai van de functie door..vb 000000001
  
}






function decodeerxmlMerker ($xmlrespons )
{
 //opkuisen xml , xml uitfilteren , eerst de kop eraf dmv substring , en dan xml parsen
$s =substr($xmlrespons,148 +43+12 + 52 , 1);   //gewoon het zoveelste karakter gaan uitpikken uit de xml respons
echo "hiertussen".  $s. "merkerwaarde";
return $s;
}



function decodeerxml3 ($xmlrespons , $modulenummer)
{
 //opkuisen xml , xml uitfilteren , eerst de kop eraf dmv substring , en dan xml parsen
$s =substr($xmlrespons,148 +43+12);   
//////echo   $s. "waardes";
// Create new DomDocumetn object
$dom = new DOMDOcument();
// Load your XML as a string
$dom->loadXML($s);
// Create new XPath object
$xpath = new DOMXpath($dom);
// Query for Account elments inside NewDataSet elemts inside string elements
 $result = $xpath->query("/methodResponse/params/param/value/array/data");
// Note there are many ways to query XPath using this syntax
// Iterate over the results met de foreach 

// adhv modulenr gaan we kijken hoe we de fb moeten aanpakken 
if ($modulenummer >=0 && $modulenummer <=0+31)
		{
		//ingangen hebben 16knopstatussen en 16ledjes-statussen
		////echo   ("</br> tussen de 0 en 32 is ingang");
		foreach($result as $node){
    // Obtains item zero, this is the first item for any elements with the name
    // GUID and var_dump the nodeValue for that element
	//http://stackoverflow.com/questions/4721956/handling-xml-using-php
    //var_dump($node->getElementsByTagName("i4")->item(4)->nodeValue);
	$lowinput = ($node->getElementsByTagName("i4")->item(5)->nodeValue); //0.0 tot 0.7
	$highinput = ($node->getElementsByTagName("i4")->item(6)->nodeValue);//0.8 tot 0.15
	$lowled = ($node->getElementsByTagName("i4")->item(4)->nodeValue); //0.0 tot 0.7
	$highled = ($node->getElementsByTagName("i4")->item(7)->nodeValue);//0.8 tot 0.15
	}//end foreeach
	
	$lowinput =  int2bits($lowinput);
	$highinput =  int2bits($highinput);
	$lowled =   int2bits($lowled);
	$highled =   int2bits($highled);
	return $lowinput.$highinput.";".$lowled.$highled.";";
		}
		
if ($modulenummer >=32 && $modulenummer <=32+31)
		{
		// statussen multi
		////echo   ("</br> multi 32 niet geprogrameerd in fb.php");
				foreach($result as $node){
				//niet geanaliseerd met peha
	//$lowinput = ($node->getElementsByTagName("i4")->item(0)->nodeValue); //0.0 tot 0.7
	//$highinput = ($node->getElementsByTagName("i4")->item(0)->nodeValue);//0.8 tot 0.15
	//$lowled = ($node->getElementsByTagName("i4")->item(0)->nodeValue); //0.0 tot 0.7
	//$highled = ($node->getElementsByTagName("i4")->item(0)->nodeValue);//0.8 tot 0.15
	}//end foreeach
	return true;
		}
		
if ($modulenummer >=64 && $modulenummer <=64+31)
		{
		//uitgangen hebben 8uitgangen oude modullen ziten met feedback op byte5
		////echo   ("</br> tussen de uitgang 64");
						foreach($result as $node){
						$outputstatus = ($node->getElementsByTagName("i4")->item(4)->nodeValue); //0.0 tot 0.7
							//moester een nieuwe types inzitten van outputmodules moeten we volgende byte nemen
						if($node->getElementsByTagName("i4")->item(5)->nodeValue != null)
							{$outputstatus = ($node->getElementsByTagName("i4")->item(5)->nodeValue);}
						
						}//end foreeach






$outputstatus = int2bits($outputstatus);
return $outputstatus;
		}
		
if ($modulenummer >=96 && $modulenummer <=96+31)
		{
		//niet getest op analoge modules
		////echo   ("</br> tussen de 96analoog niet geprogrameerd in fb.php");
						foreach($result as $node){
	//$lowinput = ($node->getElementsByTagName("i4")->item(0)->nodeValue); //0.0 tot 0.7
	//$highinput = ($node->getElementsByTagName("i4")->item(0)->nodeValue);//0.8 tot 0.15
	//$lowled = ($node->getElementsByTagName("i4")->item(0)->nodeValue); //0.0 tot 0.7
	//$highled = ($node->getElementsByTagName("i4")->item(0)->nodeValue);//0.8 tot 0.15
	}//end foreeach
	return true;
		}
		
if ($modulenummer >=128 && $modulenummer <=128+31)
		{
		//ingangen hebben 16knopstatussen en 16ledjes-statussen
		////echo   ("</br> box128 niet geprogrameerd in fb.php");
		
		//modules niet getest met peha systeem
						foreach($result as $node){
//	$lowinput = ($node->getElementsByTagName("i4")->item(0)->nodeValue); //0.0 tot 0.7
	//$highinput = ($node->getElementsByTagName("i4")->item(0)->nodeValue);//0.8 tot 0.15
	//$lowled = ($node->getElementsByTagName("i4")->item(0)->nodeValue); //0.0 tot 0.7
	//$highled = ($node->getElementsByTagName("i4")->item(0)->nodeValue);//0.8 tot 0.15
				}//end foreeach
				return true;
		}
		
if ($modulenummer >=160 && $modulenummer <=160+31)
		{
		//ingangen hebben 16knopstatussen en 16ledjes-statussen
		////echo   ("</br> 160dim");
						foreach($result as $node){
	$dimmernul = ($node->getElementsByTagName("i4")->item(4)->nodeValue); //0.0 tot 0.7
	$dimmereen= ($node->getElementsByTagName("i4")->item(5)->nodeValue);//0.8 tot 0.15
		}//end foreeach
		return $dimmernul.";".$dimmereen;
		}
}


function int2bits($decimaalgetal)
{
//in = 255
//out = 11111111
//in = 1
//out = 00000001
$decimaalgetal = intval($decimaalgetal);
 //eerst fb omzetten naar binair
 $decimaalgetal =$decimaalgetal + 256;//foefje om altijd minstens 8bits in de stringt hebben , en zo geen voorloopnullen te moeten genereren
	$decimaalgetal =   decbin($decimaalgetal);
//////echo   ("</br>INT2BITS");	
//////echo   ($decimaalgetal); 
//////echo   ("</br>INT2BITS");
$test =  substr($decimaalgetal, 1);  // 9bits code , 1e bit wegdoen 
//swappen volgorde links is dan 0.0  rechts is dan 0.15
$omgekeerd = strrev($test);
return $omgekeerd;
}



 ?>
  
   <!-- toon de waardes die un config.inc zitten-->

<?php include('config.inc'); //settings?>
<?php include('functions.php'); //functies php  ?>

<?php
	 if (isset($_GET['submit']) ){
		 
		 			 ///variabelen die naar poort 80 als action url verzonden worden
 $ipadresactionurl =$_GET['ipadresactionurl'];
	  $poortactionurl =$_GET['poortactionurl'];
	   $stmactionurl =$_GET['stmactionurl'];
	    $moduleactionurl =$_GET['moduleactionurl'];
		 $channelactionurl =$_GET['channelactionurl'];
		  $eventactionurl =$_GET['eventactionurl'];
		  
		   ///nu voor variabelen voor de fbmerker aan te vragen via poort 6680
		 $merkernr =$_GET['merkernr'];
		  $merkerstm =$_GET['merkerstm'];
		  
		  
		  ///nu voor variabelen voor de fb aan te vragen via poort 6680		 		 		 
 $fbstm =$_GET['fbstm'];
$fbmodule=$_GET['fbmodule'];
$fbkanaal=$_GET['fbkanaal'];


		  
		 ///nu voor variabelen voor welk form ze gedrukt hebben
		 $formfactor =$_GET['submit'];  
		  
		  
		  
//echo    	 "<font color=\"brown\"> welke form werd gedrukt?: "  ; 	   
//echo     $formfactor . " " ;

//echo     	"</font> <br> " ; 


		  
//echo    	 "<font color=\"red\"> parameters voor actionurl@80: "  ; 	   
//echo     $ipadresactionurl . " " ;
//echo      $poortactionurl . " ";
//echo      $stmactionurl . " " ;
//echo      $moduleactionurl . " " ;
//echo     $channelactionurl . " " ;
//echo      $eventactionurl . " " ;		
//echo     	"</font> <br> " ; 
	
//echo    	 "<font color=\"pink\"> parameters voor merker : "  ; 
//echo      $merkerstm . " " ;
//echo     $merkernr . " " ;
//echo     	"</font> <br> " ; 	
	
	
//echo    	 "<font color=\"green\"> parameters voor fb : "  ; 
//echo      $fbstm . " " ;
//echo     $fbmodule . " " ;
//echo      $fbkanaal . " " ;
//echo     	"</font> <br> " ; 



		
 ///variabelen die naar poort 80 als action url verzonden worden
 
	//we hebben 3 soorten templates : actionurl , merkerstatus , feedbackstatus
$actionurltemplate =   "http://" .  $ipadresactionurl    . ":" . $poortactionurl  . "/postEvent.html?action=input&STM=". $stmactionurl     . "&MOD="  . $moduleactionurl . "&CHA=" . $channelactionurl .  "&EVT="   .  $eventactionurl   ;

$merkertemplate= ' <methodCall><methodName>service.stm.getMarker</methodName><params><param><value><i4>'.  $stm .'</i4></value></param><param><value><i4>2</i4></value></param><param><value><i4>'.  $merker . '</i4></value></param></params></methodCall> ';

$fbtemplate= '<methodCall><methodName>service.stm.sendTelegram</methodName><params><param><value><i4>'.  $fbstm .'</i4></value></param><param><value><i4>'.  $fbmodule .'</i4></value></param><param><value><i4>'.  "1" .'</i4></value></param></params></methodCall>';



////////////////////////
if ($formfactor == "actionurl"  ) {
    //echo  "gui wil actoin url doen";
	
	sendURLtopeha($actionurltemplate); //req via action url op poort 80 , de http interface van peha


//$actionurltemplate = $actionurltemplate  ; 
$modadres =  "n.v.t." ; 
$modulestatus =  "n.v.t." ; 
$kanaalstatus =  "n.v.t." ; 
$merkerstatus =  "n.v.t." ; 
//$formfactor  = $formfactor;
 




}
//////////////////////////
if ($formfactor == "merker"  ) {
    //echo  "gui wil merker weten";	
	
	//echo      $merkerstm . " " ;
//echo     $merkernr . " " ; 


		inputcontrolestm($fbstm);//controleer of het (0-7) is
if (inputcontrolestm($fbstm)==true)
{
  $merkerstatus = fbvanMerkervragen($ip[$merkerstm],$stmadres[$merkerstm],$merkernr);// req to port 6680 :  modulestatus is vb : "00000000"
echo "<H1>" .$merkerstatus ."</H1>"  ;
  
  $actionurltemplate = "n.v.t."  ; 
$modadres =  "n.v.t." ; 
$modulestatus =  "n.v.t." ; 
$kanaalstatus =  "merkernr" . $merkernr ; 
//$merkerstatus =  $merkerstatus ; 
//$formfactor  = $formfactor;
  
  
  
  } 
else
{

 $actionurltemplate = "error merker php"  ; 
$modadres =  "error merker php" ; 
$modulestatus =  "error merker php" ; 
$kanaalstatus =  "error merker php"  ; 
$merkerstatus =  "error merker php" ; 
$formfactor  = "error merker php";
}
}//einde merker selectie

////////////////////////////////////////////
if ($formfactor == "fb"  ) {
    //echo  "gui wil fb weten van een module";
	
	
	//echo      $fbstm . " " ;
//echo     $fbmodule . " " ;
//echo      $fbkanaal . " " ;


	inputcontrolestm($fbstm);//controleer of het (0-7) is
if (inputcontrolestm($fbstm)==true)
{
  $modulestatus = fbvragen3($ip[$fbstm],$stmadres[$fbstm],$fbmodule);// req to port 6680 :  modulestatus is vb : "00000000"

  $kanaalstatus = $modulestatus[$fbkanaal] ;// nulde od 1e karakter , wat je maar wil
  
  
    $actionurltemplate = "n.v.t."  ; 
$modadres =  $fbmodule ; 
//$modulestatus = $modulestatus; 
//$kanaalstatus =  $kanaalstatus ; 
$merkerstatus =  "n.v.t." ; 
//$formfactor  = $formfactor;
  
  
  
  } 
else
{

 $actionurltemplate = "error feedback vragen php"  ; 
$modadres =  "error feedback vragen php" ; 
$modulestatus =  "error feedback vragen php" ; 
$kanaalstatus =  "error feedback vragen php"  ; 
$merkerstatus =  "error feedback vragen php" ; 
$formfactor  = "error feedback vragen php";
}
}	
	
testt();





echo "<H2>" .$merkerstatus ."</H2>"  ;
////////echo     "<br /><h2><div id=\"feedbackbit\">$kanaalstatus</div></h2><br />";// kanaal	
////////echo     "<br />modulestatus = $modulestatus modulestatusstop <br />"; //  0,0,0,0,0,0,0,0,1
////////echo     "<br />kanaalstatus =  $kanaalstatus kanaalstatusstop<br />";// kanaal 0 is  0 of 1 of een waarde tussen 0en 255 , voor ajax
////////echo     "dimmer is 2 waardes , uitput heeft 8waardes , input 24waardes</br>";
////////echo     "nulde bit is relais0.0 , bij input i0 tot i7 , en dan de ledjes led0 tot led7<br />";
////////echo     "respons : stmadres , modadres , aantal bytes die volgen(en toggele bitje die je mag negeren),constante1?, feedback,.... ,<br />";
header("f-verzondenactionURL:"   . $actionurltemplate );
header("fb-van-module:"   . $modadres );
header("fb-modulestatus:"   . $modulestatus );
header("fb-kanaalstatus:"   . $kanaalstatus );
header("fb-merkerstatus:"   . $merkerstatus );
header("fb-gebruikteForm:"   . $formfactor );
//header("fb-merkereterterstatus:"   . $merkerstatus );
	}
?>
   
<p><a href="curlpeha.php  ">curlpeha.php</a>werk php die actionurl stuurt</p>
<p><a href="curlpeha.html  ">curlpeha.html</a>GUI met knoppen</p>
<p><a href="fb6680.php  ">fb.php</a>php die aan poort 6680 fb vraagt</p>
  
  <hr>

  
    <hr>
 <form style="background-color:red" id="form1" name="form1" method="get" action=""> 
 <label>IP (via config.inc geinitialiseerd)
       <input name="ipadresactionurl" type="text" id="ipadresactionurl" value="192.168.1.2" />
     </label>
	  <br>
	 	<label>poort
       <input name="poortactionurl" type="text" id="poortactionurl"  value="80" />
     </label>
 <br>
	<label>stm(0-7)
       <input name="stmactionurl" type="text" id="stmactionurl" value="0" />
     </label>
   <br>
     <label>module (0-255)
       <input name="moduleactionurl" type="text" id="moduleactionurl" value="0" />
     </label>
	     <br>
	 <label>channel (0-16)
     <input name="channelactionurl" type="text"   id="channelactionurl" value="0" /> 
    </label>
		    <br>
	 <label>event (knopgedrag)
     <input name="eventactionurl" type="text"   id="eventactionurl" value="2" /> 
    </label> 
   
     <label>submit
       <input type="submit" name="submit" id="submit" value="actionurl" />
     </label>   
</form> 
  <hr>
      <form  style="background-color:pink" id="formtest" name="formtest" method="get" action="">  
         
   <label>stm(0-7)
       <input name="merkerstm" type="text" id="merkerstm" value="0" />
     </label>
   
         <br>
	 <label>merker
     <input name="merkernr" type="text"   id="merkernr" value="1" /> 
    </label>
      
     <label>submit
       <input type="submit" name="submit" id="submit" value="merker" />
     </label>   
</form>
<hr>
<form  style="background-color:green" id="formfb" name="formfb" method="get" action="">
      <br>
     <label>stm(0-7)
       <input name="fbstm" type="text" id="fbstm" value="0" />
     </label>
   (goed invullen in config.inc)
    <br>
     <label>module (0-255)
       <input name="fbmodule" type="text" id="fbmodule" value="64" />
     </label>
   ingang0 , multi32 , uitgang64 , analoog96 , box128 , dim160
     <br>kanaal (0-1)of (0-32)of (0-7)  
     <input name="fbkanaal" type="text"   id="fbkanaal" value="0" /> 
   (deze parameter word gebruikt in een functie om het antwoord te filteren van 255 naar 00001111 )
    <br>
     <label>c1 feedbackconstante =1
       <input name="c1" type="text" disabled="disabled" id="c1" value="1" />
     </label>
         <label>submit
       <input type="submit" name="submit" id="submit" value="fb" />
     </label>
   
</form>




  <h2>5regels respons headers voor gui :</h2>
<div id="phpvar"><?php echo     $actionurltemplate?></div>
<div id="phpvara"><?php echo     $modadres?></div>
<div id="phpvaraa"><?php echo     $modulestatus?></div>
<div id="phpvaraa"><?php echo     $kanaalstatus?></div>
<div id="phpvaraab"><?php echo     $merkerstatus?></div>
<div id="phpvaraab"><?php echo     $formfactor?></div>







   
   </p>
</body>
</html>