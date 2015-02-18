<?php

/* $Id: MiscFunctions.php 4761 2011-12-03 03:03:38Z daintree $*/

/*  ******************************************  */
/** STANDARD MESSAGE HANDLING & FORMATTING **/
/*  ******************************************  */

function prnMsg($Msg,$Type='info', $Prefix=''){

	echo getMsg($Msg, $Type, $Prefix);

}//prnMsg

function reverse_escape($str) {
  $search=array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
  $replace=array("\\","\0","\n","\r","\x1a","'",'"');
  return str_replace($search,$replace,$str);
}

//getMsg
function getMsg($Msg,$Type='info',$Prefix=''){
	$Colour='';
	if (isset($_SESSION['LogSeverity']) and $_SESSION['LogSeverity']>0) {
		$LogFile=fopen($_SESSION['LogPath'].'/webERP-test.log', 'a');
	}
	switch($Type){
		case 'error':
			$Class = 'error';
			$Prefix = $Prefix ? $Prefix : _('ERROR') . ' ' ._('Message Report');
			if (isset($_SESSION['LogSeverity']) and $_SESSION['LogSeverity']>0) {
				fwrite($LogFile, date('Y-m-d h-m-s').','.$Type.','.$_SESSION['UserID'].','.trim($Msg,',')."\n");
			}
			break;
		case 'warn':
			$Class = 'warn';
			$Prefix = $Prefix ? $Prefix : _('WARNING') . ' ' . _('Message Report');
			if (isset($_SESSION['LogSeverity']) and $_SESSION['LogSeverity']>1) {
				fwrite($LogFile, date('Y-m-d h-m-s').','.$Type.','.$_SESSION['UserID'].','.trim($Msg,',')."\n");
			}
			break;
		case 'success':
			$Class = 'success';
			$Prefix = $Prefix ? $Prefix : _('SUCCESS') . ' ' . _('Report');
			if (isset($_SESSION['LogSeverity']) and $_SESSION['LogSeverity']>3) {
				fwrite($LogFile, date('Y-m-d h-m-s').','.$Type.','.$_SESSION['UserID'].','.trim($Msg,',')."\n");
			}
			break;
		case 'info':
		default:
			$Prefix = $Prefix ? $Prefix : _('INFORMATION') . ' ' ._('Message');
			$Class = 'info';
			if (isset($_SESSION['LogSeverity']) and $_SESSION['LogSeverity']>2) {
				fwrite($LogFile, date('Y-m-d h-m-s').','.$Type.','.$_SESSION['UserID'].','.trim($Msg,',')."\n");
			}
	}
	return '<div class="'.$Class.'"><b>' . $Prefix . '</b> : ' .$Msg . '</div>';
}

