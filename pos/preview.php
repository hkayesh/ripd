<?php 
error_reporting(0);
session_start();
include_once './includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
include_once './includes/pv_hitting_after_sell.php';

$G_s_type = $_SESSION['loggedInOfficeType'];
$G_s_id= $_SESSION['loggedInOfficeID'];
$cfsID = $_SESSION['userIDUser'];

$sel_sales_summary = $conn->prepare("SELECT * FROM `sales_summary` WHERE sal_invoiceno=? ");
$sel_cfs_user = $conn->prepare("SELECT * FROM cfs_user WHERE account_name= ? AND account_number = ? ");
$sel_unreg_customer = $conn->prepare("SELECT * FROM unregistered_customer WHERE unregcust_mobile=? ");
$ins_unreg_customer = $conn->prepare("INSERT INTO `unregistered_customer` (`unregcust_name` ,`unregcust_address` ,`unregcust_occupation` ,`unregcust_mobile` ,`unregcust_email` ,`unregcust_buyingcount` ,`unregcust_status` ,`unregcust_lastupdated_date`) 
                    VALUES (?, ?, ?, ?, '', '1', 'unregistered', NOW())");
$up_ureg_customer = $conn->prepare("UPDATE `unregistered_customer` SET `unregcust_buyingcount` = ? WHERE unregcust_mobile= ? ");
$ins_sales_summary = $conn->prepare("INSERT INTO sales_summary(sal_store_type, sal_storeid, sal_buyer_type,sal_buyerid, sal_salesdate ,sal_salestime ,sal_total_buying_price, sal_totalamount ,sal_total_profit,sal_total_xtraprofit, sal_givenamount ,sal_invoiceno, cfs_userid,sal_return_org,sal_cash_paid,sal_acc_paid,status) 
            VALUES (?, ?, ?, ?, CURDATE(), CURTIME(), ?, ?, ?,?, ?,?, ?,?,?,?,'not_replaced')");
$ins_sales = $conn->prepare("INSERT INTO sales(quantity ,sales_buying_price, sales_amount ,sales_profit, sales_extra_profit, inventory_idinventory ,sales_summery_idsalessummery) 
            VALUES (? ,?, ?, ?, ?, ?, ?);");

$sel_command = $conn->prepare("SELECT * FROM running_command");
$sel_command->execute();
$arr_rslt = $sel_command->fetchAll();
foreach ($arr_rslt as $value) {
    $db_pv = $value['pv_value'];
}

if(isset($_POST['print']))
{
    if($_POST['customerType']== 1) // ******** ক্রেতা নির্ধারণ*********************************
    {
        $P_accNo = $_POST['accountNo'];
        $P_custname = $_POST['acName'];
        $sel_cfs_user->execute(array($P_custname,$P_accNo));
        $custsql = $sel_cfs_user->fetchAll();
        foreach ($custsql as $row) {
            $buyerid = $row['idUser']; 
            $buyertype = 'customer';
        }
      }
    elseif($_POST['customerType']== 2)
    {
        $P_custname = $_POST['custName'];
        $P_custmbl = $_POST['custMbl'];
        $P_custoccu = $_POST['custOccupation'];
        $P_custadrs = $_POST['custAdrss'];
        $sel_unreg_customer->execute(array($P_custmbl));
        $row = $sel_unreg_customer->fetchAll();
        if(count($row) < 1)
        {
            $ins_unreg_customer->execute(array($P_custname,$P_custadrs,$P_custoccu,$P_custmbl));
            $buyerid= $conn->lastInsertId();
        }
        else
        {
            foreach ($row as $value) {
                $buycount = $value['unregcust_buyingcount'] +1;
                $buyerid = $value['idunregcustomer'];
                $up_ureg_customer->execute(array($buycount,$P_custmbl));
            }
        }
        $buyertype='unregcustomer';
    }
    elseif($_POST['customerType']== 3)
    {
        $P_accNo = $_POST['empAccNo'];
        $P_custname = $_POST['empName'];
        $sel_cfs_user->execute(array($P_custname,$P_accNo));
        $custsql = $sel_cfs_user->fetchAll();
        foreach ($custsql as $row) {
            $buyerid = $row['idUser'];
            $buyertype ='employee';
        }
    }
    // পোস্ট ডাটা ****************************************
    $p_pinflag = $_POST['pinflag'];
    $P_payType=$_POST['payType'];
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
            $P_backTaka= 0;
        }
    else {
        $pay = "ক্যাশ এন্ড অ্যাকাউন্ট";
        $P_paiedByAcc = $_POST['amount'];
        $P_paiedByCash = $_POST['cashTopay'];
        $P_getTaka=$_POST['cash2'];
        $P_actualChange=$_POST['actualChange'];
        $P_backTaka = ($P_getTaka - $P_paiedByCash) - $P_actualChange;
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
    $totalamount =0;  $totalbuy = 0; $totalprofit = 0;$totalxprofit=0;
             foreach($_SESSION['arrSellTemp'] as $key => $row) {
                    $pro_qty = $row[4];
                   $totalamount = $totalamount + $row[5];
                   $totalbuy = $totalbuy + ($row[2] * $pro_qty);
                   $totalprofit = $totalprofit + ($row[7] * $pro_qty);
                   $totalxprofit = $totalxprofit + ($row[8] * $pro_qty);
              }
    $invoiceNo = $_SESSION['SESS_MEMBER_ID'];
    $conn->beginTransaction();
    $sqlresult1= $ins_sales_summary->execute(array($G_s_type,$G_s_id,$buyertype,$buyerid,$totalbuy,$totalamount,$totalprofit,$totalxprofit,$P_getTaka,$invoiceNo,$cfsID,$P_backTaka, $P_paiedByCash,$P_paiedByAcc));
    $sales_sum_id= $conn->lastInsertId();

    foreach($_SESSION['arrSellTemp'] as $key => $row) 
    {
        $pro_qty = $row[4];
        $pro_amount = $row[5];
        $pro_buy= $row[2] * $pro_qty ;
        $pro_profit = $row[7] * $pro_qty;
        $pro_xprofit = $row[8] * $pro_qty;
        $sqlresult2= $ins_sales->execute(array($pro_qty,$pro_buy,$pro_amount,$pro_profit,$pro_xprofit,$key,$sales_sum_id));
    }
    
    if($sqlresult1 && $sqlresult2)
    {
        $conn->commit();
        if($p_pinflag == 1)
        {
            $p_pinno = $_POST['pinNo'];
            pin_pv_hitting($sales_sum_id,$totalprofit,$p_pinno);
        }
        else {
            $pv_hitting = pv_hitting($buyerid,$buyertype,$sales_sum_id,'general',$totalprofit);
        }
    }
 else {
        $conn->rollBack();
        echo "<script>alert('দুঃখিত,প্রোডাক্ট বিক্রয় হয়নি')</script>";
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
 function accGenerate()
	{ TINY.box.show({iframe:'accountGenerator.php',width:900,height:400,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
 </script> 
</head>
<body>

<div align="center" style="font-family: SolaimanLipi !important;"><strong>রিপড ইউনিভার্সাল (রিলীভ এন্ড ইমপ্রুভমেন্ট প্ল্যান অব ডেপ্রাইভড) </strong></br>
বিক্রয় চালান পত্র</br><?php echo $_SESSION['loggedInOfficeName'];?></br>
চালান নং: <?php echo $_SESSION['SESS_MEMBER_ID'];?></div></br>
<div style="font-family: SolaimanLipi !important; width: 100%;">
    <div style="float:left">ক্রেতার নাম: <?php echo $P_custname;?><br />ক্রেতার অ্যাকাউন্ট নং : <?php echo $P_accNo;?> ক্রেতার মোবাইল নং : <?php echo $P_custmbl;?></div>
    <div style="float:right">তারিখ : <?php echo  english2bangla(date('d/m/Y'));?>
    সময়ঃ <?php echo english2bangla(date('g:i a' , strtotime('+4 hour')));?></div>
</div></br></br>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-family: SolaimanLipi !important; font-size:14px;">
      <tr>
          <td width="17%"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width="43%"><div align="center"><strong>প্রোডাক্ট-এর নাম</strong></div></td>       
        <td width="10%"><div align="center"><strong>খুচরা মূল্য</strong></div></td>
        <td width="17%"><div align="center"><strong>পরিমাণ</strong></div></td>
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
 $finalPV=$totalprofit * $db_pv;
             foreach($_SESSION['arrSellTemp'] as $key => $row) {
                   $finalTotal = $finalTotal + $row[5];
              }
              
?>
<td colspan="4" ><div align="right"><strong>সর্বমোট:</strong>&nbsp;</div></td>
<td width="13%"><div align="right" style="padding-right: 8px;"><?php echo english2bangla($finalTotal);?></div></td>
</tr>
<tr>
    <td colspan="4" ><div align="right"><strong>প্রদেয় টাকা:</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right"  style="padding-right: 8px;"><?php echo english2bangla($finalTotal);?></div></td>
</tr>
<tr>
    <td colspan="4" ><div align="right"><strong>পেমেন্ট টাইপ:</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right"  style="padding-right: 8px;"><?php echo $pay;?></div></td>
</tr>
<tr>
    <td colspan="4" ><div align="right"><strong>ক্যাশ টাকা গ্রহন:</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right"  style="padding-right: 8px;"><?php echo english2bangla($P_getTaka);?></div></td>
</tr>
<tr>
    <td colspan="4" ><div align="right"><strong>ক্যাশ টাকা ফেরত:</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right" style="padding-right: 8px;"><?php echo english2bangla($P_actualChange);?></div></td>
</tr>
<?php if($buyertype == 'customer') {?>
<tr>
    <td colspan="4" ><div align="right"><strong>মোট পিভি:</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right" style="padding-right: 8px;"><?php echo english2bangla($finalPV);?></div></td>
</tr>
<?php }?>
</table>
<br/>
<div align="center" style="width: 100%;font-family: SolaimanLipi !important;">
   <span id="noprint"><a href="javascript: window.print()"style="margin: 1% 5% 5% 20%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/print-icon.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
        <span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -15px;">প্রিন্ট </span></a></span>
<span id="noprint"><a href="saleAgain.php?selltype=1"  style="margin: 1% 5% 5% 5%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/newSell.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
        <span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -70px;">পুনরায় বিক্রয় করুন</span></a></span>
<?php if($buyertype=='unregcustomer') {?>
<span id="noprint" style="font-family: SolaimanLipi !important;">
    <a onclick="accGenerate()" style="margin: 1% 5% 5% 5%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/creatacc.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
<span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -70px;">অ্যাকাউন্ট ওপেন করুন</span></a></span>
<?php }?>
</div></br>

</body>
</html>