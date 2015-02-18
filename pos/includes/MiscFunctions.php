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
}//getMsg

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


function ContainsIllegalCharacters ($CheckVariable) {

	if (mb_strstr($CheckVariable,"'")
		OR mb_strstr($CheckVariable,'+')
		OR mb_strstr($CheckVariable,'?')
		OR mb_strstr($CheckVariable,'.')
		OR mb_strstr($CheckVariable,"\"")
		OR mb_strstr($CheckVariable,'&')
		OR mb_strstr($CheckVariable,"\\")
		OR mb_strstr($CheckVariable,'"')
		OR mb_strstr($CheckVariable,'>') 
		OR mb_strstr($CheckVariable,'<')){

		return true;
	} else {
		return false;
	}
}


function pre_var_dump(&$var){
	echo '<div align=left><pre>';
	var_dump($var);
	echo '</pre></div>';
}



class XmlElement {
  var $name;
  var $attributes;
  var $content;
  var $children;
};

function GetECBCurrencyRates () {
/* See http://www.ecb.int/stats/exchange/eurofxref/html/index.en.html
for detail of the European Central Bank rates - published daily */
	if (http_file_exists('http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml')) {
		$xml = file_get_contents('http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml');
		$parser = xml_parser_create();
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($parser, $xml, $tags);
		xml_parser_free($parser);

		$elements = array();  // the currently filling [child] XmlElement array
		$stack = array();
		foreach ($tags as $tag) {
			$index = count($elements);
			if ($tag['type'] == 'complete' OR $tag['type'] == 'open') {
				$elements[$index] = new XmlElement;
				$elements[$index]->name = $tag['tag'];
				$elements[$index]->attributes = $tag['attributes'];
				$elements[$index]->content = $tag['value'];
				if ($tag['type'] == 'open') {  // push
					$elements[$index]->children = array();
					$stack[count($stack)] = &$elements;
					$elements = &$elements[$index]->children;
				}
			}
			if ($tag['type'] == 'close') {  // pop
				$elements = &$stack[count($stack) - 1];
				unset($stack[count($stack) - 1]);
			}
		}


		$Currencies = array();
		foreach ($elements[0]->children[2]->children[0]->children as $CurrencyDetails){
			$Currencies[$CurrencyDetails->attributes['currency']]= $CurrencyDetails->attributes['rate'] ;
		}
		$Currencies['EUR']=1; //ECB delivers no rate for Euro
		//return an array of the currencies and rates
		return $Currencies;
	} else {
		return false;
	}
}

function GetCurrencyRate($CurrCode,$CurrenciesArray) {
  if ((!isset($CurrenciesArray[$CurrCode]) or !isset($CurrenciesArray[$_SESSION['CompanyRecord']['currencydefault']]))){
  	return quote_oanda_currency($CurrCode);
  } elseif ($CurrCode=='EUR'){
  	if ($CurrenciesArray[$_SESSION['CompanyRecord']['currencydefault']]==0) {
  		return 0;
  	} else {
  		return 1/$CurrenciesArray[$_SESSION['CompanyRecord']['currencydefault']];
  	}
  }	else {
  	if ($CurrenciesArray[$_SESSION['CompanyRecord']['currencydefault']]==0) {
  		return 0;
  	} else {
  		return $CurrenciesArray[$CurrCode]/$CurrenciesArray[$_SESSION['CompanyRecord']['currencydefault']];
  	}
  }
}

function quote_oanda_currency($CurrCode) {
	if (http_file_exists('http://www.oanda.com/convert/fxdaily?value=1&redirected=1&exch=' . $CurrCode .  '&format=CSV&dest=Get+Table&sel_list=' . $_SESSION['CompanyRecord']['currencydefault'])) {
		$page = file('http://www.oanda.com/convert/fxdaily?value=1&redirected=1&exch=' . $CurrCode .  '&format=CSV&dest=Get+Table&sel_list=' . $_SESSION['CompanyRecord']['currencydefault']);
		$match = array();
		preg_match('/(.+),(\w{3}),([0-9.]+),([0-9.]+)/i', implode('', $page), $match);

			if ( sizeof($match) > 0 ){
				return $match[3];
			} else {
				return false;
		}
	}
}


function AddCarriageReturns($str) {
	return str_replace('\r\n',chr(10),$str);
}