function IsEmailAddress($Email){

	$AtIndex = strrpos ($Email, "@");
	if ($AtIndex == false) {
	    return  false;	// No @ sign is not acceptable.
	}

	if (preg_match('/\\.\\./', $Email)){
	    return  false;	// > 1 consecutive dot is not allowed.
	}
	//  Check component length limits
	$Domain = mb_substr ($Email, $AtIndex+1);
	$Local= mb_substr ($Email, 0, $AtIndex);
	$LocalLen = mb_strlen ($Local);
	$DomainLen = mb_strlen ($Domain);
	if ($LocalLen < 1 || $LocalLen > 64){
	    // local part length exceeded
	    return  false;
	}
	if ($DomainLen < 1 || $DomainLen > 255){
	    // domain part length exceeded
	    return  false;
	}

	if ($Local[0] == '.' OR $Local[$LocalLen-1] == '.') {
	    // local part starts or ends with '.'
	    return  false;
	}
	if (!preg_match ('/^[A-Za-z0-9\\-\\.]+$/', $Domain )){
	    // character not valid in domain part
	    return  false;
	}
	if (!preg_match ('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace ("\\\\", "" ,$Local) )){
	    // character not valid in local part unless local part is quoted
	    if (!preg_match ('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $Local) ))  {
			return  false;
	    }
	}

	//  Check for a DNS 'MX' or 'A' record.
	//  Windows supported from PHP 5.3.0 on - so check.
	$Ret = true;
	/*  Apparentely causes some problems on some versions - perhaps bleeding edge just yet
	if (version_compare(PHP_VERSION, '5.3.0') >= 0 OR mb_strtoupper(mb_substr(PHP_OS, 0, 3) !== 'WIN')) {
	    $Ret = checkdnsrr( $Domain, 'MX' ) OR checkdnsrr( $Domain, 'A' );
	}
	*/
	return  $Ret;
}

//  Lindsay debug stuff
function LogBackTrace( $dest = 0 ) {
    error_log( "***BEGIN STACK BACKTRACE***", $dest );

    $stack = debug_backtrace();
    //  Leave out our frame and the topmost - huge for xmlrpc!
    for( $ii = 1; $ii < count( $stack ) - 3; $ii++ )
    {
	$frame = $stack[$ii];
	$msg = "FRAME " . $ii . ": ";
	if( isset( $frame['file'] ) ) {
	    $msg .= "; file=" . $frame['file'];
	}
	if( isset( $frame['line'] ) ) {
	    $msg .= "; line=" . $frame['line'];
	}
	if( isset( $frame['function'] ) ) {
	    $msg .= "; function=" . $frame['function'];
	}
	if( isset( $frame['args'] ) ) {
	    // Either function args, or included file name(s)
	    $msg .= ' (';
	    foreach( $frame['args'] as $val ) {

			$typ = gettype( $val );
			switch( $typ ) {
				case 'array':
				    $msg .= '[ ';
				    foreach( $val as $v2 ) {
						if( gettype( $v2 ) == 'array' ) {
						    $msg .= '[ ';
						    foreach( $v2 as $v3 )
							$msg .= $v3;
						    $msg .= ' ]';
						} else {
						    $msg .= $v2 . ', ';
					    }
					    $msg .= ' ]';
					    break;
					}
				case 'string':
				    $msg .= $val . ', ';
				    break;

				case 'integer':
				    $msg .= sprintf( "%d, ", $val );
				    break;

				default:
				    $msg .= '<' . gettype( $val ) . '>, ';
				    break;

		    	}
		    $msg .= ' )';
			}
		}
	error_log( $msg, $dest );
    }

    error_log( '++++END STACK BACKTRACE++++', $dest );

    return;
}

function http_file_exists($url)  {
	$f=@fopen($url,'r');
	if($f) {
		fclose($f);
		return true;
	}
	return false;
}


function english2bangla($input) {
    $bn_digits=array('০','১','২','৩','৪','৫','৬','৭','৮','৯');
    $output = str_replace(range(0, 9),$bn_digits, $input); 
    return $output;
}

function number($inputs)
{
    $digits= array('১ম','২য়','৩য়','৪র্থ','৫ম','৬ষ্ঠ','৭ম','৮ম','৯ম','১০ম','এস.এস.সি','এইচ.এস.সি','অনার্স','মাষ্টার্স','ডিগ্রী','বি.এস.সি','এম.এস.সি','এম.ফিল','পি.এইচ.ডি'); 
    $output =$digits[$inputs];
    return $output;
}
function getProgramType($type)
{
   $arr_type = array('presentation'=>'প্রেজেন্টশন','program'=>'প্রোগ্রাম','training'=>'ট্রেইনিং','travel'=>'ট্র্যাভেল');
   return $arr_type[$type];
}
function getProgramer($type)
{
   $arr_who = array('presentation'=>'প্রেজেন্টার','program'=>'প্রোগ্রামার','training'=>'ট্রেইনার','travel'=>'ট্র্যাভেলার');
   return $arr_who[$type];
}
function getProgramer2($type)
{
   $arr_who = array('presenter'=>'প্রেজেন্টার','programmer'=>'প্রোগ্রামার','trainer'=>'ট্রেইনার','traveller'=>'ট্র্যাভেলার');
   return $arr_who[$type];
}
function getProgramerType($type)
{
   $arr_who_type = array('presentation'=>'presenter','program'=>'programmer','training'=>'trainer','travel'=>'traveller');
   return $arr_who_type[$type];
}
function getTypeFromWho($type)
{
   $arr_who_type = array('presenter'=>'presentation','programmer'=>'program','trainer'=>'training','traveller'=>'travel');
   return $arr_who_type[$type];
}
function getAwardReceiverType($aType){
    $arr_award_type = array('company'=>'কোম্পানী', 'employee'=>'কর্মচারী', 'customer'=>'কাস্টমার', 'others'=>'অন্যান্য');
    return $arr_award_type[$aType];
}
function getRandomPassword()
{
        $new_pass_str = "";
        $arr_rand_generator =array("num","small","star");
    for ($i = 0; $i < 10; $i++) {
        $random_keys = rand(0, 2);
        if (($arr_rand_generator["$random_keys"]) == "num")
            $new_pass_str .= chr(rand(48, 57));
        elseif (($arr_rand_generator["$random_keys"]) == "small")
            $new_pass_str .= chr(rand(97, 122));
        else
            $new_pass_str .= chr(42); // this numbers refer to *
    }
    return $new_pass_str;
}

function convert_number($number)
{
    if (($number < 0) || ($number > 999999999))
    {
        throw new Exception("Number is out of range");
    }

    $Gn = floor($number / 100000);  /* Millions (giga) */
    $number -= $Gn * 100000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10;               /* Ones */

    $res = "";

    if ($Gn)
    {
        $res .= convert_number($Gn) . " Lac";
    }

    if ($kn)
    {
        $res .= (empty($res) ?" ": " ") .
        convert_number($kn) . " Thousand";
    }

    if ($Hn)
    {
        $res .= (empty($res) ? " " : " ") .
        convert_number($Hn) . " Hundrad";
    }

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six","Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen","Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen","Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty","Seventy", "Eigthy", "Ninety");

    if ($Dn || $n)
    {
        if (!empty($res))
        {
            $res .= " and ";
        }
        if ($Dn < 2)
        {
            $res .= $ones[$Dn * 10 + $n];
        }
        else
        {
            $res .= $tens[$Dn];
            if ($n)
            {
                $res .= "-" . $ones[$n];
            }
        }
     }
    if (empty($res))
        {
            $res = "zero";
        }
        return $res;
}
function getChequeNo($sql)
    {
    chequeLoop:
    $str_random_no=(string)mt_rand (0 ,9999);
    $str_checque_no= str_pad($str_random_no, 4, "0", STR_PAD_LEFT);
    for($i=0; $i<3; $i++)
        {
        $str_random_no=(string)mt_rand (0 ,9999);
        $str_cheque= str_pad($str_random_no, 4, "0", STR_PAD_LEFT);
        $str_checque_no = $str_checque_no."-".$str_cheque;
        }
    //return $str_checque_no;
    $sql->execute(array($str_checque_no));
    $row_chequeNumber = $sql->fetchColumn();
    if($row_chequeNumber > 0) 
        {
        $str_checque_no = "";
        goto chequeLoop;
        }
    else {return $str_checque_no;}
    }
function get_time_random_no($len) // random unique number*************
{
    $random = substr(number_format(time() * rand(), 0, '', ''), 0, $len);
    return $random;
}
?>
