<?php 
error_reporting(0);
session_start();
include 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';
if (!isset($_SESSION['arrRepTemp']))
{
 $_SESSION['arrRepTemp'] = array();
}
$id= $_GET['ssumid'];
if(isset($_POST['replace']))
{
    $P_invoiceno = $_POST['reciptID'];
    $P_buyername = $_POST['buyname'];
    $P_buyeracc = $_POST['buyacc'];
    $P_buyertype = $_POST['buytype'];
    $P_buyerid = $_POST['buyid'];
    $P_arr_procode = $_POST['proCode'];
    $P_arr_proname = $_POST['proname'];
    $P_arr_soldQty = $_POST['soldqty'];
    $P_arr_soldprice = $_POST['soldprice'];
    $P_arr_inventSumID = $_POST['inventSumID'];
    $P_arr_replaceQty = $_POST['replaceUnit'];
    $repQtyCount = count($P_arr_replaceQty);
    for($i=0;$i<$repQtyCount; $i++)
    {
        if($P_arr_replaceQty[$i]!=="")
        {
            $replaceAmount = $P_arr_replaceQty[$i] * ($P_arr_soldprice[$i] / $P_arr_soldQty[$i] );
            $arr_temp =  array($P_buyername,$P_buyeracc, $P_buyertype, $P_buyerid, $P_arr_inventSumID[$i], $P_arr_procode[$i], $P_arr_proname[$i], $P_arr_soldQty[$i],$P_arr_soldprice[$i], $P_arr_replaceQty[$i], $replaceAmount);
            $_SESSION['arrRepTemp'][] = $arr_temp;
        }
        else {continue;}
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html " charset="utf-8"  />
<title>বিক্রয় চালান পত্র</title>
<link rel="stylesheet" type="text/css" href="css/print.css" media="print"/>
</head>
<body>

    <div align="center" style="font-family: SolaimanLipi !important;"><strong>রিপড ইউনিভার্সাল (রিলীভ এন্ড ইমপ্রুভমেন্ট প্ল্যান অব ডেপ্রাইভড) </strong></br>
বিক্রয় চালান পত্র</br><?php echo $_SESSION['loggedInOfficeName'];?></br>
চালান নং: <?php echo $P_invoiceno;?> (পরিবর্তিত)</div></br>
<div style="float:left;font-family: SolaimanLipi !important;">ক্রেতার নাম: <?php echo $P_buyername;?></br>ক্রেতার অ্যাকাউন্ট নং / ক্রেতার মোবাইল নং :  <?php echo $P_buyeracc;?></div>
<div style="float:right;font-family: SolaimanLipi !important;">তারিখ : <?php echo english2bangla(date('d/m/Y'));?> সময়ঃ <?php echo english2bangla(date('g:i a' , strtotime('+4 hour')));?></div></br></br></br>
<fieldset   style="border-width: 3px;margin:0 5px;font-family: SolaimanLipi !important;">
<legend>পরিবর্তিত পণ্যের বিবরনি</legend>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-family: SolaimanLipi !important; font-size:14px;">
        <tr><td width="17%"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width="43%"><div align="center"><strong>প্রোডাক্টের নাম</strong></div></td>
        <td width="10%"><div align="center"><strong>খুচরা মূল্য</strong></div></td>
        <td width="17%"><div align="center"><strong>ফেরতকৃত পরিমাণ</strong></div></td>
        <td width="13%"><div align="center"><strong>মোট টাকা</strong></div></td>
      </tr>
<?php
$replacedGrndTotal = 0;
foreach ($_SESSION['arrRepTemp'] as $replaceRow)
  {
    $db_qty = $replaceRow[7];
    $db_soldamount = $replaceRow[8];
    $sellingprc = ($db_soldamount / $db_qty);
    echo '<tr>';
      echo '<td><div align="center">'.$replaceRow[5].'</div></td>';
        echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$replaceRow[6].'</div></td>';
        echo '<td><div align="center">'.english2bangla($sellingprc).'</div></td>';
        echo '<td><div align="center">'.english2bangla($replaceRow[9]).'</div></td>';
        echo '<td><div align="center">'.english2bangla($replaceRow[10]).'</div></td>';
        echo '</tr>';
        $replacedGrndTotal = $replacedGrndTotal + $replaceRow[10];
}
$_SESSION['recipt'] = $P_invoiceno; $_SESSION['repMoney']=$replacedGrndTotal;
?>
<td colspan="4" ><div align="right"><strong>ফেরতকৃত সর্বমোট:</strong>&nbsp;</div></td>
<td width="13%"><div align="right"><?php echo english2bangla($replacedGrndTotal);?></div></td>
</tr>
</table>
</fieldset>

<div align="center" style="width: 100%;font-family: SolaimanLipi !important;">
    <span id="noprint"><a  href="replace.php?edit=1&id=<?php echo $id;?>" style="margin: 1% 5% 5% 35%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/addToCart.jpeg');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
            <span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -50px;">এডিট করুন </span></a></span>
<span id="noprint"><a href="newSale.php?selltype=3"  style="margin: 1% 5% 5% 5%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/newSell.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
<span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -50px;">বিক্রয় করুন</span></a></span>
</div>

	  
</body>
</html>