function wikiLink($type, $id) {

	if ($_SESSION['WikiApp']==_('WackoWiki')){
		echo '<a target="_blank" href="../' . $_SESSION['WikiPath'] . '/' . $type .  $id . '">' . _('Wiki ' . $type . ' Knowlege Base') . '</a><br />';
	} elseif ($_SESSION['WikiApp']==_('MediaWiki')){
		echo '<a target="_blank" href="../' . $_SESSION['WikiPath'] . '/index.php/' . $type . '/' .  $id . '">' . _('Wiki ' . $type . ' Knowlege Base') . '</a><br />';
	} elseif ($_SESSION['WikiApp']==_('DokuWiki')){
		echo ' ../' . $_SESSION['WikiPath'] . '/doku.php?id=' . $type . ':' . $id . ' ' . _('Wiki ' . $type . ' Knowlege Base') . ' <br />';
	}

}//wikiLink


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

/*Functions to display numbers in locale of the user */

function locale_number_format($Number, $DecimalPlaces=0) {
	global $DecimalPoint;
	global $ThousandsSeparator;
	if ($_SESSION['Language']=='hi_IN.utf8' OR $_SESSION['Language']=='en_IN.utf8'){
		return indian_number_format($Number,$DecimalPlaces);
	} else {
		if (!is_numeric($DecimalPlaces) AND $DecimalPlaces == 'Variable'){
			$DecimalPlaces = mb_strlen($Number) - mb_strlen(intval($Number));
			if ($DecimalPlaces > 0){
				$DecimalPlaces--;
			}
		}
		return number_format($Number,$DecimalPlaces,$DecimalPoint,$ThousandsSeparator);
	}
}

/* and to parse the input of the user into useable number */

function filter_number_format($Number) {
	global $DecimalPoint;
	global $ThousandsSeparator;
	$SQLFormatNumber = str_replace($DecimalPoint,'.',str_replace($ThousandsSeparator,'',trim($Number)));
	/*It is possible if the user entered the $DecimalPoint as a thousands separator and the $DecimalPoint is a comma that the result of this could contain several periods "." so need to ditch all but the last "." */
	if (mb_substr_count($SQLFormatNumber,'.')>1){
		return  str_replace('.','',mb_substr($SQLFormatNumber,0,mb_strrpos($SQLFormatNumber,'.'))) . mb_substr($SQLFormatNumber,mb_strrpos($SQLFormatNumber,'.'));
		
		echo '<br /> Number of periods: ' . $NumberOfPeriods . ' $SQLFormatNumber = ' . $SQLFormatNumber;

	} else {
		return $SQLFormatNumber;
	}
}


function indian_number_format($Number,$DecimalPlaces){ 
	$IntegerNumber = intval($Number);
	$DecimalValue = $Number - $IntegerNumber;
	if ($DecimalPlaces !='Variable'){
		$DecimalValue= round($DecimalValue,$DecimalPlaces);
	}
	if ($DecimalPlaces!='Variable' AND strlen(substr($DecimalValue,2))>0){
		/*If the DecimalValue is longer than '0.' then chop off the leading 0*/
		$DecimalValue = substr($DecimalValue,1);
		if ($DecimalPlaces > 0){
			$DecimalValue = str_pad($DecimalValue,$DecimalPlaces,'0');
		} else {
			$DecimalValue ='';
		}
	} else {
		if ($DecimalPlaces!='Variable' AND $DecimalPlaces > 0){
			$DecimalValue = '.' . str_pad($DecimalValue,$DecimalPlaces,'0');
		} elseif($DecimalPlaces==0) {
			$DecimalValue ='';
		}
	}
	if(strlen($IntegerNumber)>3){ 
		$LastThreeNumbers = substr($IntegerNumber, strlen($IntegerNumber)-3, strlen($IntegerNumber)); 
		$RestUnits = substr($IntegerNumber, 0, strlen($IntegerNumber)-3); // extracts the last three digits 
		$RestUnits = (strlen($RestUnits)%2 == 1)?'0'.$RestUnits:$RestUnits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping. 
		$FirstPart ='';
		$ExplodedUnits = str_split($RestUnits, 2); 
		for($i=0; $i<sizeof($ExplodedUnits); $i++){ 
			$FirstPart .= intval($ExplodedUnits[$i]).','; // creates each of the 2's group and adds a comma to the end 
		}    
	
		return $FirstPart.$LastThreeNumbers.$DecimalValue; 
	} else { 
		return $IntegerNumber. $DecimalValue;
	} 
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
function get_time_random_no($len) // random unique number*************
{
    $random = substr(number_format(time() * rand(), 0, '', ''), 0, $len);
    return $random;
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

?>