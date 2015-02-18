<?php 
error_reporting(0);
session_start();
include 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
include_once './includes/pv_hitting_after_sell.php';

$storeName= $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
$oldrecipt = $_SESSION['recipt'];

$sel_sales_summary = $conn->prepare("SELECT * FROM sales_summary WHERE sal_invoiceno=? ");
$sel_cfs_user = $conn->prepare("SELECT * FROM cfs_user WHERE idUser = ? ");
$sel_unreg_customer = $conn->prepare("SELECT * FROM unregistered_customer WHERE idunregcustomer = ? ");
$up_ureg_customer = $conn->prepare("UPDATE unregistered_customer SET unregcust_buyingcount = ? WHERE unregcust_mobile= ? ");
$ins_sales_summary = $conn->prepare("INSERT INTO sales_summary(sal_store_type, sal_storeid, sal_buyer_type,sal_buyerid, sal_salesdate ,sal_salestime ,sal_total_buying_price, sal_totalamount ,sal_total_profit,sal_total_xtraprofit, sal_givenamount ,sal_invoiceno, cfs_userid,sal_return_org,sal_cash_paid,sal_acc_paid,status) 
            VALUES (?, ?, ?, ?, CURDATE(), CURTIME(), ?, ?, ?, ?, ?,?, ?,?,?,?,'not_replaced')");
$ins_sales = $conn->prepare("INSERT INTO sales(quantity ,sales_buying_price, sales_amount , sales_profit, sales_extra_profit, inventory_idinventory ,sales_summery_idsalessummery) 
            VALUES (? ,?, ?, ?, ?, ?, ?);");
$ins_replace_sum = $conn->prepare("INSERT INTO replace_product_summary(reprosum_store_type,reprosum_storeid,reprosum_replace_date , reprosum_replace_time ,reprosum_total_amount ,reprosum_invoiceno,cfs_userid) 
                                                            VALUES (?,?,CURDATE(), CURTIME(), ?, ?,?)");
$ins_replace = $conn->prepare("INSERT INTO replace_product(reppro_quantity ,reppro_amount ,inventory_idinventory ,replace_product_summary_idreproductsum) 
                                                    VALUES (?, ?, ?, ?)");
$up_sales_summary = $conn->prepare("UPDATE sales_summary SET status = 'replaced' WHERE sal_invoiceno = ? ");

if(isset($_POST['print']))
{
    $sel_sales_summary->execute(array($oldrecipt));
    $custsql = $sel_sales_summary->fetchAll();
    foreach ($custsql as $row) {
        $buyerid = $row['sal_buyerid'];
        $buyertype =$row['sal_buyer_type'];
    }
    
    if(($buyertype== 'customer') || ($buyertype== 'employee'))
    {
        $sel_cfs_user->execute(array($buyerid));
        $ssql = $sel_cfs_user->fetchAll();
        foreach ($ssql as $srow) {
             $db_accNo = $srow['account_number'];
                $db_custname = $srow['account_name'];
        }
     }
    elseif($buyertype == 'unregcustomer')
    {
        $sel_unreg_customer->execute(array($buyerid));
        $ssql = $sel_unreg_customer->fetchAll();
        foreach ($ssql as $srow) {
            $db_accNo = $srow['unregcust_mobile'];
            $db_custname = $srow['unregcust_name'];
            $buycount = $row['unregcust_buyingcount'] +1;
        }
        $up_ureg_customer->execute(array($buycount,$db_accNo));  
      }
     // পোস্ট ডাটা ****************************************
    $P_payType=$_POST['payType'];
    $P_backAfterReplace = $_POST['getFromReplace'];
    if($P_payType ==1)
    {
        $pay = "ক্যাশ";
        $P_getTaka=$_POST['cash'];
        $P_actualChange=$_POST['actualChange'];
        $P_paiedByCash = $_POST['gtotal'];
        $P_paiedByAcc = 0;
        $P_backTaka = ($P_getTaka - $P_paiedByCash) - $P_actualChange;
    }
    elseif($P_payType ==2) 
        {
            $pay = "অ্যাকাউন্ট";
            $P_paiedByAcc = $_POST['amount'];
            $P_paiedByCash = 0;
            $P_getTaka = 0;
            $P_backTaka = 0;
        }
    elseif($P_payType ==0) 
        {
            $pay = "রিপ্লেস";
            $P_getTaka=$_POST['cash'];
            $P_actualChange=$_POST['actualChange'];
            $P_paiedByCash = $_POST['gtotal'];
            $P_paiedByAcc = 0;
            $P_backTaka = 0;
        }
}
$id=$_SESSION['SESS_MEMBER_ID']; // চালান নং যাচাই**********************
$sel_sales_summary->execute(array($id));
$result= $sel_sales_summary->fetchAll();
        if (count($result)<1)
        {
             $_SESSION['SESS_MEMBER_ID']=$_SESSION['SESS_MEMBER_ID'];
        }
        else
        {
            $forwhileloop = 1;
                while($forwhileloop==1)
                {
                    $str_recipt = "RIPD";
                    for($i=0;$i<3;$i++)
                        {
                            $str_random_no=(string)mt_rand (0 ,9999 );
                            $str_recipt_random= str_pad($str_random_no,4, "0", STR_PAD_LEFT);
                            $str_recipt =$str_recipt."-".$str_recipt_random;
                        }
                        $sel_sales_summary->execute(array($str_recipt));
                        $result1= $sel_sales_summary->fetchAll();
                        if (count($result1) < 1)
                        {
                            $forwhileloop = 0;
                            break;
                        }
                }
              $_SESSION['SESS_MEMBER_ID']=$str_recipt;
        }
        $totalamount =0; $totalbuy = 0;$totalprofit = 0;$totalxprofit=0;
             foreach($_SESSION['arrSellTemp'] as $key => $row) {
                    $pro_qty = $row[4];
                   $totalamount = $totalamount + $row[5];
                   $totalbuy = $totalbuy + ($row[2] * $pro_qty);
                   $totalprofit = $totalprofit + ($row[7] * $pro_qty);
                   $totalxprofit = $totalxprofit + ($row[8] * $pro_qty);
              }
              if($totalamount > $_SESSION['repMoney'])
              {
                  $P_paiedByCash = $P_paiedByCash + $_SESSION['repMoney'] ;
              }
        $invoiceNo = $_SESSION['SESS_MEMBER_ID'];
        $conn->beginTransaction();
        // ******************* replace table-e insert & sales summary table-e update ****************
        $prevRecipt = $_SESSION['recipt'];
        $db_totalamount = $_SESSION['repMoney'];  
        $sqlresult1=$ins_replace_sum->execute(array($scatagory,$storeID,$db_totalamount,$prevRecipt,$cfsID));
        $replace_pro_sum_id= $conn->lastInsertId();
        foreach ($_SESSION['arrRepTemp'] as $replaceRow)
           {
               $repro_qty=$replaceRow[9];
               $repro_amount=$replaceRow[10];
               $repro_id = $replaceRow[4];
               $sqlresult2 = $ins_replace->execute(array($repro_qty,$repro_amount,$repro_id,$replace_pro_sum_id));
          }
          $sqlresult3 = $up_sales_summary->execute(array($prevRecipt));
          // ******************* sales table-e insert ***************************************
        $sqlresult4=$ins_sales_summary->execute(array($scatagory,$storeID,$buyertype,$buyerid,$totalbuy,$totalamount,$totalprofit,$totalxprofit,$P_getTaka,$invoiceNo,$cfsID,$P_backTaka,$P_paiedByCash,$P_paiedByAcc));
        $sales_sum_id= $conn->lastInsertId();
        foreach($_SESSION['arrSellTemp'] as $key => $row) 
        {
            $pro_qty = $row[4];
            $pro_amount = $row[5];
            $pro_buy= $row[2] * $pro_qty;
            $pro_profit = $row[7] * $pro_qty;
            $pro_xprofit = $row[8] * $pro_qty;
            $sqlresult5=$ins_sales->execute(array($pro_qty,$pro_buy,$pro_amount,$pro_profit,$pro_xprofit,$key,$sales_sum_id));
        }
    if($sqlresult4 && $sqlresult5 && $sqlresult1 && $sqlresult2 && $sqlresult3)
    {
        unset($_SESSION['arrRepTemp']);
        $conn->commit();
        $pv_hitting = pv_hitting($buyerid,$buyertype,$sales_sum_id,'general',$totalprofit);
    }
 else {
        $conn->rollBack();
       echo "<script>alert('দুঃখিত,প্রোডাক্ট রিপ্লেস হয়নি')</script>";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html " charset="utf-8"  />
<title>বিক্রয় চালান পত্র</title>
<link rel="stylesheet" type="text/css" href="css/print.css" media="print"/>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" /> 
<script src="scripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
 function pinGenerate(ssumid)
	{ TINY.box.show({url:'pinGenerator.php?ssumid='+ssumid,animate:true,close:true,boxid:'success',top:100,width:400,height:100}); }
 </script> 
<script type="text/javascript">
 function accGenerate(ssumid)
	{ TINY.box.show({url:'accountGenerator.php?ssumid='+ssumid,animate:true,close:true,boxid:'success',top:100,width:800,height:500}); }
 </script> 
</head>
    
<body>
<div align="center" style="font-family: SolaimanLipi !important;"><strong>রিপড ইউনিভার্সাল (রিলীভ এন্ড ইমপ্রুভমেন্ট প্ল্যান অব ডেপ্রাইভড) </strong></br>
বিক্রয় চালান পত্র</br><?php echo $storeName;?></br>
চালান নং: <?php echo $_SESSION['SESS_MEMBER_ID'];?></br>
পরিবর্তিত চালান নং:<?php echo $_SESSION['recipt'];?>(পরিবর্তিত) </div></br>
<div style="float:left">ক্রেতার নাম: <?php echo $db_custname;?><br />ক্রেতার অ্যাকাউন্ট নং/  ক্রেতার মোবাইল নং : <?php echo $db_accNo;?></div><div style="float:right">তারিখ : <?php echo english2bangla(date('d/m/Y'));?>
    সময়ঃ <?php echo english2bangla(date('g:i a' , strtotime('+4 hour')));?></div></br></br>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-family: SolaimanLipi !important; font-size:14px;">
      <tr><td width="17%"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width="43%"><div align="center"><strong>প্রোডাক্ট-এর নাম</strong></div></td>
        <td width="17%"><div align="center"><strong>পরিমাণ</strong></div></td>
        <td width="10%"><div align="center"><strong>খুচরা মূল্য</strong></div></td>
        <td width="13%"><div align="center"><strong>মোট টাকা</strong></div></td>
      </tr>
<?php
foreach($_SESSION['arrSellTemp'] as $key => $row) 
  {
      echo '<tr>';
      echo '<td><div align="left">'.$row[0].'</div></td>';
        echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$row[1].'</div></td>';
        echo '<td><div align="center">'.english2bangla($row[3]).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row[4]).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row[5]).'</div></td>';
        echo '</tr>';
}
 $finalTotal =0;
             foreach($_SESSION['arrSellTemp'] as $key => $row) {
                   $finalTotal = $finalTotal + $row[5];
              }
  $P_paidAmount = $finalTotal - $_SESSION['repMoney'];
  if($P_paidAmount < 0)
  {
      $P_paidAmount = 0;
  }
?>
<td colspan="4" ><div align="right"><strong>সর্বমোট:</strong>&nbsp;</div></td>
<td width="13%"><div align="right" style="padding-right: 8px;"><?php echo english2bangla($finalTotal);?></div></td>
</tr>
<tr>
    <td colspan="4" ><div align="right"><strong>প্রদেয় টাকা:</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right"  style="padding-right: 8px;"><?php echo english2bangla($P_paidAmount);?></div></td>
</tr>
<tr>
    <td colspan="4" ><div align="right"><strong>রিপ্লেস বাবদ ফেরত:</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right"  style="padding-right: 8px;"><?php echo english2bangla($P_backAfterReplace);?></div></td>
</tr>
<?php
if($P_getTaka != 0) {
?>
<tr>
    <td colspan="4" ><div align="right"><strong>পেমেন্ট টাইপ:</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right"  style="padding-right: 8px;"><?php echo $pay;?></div></td>
</tr>
<tr>
    <td colspan="4" ><div align="right"><strong>টাকা গ্রহন:</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right"  style="padding-right: 8px;"><?php echo english2bangla($P_getTaka);?></div></td>
</tr>
<tr>
    <td colspan="4" ><div align="right"><strong>টাকা ফেরত:</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right"><?php echo english2bangla($P_actualChange);?></div></td>
</tr>
<?php } ?>
</table>
<br />
<div align="center" style="width: 100%;font-family: SolaimanLipi !important;">
   <span id="noprint"><a href="javascript: window.print()"style="margin: 1% 5% 5% 20%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/print-icon.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
    <span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -15px;">প্রিন্ট </span></a></span>
    <span id="noprint"><a href="saleAgain.php?selltype=3"  style="margin: 1% 5% 5% 5%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/newSell.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
    <span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -70px;">পুনরায় বিক্রয় করুন</span></a></span>
<?php 
if ($buyertype== 'customer')
{
    ?>
    <span id="noprint" style="font-family: SolaimanLipi !important;">
    <a onclick="pinGenerate(<?php echo $sales_sum_id ?>)" style="margin: 1% 5% 5% 5%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/pingenerator.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
<span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -70px;">পিন নং জেনারেট করুন</span></a></span>
<span id="noprint" style="font-family: SolaimanLipi !important;">
    <a onclick="accGenerate(<?php echo $sales_sum_id?>)" style="margin: 1% 5% 5% 5%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/creatacc.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
<span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -70px;">অ্যাকাউন্ট ওপেন করুন</span></a></span>
<?php } ?>
</div>
	  
</body>
</html>