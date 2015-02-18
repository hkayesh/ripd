<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$storeName= $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];

$selstmt = $conn->prepare("SELECT * FROM package_info WHERE idpckginfo = ANY(SELECT pckg_infoid FROM package_details WHERE product_chartid = ?)");
$selstmt2 = $conn->prepare("SELECT * FROM inventory WHERE ins_productid = ? AND ins_ons_type=? AND ins_ons_id=? AND ins_product_type=?");
$selstmt3 = $conn->prepare("SELECT * FROM inventory WHERE ins_ons_type=? AND ins_ons_id=? AND ins_product_type = 'package' ");

$sql_runningpv = $conn->prepare("SELECT * FROM running_command ;");
$sql_runningpv->execute();
$pvrow = $sql_runningpv->fetchAll();
foreach ($pvrow as $value) {
    $current_pv = $value['pv_value'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>প্যাকেজের ইনভেন্টরি</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
 <script src="scripts/tinybox.js" type="text/javascript"></script>
<style type="text/css">
.prolinks:focus{
    background-color: cadetblue;
    color: yellow !important;
}
.prolinks:hover{
    background-color: cadetblue;
    color: yellow !important;
}
</style>
<script type="text/javascript">
 function packageUpdate(id)
	{ TINY.box.show({iframe:'package_price_update.php?pckgid='+id,width:1200,height:600,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
 </script>
<!--===========================================================================================================================-->
<script>
function searchPckgPro(keystr) // show products from brand
{
    var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if(keystr.length ==0)
                {
                   document.getElementById('searchResult').style.display = "none";
               }
                else
                    {document.getElementById('searchResult').style.visibility = "visible";
                document.getElementById('searchResult').setAttribute('style','position:absolute;top:41%;left:36%;width:290px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
                    }
                document.getElementById('searchResult').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/searchPckgProduct.php?key="+keystr+"&location=package_inventory.php",true);
        xmlhttp.send();	
}
</script>  
</head>
    
<body>
<div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
    <div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
</div></br>
<div class="wraper" style="width: 80%;font-family: SolaimanLipi !important;">
<fieldset style="border-width: 3px;width: 100%;">
         <legend style="color: brown;">প্যাকেজ লিস্ট ফিল্টার</legend>
    <div class="top" style="width: 100%;height: auto;">
        <div class="topleft" style="width: 100%;"><b>প্যাকেজ পণ্য খুঁজুন&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            : <input type="text" name="pckgProSearch" onKeyUp="searchPckgPro(this.value);" autocomplete="off" style="width: 300px;"/></br>
        <div id="searchResult"></div>
        </div>
       </div>
</fieldset></div>

  <fieldset   style="border-width: 3px;margin:0 20px 50px 20px;font-family: SolaimanLipi !important;">
<legend style="color: brown;">প্যাকেজের তালিকা</legend>
<div id="resultTable">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;">
      <tr>
          <td width="8%"><div align="center"><strong>ক্রমিক নং</strong></div></td>
        <td width="15%"><div align="center"><strong>প্যাকেজ কোড</strong></div></td>
        <td width="30%"><div align="center"><strong>প্যাকেজের নাম</strong></div></td>
        <td width="8%"><div align="center"><strong>পরিমান</strong></div></td>
        <td width="10%"><div align="center"><strong>বিক্রয়মূল্য</strong></div></td>
        <td width="10%"><div align="center"><strong>এক্সট্রা প্রফিট</strong></div></td>
        <td width="10%"><div align="center"><strong>প্রফিট</strong></div></td>
        <td width="20%"><div align="center"><strong>পিভি</strong></div></td>
        <td width="10%"><div align="center"><strong></strong></div></td>
        
      </tr>
<?php
            if(isset($_GET['code']))
            {
                $productid= $_GET['code'];
                $selstmt ->execute(array($productid));
                $all = $selstmt->fetchAll();
                $sl = 1;
                    foreach($all as $row)
                    {
                        $pckgcode = $row['pckg_code'];
                        $pckgname = $row['pckg_name'];
                        $pckgid = $row['idpckginfo'];
                        $type = 'package';
                        $y=$selstmt2->execute(array($pckgid,$scatagory,$storeID,$type));
                        $get = $selstmt2->fetchAll();
                        $x= count($get);
                        if($x>=1)
                            { $status = "ব্যবহৃত হয়েছে";
                                foreach($get as $row2)
                                {
                                    $pckgqty = $row2['ins_how_many'];
                                    $pckgSelling = $row2['ins_sellingprice'];
                                    $pckgProfit = $row2['ins_profit'];
                                    $pckgXprofit = $row2['ins_extra_profit'];
                                    $pckgPV = $row2["ins_profit"] * $current_pv;
                                }
                                echo '<tr>';
                                echo '<td><div align="center">'.english2bangla($sl).'</div></td>';
                                echo '<td><div align="left">&nbsp;&nbsp'.$pckgcode.'</div></td>';
                                echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$pckgname.'</div></td>';
                                echo '<td><div align="center">'.$pckgqty.'</div></td>';
                                echo '<td><div align="center">'.english2bangla($pckgSelling).'</div></td>';
                                echo '<td><div align="center">'.english2bangla($pckgXprofit).'</div></td>';
                                echo '<td><div align="center">'.english2bangla($pckgProfit).'</div></td>';
                                echo '<td><div align="center">'.english2bangla($pckgPV).'</div></td>';
                                echo '<td><div align="center"><a onclick="packageUpdate('.$pckgid.')" style="cursor:pointer;" ><input  type="button" value="বিস্তারিত" style="font-family: SolaimanLipi !important;"/></a></div></td>';
                                echo '</tr>';
                                $sl++;
                            }
                            else 
                            {
                                break;
                            }
                      }
            }
      else
      {
          $selstmt3->execute(array($scatagory,$storeID));
          $all3 = $selstmt3->fetchAll();
          $sl = 1;
                    foreach($all3 as $row3)
                    {
                        $pckgcode = $row3['ins_product_code'];
                        $pckgname = $row3['ins_productname'];
                        $pckgqty = $row3['ins_how_many'];
                        $pckgSelling = $row3['ins_sellingprice'];
                        $pckgProfit = $row3['ins_profit'];
                        $pckgXprofit = $row3['ins_extra_profit'];
                        $pckgPV = $row3["ins_profit"] * $current_pv;
                        $pckgid = $row3['ins_productid'];
                            echo '<tr>';
                            echo '<td><div align="center">'.english2bangla($sl).'</div></td>';
                            echo '<td><div align="left">&nbsp;&nbsp'.$pckgcode.'</div></td>';
                            echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$pckgname.'</div></td>';
                            echo '<td><div align="center">'.english2bangla($pckgqty).'</div></td>';
                            echo '<td><div align="center">'.english2bangla($pckgSelling).'</div></td>';
                            echo '<td><div align="center">'.english2bangla($pckgXprofit).'</div></td>';
                            echo '<td><div align="center">'.english2bangla($pckgProfit).'</div></td>';
                            echo '<td><div align="center">'.english2bangla($pckgPV).'</div></td>';
                            echo '<td><div align="center"><a onclick="packageUpdate('.$pckgid.')" style="cursor:pointer;" ><input  type="button" value="মূল্য আপডেট" style="font-family: SolaimanLipi !important;"/></a></div></td>';
                            echo '</tr>';
                            $sl++;
                      }
          
      }
        
?>
</table>
</div>
</fieldset>

<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
  </div>
</body>
</html>