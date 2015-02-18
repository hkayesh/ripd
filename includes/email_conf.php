<?php
function CreateEmailAccount($euser, $epass)
            {
            // cPanel info
			//$euser = "bulbul";
			//$epass = "**bul**321";
            $cpuser = 'ripduniv'; // cPanel username
            $cppass = '**ripd54321'; // cPanel password
            $cpdomain = 'ripduniversal.com'; // cPanel domain or IP
            $cpskin = 'x3';  // cPanel skin. Mostly x or x2. 
            $edomain = 'ripduniversal.com'; // email domain (usually same as cPanel domain above)
            $equota = 20; // amount of space in megabytes
            $msg = '';
            if (!empty($euser))
                    {
                    $f = fopen ("http://$cpuser:$cppass@$cpdomain:2082/frontend/$cpskin/mail/doaddpop.html?email=$euser&domain=$edomain&password=$epass&quota=$equota", "r");
                    if (!$f) 
                            {
                            $msg = "666"; //error to work with file (fopen)
                            return $msg;
                            }
                    else
                            {
                            $msg = "777"; //successful message
                            return $msg;
                            }
                    while (!feof ($f)) 
                            {
                            $line = fgets ($f, 1024);
                            if (ereg ("already exists", $line, $out)) 
                                    {
                                    $msg = "444"; //file already exists
                                    return $msg;
                                    }
                            }
                    @fclose($f);
                    return $msg;
                    }
            }
?>
