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
	// echo   "<BR>testfunctie die niks doet of hierboven debug info toont";
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
// echo   $resp ;  //respons van onze curl get 
 
 
////echo   "CURL BEIINDIGD" ;


$myfile = fopen("zonop_zoneer.json", "w") or die("Unable to open file!");
 
fwrite($myfile, $resp); //is json 
fclose($myfile);


 }
 ?> 
 
 

<?php
	 if (isset($_GET['submit']) ){
		 
		 			 ///variabelen die naar poort 80 als action url verzonden worden
 $ipadresactionurl =$_GET['ipadresactionurl'];
 
		  
 
		  
		 ///nu voor variabelen voor welk form ze gedrukt hebben
		 $formfactor =$_GET['submit'];  
		  
		  
		  
echo    	 "<font color=\"brown\"> welke form werd gedrukt?: "  ; 	   
echo     $formfactor . " " ;

echo     	"</font> <br> " ; 


		  
//echo    	 "<font color=\"red\"> parameters voor actionurl@80: "  ; 	   
echo     $ipadresactionurl . " " ;
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
$actionurltemplate =  $ipadresactionurl ; 
 
   echo  "sending action-url";
	
	//sendURLtopeha($actionurltemplate); //req via action url op poort 80 , de http interface van peha
	
	sendURLtopeha("https://data.buienradar.nl/2.0/feed/json"); //req via action url op poort 80 , de http interface van peha


//$actionurltemplate = $actionurltemplate  ; 
//$formfactor  = $formfactor;
 


 
	
testt();



 header("f-verzondenactionURL:"   . $actionurltemplate );
 
//header("fb-merkereterterstatus:"   . $merkerstatus );
	}
?>
   

  

  
    <hr>
 <form style="background-color:red" id="form1" name="form1" method="get" action=""> 
 <label>IP (via config.inc geinitialiseerd)
       <input name="ipadresactionurl" type="text" id="ipadresactionurl" value="websiturl" />
     </label>
 
   
     <label>submit
       <input type="submit" name="submit" id="submit" value="actionurl" />
     </label>   
</form> 
 

 
<p><a href="https://github.com/v12345vtm/peha-actionurl-fb-merker  ">sourcecode github</a>GITHUB SOURCE</p>

 





   
   </p>
</body>
</html>