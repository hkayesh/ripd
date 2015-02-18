<?php 
error_reporting(0);
session_start();
include 'includes/ConnectDB.inc';
include_once './includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
include_once './includes/pv_hitting_after_wholesell.php';

$G_s_type = $_SESSION['loggedInOfficeType'];
$G_s_id= $_SESSION['loggedInOfficeID'];
$cfsID = $_SESSION['userIDUser'];

$sel_sales_summary = $conn->prepare("SELECT * FROM `sales_summary` WHERE sal_invoiceno=? ");
$sel_sales_store = $conn->prepare("SELECT * FROM sales_store WHERE account_number = ? ");
$sel_office = $conn->prepare("SELECT * FROM office WHERE account_number =? ");
$sel_unreg_customer = $conn->prepare("SELECT * FROM unregistered_customer WHERE unregcust_mobile=? ");
$ins_unreg_customer = $conn->prepare("INSERT INTO `unregistered_customer` (`unregcust_name` ,`unregcust_address` ,`unregcust_occupation` ,`unregcust_mobile` ,`unregcust_email` ,`unregcust_buyingcount` ,`unregcust_status` ,`unregcust_lastupdated_date`) 
                    VALUES (?, ?, ?, ?, '', '1', 'unregistered', NOW())");
$up_ureg_customer = $conn->prepare("UPDATE `unregistered_customer` SET `unregcust_buyingcount` = ? WHERE unregcust_mobile= ? ");
$ins_sales_summary = $conn->prepare("INSERT INTO sales_summary(sal_store_type, sal_storeid, sal_buyer_type,sal_buyerid, sal_salesdate ,sal_salestime ,sal_total_buying_price, sal_totalamount ,sal_total_lessprofit, sal_total_profit,sal_total_xtraprofit, sal_givenamount ,sal_invoiceno, cfs_userid,sal_return_org,sal_cash_paid,sal_acc_paid,status,selling_type) 
            VALUES (?, ?,?, ?,CURDATE(), CURTIME(), ?, ?, ?, ?, ?, ?,?,?, ?,?, ?,'not_replaced',?);");
$ins_sales = $conn->prepare("INSERT INTO sales(quantity ,sales_buying_price, sales_amount ,sales_less_profit, sales_profit, sales_extra_profit, inventory_idinventory ,sales_summery_idsalessummery) 
            VALUES (? ,?, ?, ?, ?, ?, ?, ?);");

if(isset($_POST['print']))
{
     if($_POST['customerType']== 2)
    {
        $P_accNo = $_POST['accountNo'];
        $P_custname = $_POST['storeName'];
        $buyertype = 's_store';
        $sel_sales_store->execute(array($P_accNo));
        $storerow = $sel_sales_store->fetchAll();
        foreach ($storerow as $row) {
            $buyerid = $row['idSales_store'];
        }
        
    }
    elseif($_POST['customerType']== 1)
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
        $P_custname = $_POST['offName'];
        $buyertype ='office';
        $sel_office->execute(array($P_accNo));
        $offrow = $sel_office->fetchAll();
        foreach ($offrow as $row) {
             $buyerid = $row['idOffice'];
        }      
    }
    
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
    else 
        {
            $pay = "অ্যাকাউন্ট";
            $P_paiedByAcc = $_POST['amount'];
            $P_paiedByCash = 0;
            $P_getTaka = 0;
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

        $totalamount =0; $totalbuy = 0;$totalLessProfit=0;$totalprofit = 0;$totalxprofit=0;
             foreach($_SESSION['arrSellTemp'] as $key => $row) {
                 $pro_qty = $row[4];
                   $totalamount = $totalamount + $row[5];
                   $totalbuy = $totalbuy + $row[2];
                   $totalLessProfit = $totalLessProfit + $row[7];
                   $totalprofit = $totalprofit + ($row[8] * $pro_qty);
                   $totalxprofit = $totalxprofit + ($row[9] * $pro_qty);
              }
              $actualProfit = $totalprofit - $totalLessProfit;
    $invoiceNo = $_SESSION['SESS_MEMBER_ID'];
    $conn->beginTransaction();
    $sellingtype = 'whole';
    $sqlresult1=$ins_sales_summary->execute(array($G_s_type,$G_s_id,$buyertype,$buyerid,$totalbuy,$totalamount,$totalLessProfit,$actualProfit,$totalxprofit,$P_getTaka,$invoiceNo,$cfsID,$P_backTaka, $P_paiedByCash,$P_paiedByAcc,$sellingtype));
    $sales_sum_id= $conn->lastInsertId();
    
     foreach($_SESSION['arrSellTemp'] as $key => $row) 
    {
        $pro_qty = $row[4];
        $pro_amount = $row[5];
        $pro_profitless = $row[7];
        $pro_buy= $row[2];
        $pro_profit = ($row[8] * $pro_qty) - $pro_profitless;
        $pro_xprofit = ($row[9] * $pro_qty);
        $sqlresult2=$ins_sales->execute(array($pro_qty,$pro_buy,$pro_amount,$pro_profitless,$pro_profit,$pro_xprofit,$key,$sales_sum_id));
    }
  if($sqlresult1 && $sqlresult2)
    {
        $conn->commit();
        $pv_hitting = pv_hitting($totalLessProfit,$buyertype,$sales_sum_id,'whole',$totalprofit);
    }
 else {
        $conn->rollBack();
        echo "<script>alert('দুঃখিত,প্রোডাক্ট বিক্রয় হয়নি');
            window.history.back();</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html " charset="utf-8"  />
<title>পাইকারি বিক্রয় চালান পত্র</title>
<link rel="stylesheet" type="text/css" href="css/print.css" media="print"/>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" /> 
</head>
<body>
    <div align="center" style="font-family: SolaimanLipi !important;"><strong>রিপড ইউনিভার্সাল (রিলীভ এন্ড ইমপ্রুভমেন্ট প্ল্যান অব ডেপ্রাইভড) </strong></br>
পাইকারি বিক্রয় চালান পত্র</br><?php echo $_SESSION['loggedInOfficeName'];?></br>
চালান নং: <?php echo $_SESSION['SESS_MEMBER_ID'];?></div></br>
<div style="float:left">ক্রেতার নাম: <?php echo $P_custname;?><br />ক্রেতার অ্যাকাউন্ট নং : <?php echo $P_accNo;?>ক্রেতার মোবাইল নং : <?php echo $P_custmbl;?></div><div style="float:right">তারিখ : <?php echo english2bangla(date('d/m/Y')) ;?>
সময়ঃ <?php echo english2bangla(date('g:i a' , strtotime('+4 hour')));?></div></br></br>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-family: SolaimanLipi !important; font-size:14px;">
      <tr><td width="13%" height="43"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width="34%"><div align="center"><strong>প্রোডাক্টের নাম</strong></div></td>
        <td width="9%"><div align="center"><strong>পরিমাণ</strong></div></td>
        <td width="12%"><div align="center"><strong>একক বিক্রয়মূল্য</strong></div></td>
        <td width="11%"><div align="center"><strong>মোট বিক্রয়মূল্য</strong></div></td>
        <td width="10%"><div align="center"><strong>প্রফিটে ছাড়</strong></div></td>
        <td width="14%"><div align="center"><strong>মোট টাকা</strong></div></td>
      </tr>
<?php
foreach($_SESSION['arrSellTemp'] as $key => $row) 
  {
      echo '<tr>';
      echo '<td><div align="left">'.$row[0].'</div></td>';
        echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$row[1].'</div></td>';        
        echo '<td><div align="center">'.english2bangla($row[4]).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row[3]).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row[3] * $row[4]).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row[7]).'</div></td>';
        echo '<td><div align="center">'.english2bangla($row[5]).'</div></td>';
        echo '</tr>';
}
 $finalTotal =0; $finalProfitless = 0;$actualSellingPrice =  0;
             foreach($_SESSION['arrSellTemp'] as $key => $row) {
                   $finalTotal = $finalTotal + $row[5];
                   $finalProfitless= $finalProfitless+ $row[7];
                   $actualSellingPrice = $actualSellingPrice + ($row[3] * $row[4]);
              }
?>
<tr>    
<td height="24" colspan="6" ><div align="right" style="padding-right: 8px;"><strong>মোট প্রকৃত বিক্রয়মূল্য</strong>&nbsp;</div></td>
<td width="10%"><div align="right"><?php echo english2bangla($actualSellingPrice);?></div></td>
</tr>
<tr>    
<td height="24" colspan="6" ><div align="right" style="padding-right: 8px;"><strong>মোট প্রফিট ছাড়</strong>&nbsp;</div></td>
<td width="10%"><div align="right"><?php echo english2bangla($finalProfitless);?></div></td>
</tr>
<tr>    
<td height="24" colspan="6" ><div align="right" style="padding-right: 8px;"><strong>সর্বমোট প্রদেয় টাকা</strong>&nbsp;</div></td>
<td width="10%"><div align="right"><?php echo english2bangla($finalTotal);?></div></td>
</tr>
<tr>
    <td colspan="6" ><div align="right"><strong>পেমেন্ট টাইপ</strong>&nbsp;</div></td>
    <td width="13%" ><div align="right"  style="padding-right: 8px;"><?php echo $pay;?></div></td>
</tr>
<tr>
    <td height="24" colspan="6" ><div align="right" style="padding-right: 8px;"><strong>টাকা গ্রহন</strong>&nbsp;</div></td>
    <td width="10%" ><div align="right"><?php echo english2bangla($P_getTaka);?></div></td>
</tr>
<tr>
    <td height="24" colspan="6" ><div align="right" style="padding-right: 8px;"><strong>টাকা ফেরত</strong>&nbsp;</div></td>
    <td width="10%" ><div align="right"><?php echo english2bangla($P_actualChange);?></div></td>
</tr>
</table>
<div align="center" style="width: 100%;font-family: SolaimanLipi !important;">
   <span id="noprint"><a href="javascript: window.print()"style="margin: 1% 5% 5% 20%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/print-icon.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
        <span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -15px;">প্রিন্ট </span></a></span>
<span id="noprint"><a href="saleAgain.php?selltype=2"  style="margin: 1% 5% 5% 5%;display: block;width: 100px;height: 100px;float: left;background-image: url('images/newSell.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;">
        <span  style="font-size:20px;font-weight:bolder;position: absolute;margin:100px 5px 10px -70px;">পুনরায় বিক্রয় করুন</span></a></span>
</div>
  
</body>
</html>