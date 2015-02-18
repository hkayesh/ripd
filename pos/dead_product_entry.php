<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';

$storeName= $_SESSION['loggedInOfficeName'];
$logedInUserID = $_SESSION['userIDUser'];

$ins_dead_product = $conn->prepare("INSERT INTO dead_product (inventory_id, qty,dd_buy_price, reason, entry_date, cfs_user_id) VALUES (?,?,?,?,NOW(),?)");

if(isset($_POST['submit']))
{
    $p_productID = $_POST['proInventID'];
    $result = $_SESSION['pro_inventory_array'][$p_productID];
    $db_buyingprice = $result["ins_buying_price"];
    $p_productQty = $_POST['QTY'];
    $p_productReason = $_POST['reason'];
    $result1= $ins_dead_product->execute(array($p_productID,$p_productQty, $db_buyingprice, $p_productReason,$logedInUserID));
    if($result1 == 1)
    {
        unset($_SESSION['pro_inventory_array']);
       echo "<script>alert('প্রোডাক্ট সফলভাবে বাতিল হয়েছে')</script>"; 
    }
 else {
        echo "<script>alert('প্রোডাক্ট সফলভাবে বাতিল হয়নি')</script>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>প্রোডাক্ট বাতিল</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
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
<script language="JavaScript" type="text/javascript" src="scripts/suggest.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/productsearch.js"></script>
<!--===========================================================================================================================-->
<script LANGUAGE="JavaScript">
function checkIt(evt) {
    evt = (evt) ? evt : window.event
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        status = ""
        return true
    }
    status = "This field accepts numbers only."
    return false
}
function numbersonly(e)
{
        var unicode=e.charCode? e.charCode : e.keyCode
            if (unicode!=8)
            { //if the key isn't the backspace key (which we should allow)
                if (unicode<48||unicode>57) //if not a number
                return false //disable key press
            }
}
function beforeSave()
{
      var a=document.getElementById('proInventID').value;
      var b=document.getElementById('QTY').value;
        if ((a != "") && (b != 0)) { return true; }
        else { return false; }
 }
</script>
</head>
    
<body>
<div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
<div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
    <div style="width: 33%;height: 100%;float: left;text-align: right;font-family: SolaimanLipi !important;"><a href="" onclick="javasrcipt:window.open('product_list.php');return false;" style="float: right;text-align: center;padding-left: 20px;"><img src="images/productList.png" style="width: 100px;height: 70px;"/></br>সেলসস্টোর প্রোডাক্ট লিস্ট</a></div>
</div>
</br>
<fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
         <legend style="color: brown;">পণ্য বাতিল</legend>         
    <div class="top" style="width: 100%;">
        <div class="topleft" style="float: left;width: 30%;"><b>প্রোডাক্ট কোড :</b>
            <input type="text" id="amots" name="amots" onKeyUp="bleble('dead_product_entry.php');" autocomplete="off" style="width: 250px;"/>
            <div style="width:430px;position:absolute;top:45.5%;left:8%;z-index:1;padding:5px;border: 1px solid #000000; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" id="layer2" ></div></br></br>
            <b>প্রোডাক্ট নাম&nbsp;&nbsp;: </b><input type="text" id="allsearch" name="allsearch" onKeyUp="searchProductAll('dead_product_entry.php');" autocomplete="off" style="width: 250px;"/>
            <div style="position:absolute;top:57.5%;left:8%;width:400px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" id="searchResult" ></div>
        </div>
    <div class="topright" style="float:left; width: 70%;">
    <?php
           if (isset($_GET['code'])) {
            $G_inventoryID = $_GET['code'];
            $result = $_SESSION['pro_inventory_array'][$G_inventoryID];
            $db_proname = $result["ins_productname"];
            $db_qty = $result["ins_how_many"];
            $db_procode = $result["ins_product_code"];
        }
    ?>
        <form method="POST" onsubmit="return beforeSave();" action="">
            <table width="100%" cellspacing="0"  cellpadding="0" style="border: #000000 inset 1px; font-size:20px;">
              <tr>
                  <td width="60%"><span style="color: #03C;"> প্রোডাক্টের কোড : </span><input name="pcode" id="pcode" type="text" value="<?php echo $db_procode; ?>" style="border:0px;font-size: 18px;width: 150px;" readonly/>
                      <input id="proInventID" name="proInventID" type="hidden" value="<?php echo $G_inventoryID; ?>"/></td>
                  <td colspan="2"><span style="color: #03C;"> বর্তমান পরিমান : </span><?php echo $db_qty;?> একক</td>           
              </tr>
              <tr>
                   <td ><span style="color: #03C;"> প্রোডাক্টের নাম : </span><input name="pname" id="pname" type="text" value="<?php echo $db_proname; ?>" style="border:0px;font-size: 18px;width: 315px;height: 50px;" readonly/></td>
                   <td colspan="2"><span style="color: #03C;">বাতিলকৃত পরিমাণ : </span> <input name="QTY" id="QTY" type="text" onkeypress=' return numbersonly(event)'  style="width:100px;" value="0"/></td>         
              </tr>
                <tr>
                    <td colspan="2"><span style="color: #03C;">বাতিলের কারন : </span> <textarea name="reason" ></textarea></td>         
              </tr>
                <tr>
                    <td colspan="2" style="text-align: center;"><br/><input class="btn" type="submit" readonly name="submit" value="বাতিল করুন" /></td>
                </tr>
            </table>
        </form>
</div>
</div>
</fieldset>

<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
  </div>
</body>
</html>
