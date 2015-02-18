<?php
//include 'session.php';
include 'includes/connectionPDO.php';
$G_onsid=$_SESSION['onsid'];
error_reporting(0);

$sql3="SELECT * FROM ons_relation WHERE idons_relation=$G_onsid";
               
               $stmt3= $conn->prepare($sql3);
               $stmt3->execute();
               $row3 = $stmt3->fetch();
              if(count($row3) > 1)
               {
                  $db_catogory= $row3['catagory'];
                  $_SESSION['catagory']=$db_catogory;
                  $db_id = $row3['add_ons_id'];
                   switch($db_catogory)
                   {
                       case 'office' : 
                           $sql4="SELECT * FROM office WHERE idOffice=$db_id";
                           $stmt4= $conn->prepare($sql4);
                           $stmt4->execute();
                            $row4 = $stmt4->fetch();
                            $_SESSION['offid']= $db_id;
                            $_SESSION['offname']= $row4['office_name'];
                       break;
                       
                        case 's_store' :
                            $sql4="SELECT * FROM sales_store WHERE idSales_store=$db_id";
                           $stmt4= $conn->prepare($sql4);
                           $stmt4->execute();
                            $row4 = $stmt4->fetch();
                            $_SESSION['offid']= $db_id;
                            $_SESSION['offname']= $row4['salesStore_name'];
                        break;
                   }
                   
               }
if($_GET['out']==1)
{
    session_destroy();
    header("location: index.php");
}
if($_GET['back']=='1')
{
    //session_destroy();
    unset($_SESSION['SESS_MEMBER_ID']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>রিপড সেলিং সিস্টেম</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

    <div id="maindiv" style="width: 960px !important;">
<div id="header" style="width:960px;height:100px;background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div>
<div id="topcontent" align="right" style="width:950px;height:30px;margin:0 auto;padding-right: 10px;"><a href="welcome.php?out=1" style="color: red;font-weight: bold;" >লগ আউট</a></div>

<div id="container" style="width:700px; height:500px; margin:10px auto 0 auto;padding:5px 50px 50px 50px;">
    <div style="float: left;margin: 1% 20% 5% 1%;"><a id="sales" href="newSale.php?selltype=1" style="display:block;width:200px;height:150px;background-image: url('images/generalSell.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;"><span  style="color:#FFF;font-size:32px;font-family: SolaimanLipi !important;font-weight:bolder;position: absolute;margin:150px 5px 10px -100px;">সাধারণ সেলিং</span></a></div>
    <div style="float: left;margin: 1% 1% 5% 17%;"><a id="sales" href="newSale.php?selltype=2" style="display:block;width:200px;height:150px;background-image: url('images/wholesale.gif');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;"><span  style="color:#FFF;font-size:32px;font-family: SolaimanLipi !important;font-weight:bolder;position: absolute;margin:150px 5px 10px -100px;">হোলসেল</span></a></div>
    <div style="float: left;margin: 0% 3% 5% 16%;"><a id="sales" href="productIN.php" style="display:block;width:200px;height:150px;background-image: url('images/productIN.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;"><span  style="color:#FFF;font-size:32px;font-family: SolaimanLipi !important;font-weight:bolder;position: absolute;margin:150px 5px 10px -80px;">প্রোডাক্ট এন্ট্রি</span></a></div>
    <div style="float: left;margin: 0% 5% 5% 4%;"><a id="sales" href="packageWelcome.php" style="display:block;width:200px;height:150px;background-image: url('images/package.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;"><span  style="color:#FFF;font-size:32px;font-family: SolaimanLipi !important;font-weight:bolder;position: absolute;margin:150px 5px 10px -60px;">প্যাকেজ</span></a></div>
    <div style="float: left;margin: 1% 5% 5% 1%;"><a id="sales" href="replace.php" style="display:block;width:200px;height:150px;background-image: url('images/replace.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;"><span  style="color:#FFF;font-size:32px;font-family: SolaimanLipi !important;font-weight:bolder;position: absolute;margin:150px 5px 10px -100px;">রিপ্লেস প্রোডাক্ট</span></a></div>
    <div style="float: left;margin: 1% 5% 5% 30%;"><a id="sales" href="" onclick="javasrcipt:window.open('product_list.php');return false;" style="display:block;width:200px;height:150px;background-image: url('images/productList.png');background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;"><span  style="color:#FFF;font-size:32px;font-family: SolaimanLipi !important;font-weight:bolder;position: absolute;margin:150px 5px 10px -100px;">পণ্যের তালিকা</span></a></div>
</div></br>
<div style="background-color:#f2efef;border-top:#009 dashed 2px;padding:3px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
     RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
</div>
    
</body>
</html>
