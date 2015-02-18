<?php
function SendSMSFuntion($to, $txt) {
    //--------------------------
$message_get = $txt;
$mobile = $to;
//$message_get = "Hello Jesy.......$mobile";
$message_url = urlencode($message_get);
$message_final = substr($message_url, 0, 159);

//fixed parameter
$host = "manage.muthofun.com";
//$port = "8080";
$username = "iftekhar@comfosys.com";
$password = "ifteeCFS2014";
$sender = "RIPD";
$msgtype = "0";
$dlr ="1";

//http://manage.muthofun.com//bulksms/bulksend.go?username=iftekhar@comfosys.com&password=ifteeCFS2014&originator=comfosys&phone=8801727208714&msgtext=test+message

//$live_url = "http://$host:$port/bulksms/bulksms?username=$username&password=$password&type=$msgtype&dlr=$dlr&destination=$mobile&source=$sender&message=$message_final";
//$directURl = "http://121.241.242.114:8080/bulksms/bulksms?username=mfn-demo&password=demo321&type=0&dlr=0&destination=8801823146626&source=TSMTS&message=This+is+test";
      $ch = curl_init("http://$host/bulksms/bulksend.go?");
      //echo "CH= ".$ch. "<br/>";
      curl_setopt($ch, CURLOPT_POST, True);
      //curl_setopt($ch, CURLOPT_POSTFIELDS,"username=$username&password=$password&type=0&dlr=1&destination=$mobile&source=$sender&message=$message_final");
      curl_setopt($ch, CURLOPT_POSTFIELDS,"username=$username&password=$password&originator=$sender&phone=$mobile&msgtext=$message_final");
      curl_setopt($ch, CURLOPT_TIMEOUT,60);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

      $contents = curl_exec($ch);

      //var_dump(curl_getinfo($ch));

      curl_close ($ch);
      return $contents;
    //---------------------------
}
?>