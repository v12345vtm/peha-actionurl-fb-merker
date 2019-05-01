 
  	 <?php  
	 
	 function setDimmer($ip   ,$stmadres  , $modadres , $kanaalnr , $waarde , $tijdspanne){
		 if ($waarde ==0)
		 {//commando dimmer uit!!
		 		if($kanaalnr == 0){$kanaalnr=4;} //bitnivo
				if($kanaalnr == 1){$kanaalnr=36;}//bitnivo , kanaal zit op bit3 , de rest is de functie vd dimmer (vb uitschakelen , geheugen1 , geheugen 2 enz...)
		 $data='<methodCall><methodName>service.stm.sendTelegram</methodName><params><param><value><i4>'.$stmadres.'</i4></value></param><param><value><i4>'.$modadres.'</i4></value></param><param><value><i4>'.$kanaalnr.'</i4></value></param></params></methodCall>';
		 
		 $respons=	sendtopeha($ip , $data );// naar peha sturen en respons binnennemen metn header http 200 ok
			if (strstr($respons , "faultCode"))
			{return "error dimmeruitcommando";}
			else{$s =substr($respons,148 +43+12);  
		return "1";
				}
		 
			 ;}
		 else
		 {//commando waarde en tijd
		 		 		if($kanaalnr == 0){$kanaalnr=22;} //bitnivo
				if($kanaalnr == 1){$kanaalnr=54;}//
		 $data = '<methodCall><methodName>service.stm.sendTelegram</methodName><params><param><value><i4>'.$stmadres.'</i4></value></param><param><value><i4>'.$modadres.'</i4></value></param><param><value><i4>'. $kanaalnr.'</i4></value></param><param><value><i4>'.$waarde.'</i4></value></param><param><value><i4>'.$tijdspanne.'</i4></value></param></params></methodCall>';
		  $respons=	sendtopeha($ip , $data );// naar peha sturen en respons binnennemen metn header http 200 ok
		  if (strstr($respons , "faultCode"))
		{return "error waarde en tijd commando";}
		else{$s =substr($respons,148 +43+12) ;  
		return "1";}
			 ;}
		 ;}//end functie
 
  function inputcontrolestm($stm){
  if( $stm ==0||$stm ==1||$stm ==2||$stm ==3||$stm ==4||$stm ==5||$stm ==6||$stm ==7) {
 // echo $stm;
 // echo "ptrtrtr";
  return true;}
  
  }
 
function sendtopeha($ip , $data )
{ 
    try  
    {  
     // do something that can go wrong  
	 $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);	
$result = socket_connect($socket, $ip ,6680);	
socket_write($socket, $data);
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
