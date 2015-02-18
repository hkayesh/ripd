<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$sel_offices = $conn->prepare("SELECT idOffice,office_name FROM office ORDER BY office_name ");
$sel_stores = $conn->prepare("SELECT idSales_store, salesStore_name FROM sales_store ORDER BY salesStore_name ");

function getoffices($sql) {
    echo "<option value=0> -সিলেক্ট করুন- </option>";
    $sql->execute();
    $arr_off = $sql->fetchAll();
    foreach ($arr_off as $offrow) {
        echo "<option value=" . $offrow['idOffice'] . ">" . $offrow['office_name'] . "</option>";
    }
}

function getstores($sql) {
    echo "<option value=0> -সিলেক্ট করুন- </option>";
    $sql->execute();
    $arr_store = $sql->fetchAll();
    foreach ($arr_store as $storerow) {
        echo "<option value=" . $storerow['idSales_store'] . ">" . $storerow['salesStore_name'] . "</option>";
    }
}

$storeName= $_SESSION['loggedInOfficeName'];
$storeType = $_SESSION['loggedInOfficeType'] ;
$storeID = $_SESSION['loggedInOfficeID'];
$logedInUserID = $_SESSION['userIDUser'];

$ins_product_transfer = $conn->prepare("INSERT INTO product_transfer (pt_transfer_id, pt_sender_type, pt_sender_id, pt_reciver_type, pt_reciver_id,fk_product_chart_id,pt_qty, pt_total_buying, pt_total_xtraprofit, pt_sending_date, pt_transfer_status) 
                                                                VALUES (?,?,?,?,?,?,?,?,?,NOW(),'send')");
$up_inventory = $conn->prepare("UPDATE inventory SET ins_how_many = ins_how_many - ? WHERE idinventory =?");

$insert_notification = $conn->prepare("INSERT INTO notification (nfc_senderid,nfc_receiverid,nfc_message,nfc_actionurl,nfc_date,nfc_status, nfc_type, nfc_catagory) 
                                                            VALUES (?,?,?,?,NOW(),?,?,?)");
$sql_select_id_ons_relation = $conn->prepare("SELECT idons_relation FROM  ons_relation WHERE catagory =  ? AND add_ons_id = ?");

if(isset($_POST['submit']))
{
    $p_proinventID = $_POST['proInventID'];
    $p_prochartID = $_POST['proChartID'];
    $p_rcverType = $_POST['type'];
    $p_rcverID = $_POST['id'];
    $p_unitbuying = $_POST['updatedbuying'];
    $p_unitxtraprofit = $_POST['updatedxprofit'];
    $p_qty = $_POST['QTY'];
    $total_buyingprice = $p_unitbuying * $p_qty;
    $total_xtraprofit = $p_unitxtraprofit * $p_qty;
    $transfer_id = get_time_random_no(10);
    
     $sql_select_id_ons_relation->execute(array($p_rcverType,$p_rcverID));
            $onsrow = $sql_select_id_ons_relation->fetchAll();
            foreach ($onsrow as $value) {
                $db_onsID = $value['idons_relation'];
            }
            
    
    $msg = "আপনার স্টোরে কিছু প্রোডাক্ট ট্রান্সফার হয়ে এসেছে";
    $status = "unread";
    $type="action";
    $nfc_catagory="official";
    
    $conn->beginTransaction(); 
    $sqlrslt1= $ins_product_transfer->execute(array($transfer_id,$storeType,$storeID,$p_rcverType,$p_rcverID,$p_prochartID,$p_qty,$total_buyingprice,$total_xtraprofit));
    $pro_transfer_id = $conn->lastInsertId();   
    $sqlrslt2 = $up_inventory->execute(array($p_qty,$p_proinventID));
    $url = "pos/receive_transfer_product.php?id=".$pro_transfer_id;
    $sqlrslt3 = $insert_notification->execute(array($logedInUserID,$db_onsID,$msg,$url,$status,$type,$nfc_catagory));
    
    if($sqlrslt1  && $sqlrslt2 && $sqlrslt3)
        {
            $conn->commit();
            echo "<script>alert('প্রোডাক্ট সফলভাবে ট্রান্সফার হয়েছে')</script>";
        }
        else {
            $conn->rollBack();
            echo "<script>alert('দুঃখিত,প্রোডাক্ট ট্রান্সফার হয়নি')</script>";
        }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>প্রোডাক্ট ট্রান্সফার</title>
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
function calculate(val)
{ 
    var xprofit = Number(val);
    var buying = Number(document.getElementById("updatedbuying").value);

    document.getElementById("updatedselling").value = xprofit+buying;
}
function setvalues(type,id)
{
    document.getElementById("type").value = type;
    document.getElementById("id").value = id;
}
function beforeSave()
{
     var id = document.getElementById("id").value;
      var a=document.getElementById('proInventID').value;
      var b=document.getElementById('QTY').value;
        if ((a != "") && (b != 0) && id !="") { return true; }
        else 
        { 
            alert("দুঃখিত,* চিহ্নিত বক্সগুলে সঠিকভাবে পূরণ করুন");
            return false; 
        }
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
         <legend style="color: brown;">প্রোডাক্ট ট্রান্সফার</legend>         
    <div class="top" style="width: 100%;">
        <div class="topleft" style="float: left;width: 25%;"><b>প্রোডাক্ট কোড :</b>
            <input type="text" id="amots" name="amots" onKeyUp="bleble('store_to_store_transfer.php');" autocomplete="off" style="width: 250px;"/>
            <div style="width:430px;position:absolute;top:45.5%;left:8%;z-index:1;padding:5px;border: 1px solid #000000; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" id="layer2" ></div></br></br>
            <b>অফিস&nbsp;&nbsp;: </b>
            <select style="width: 250px;" onchange="setvalues('office',this.value)"><?php echo getoffices($sel_offices)?></select><em>*</em><br/>
                <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;অথবা </b><br/>
            <b>সেলসস্টোর :</b>
            <select style="width: 250px;" onchange="setvalues('s_store',this.value)"><?php echo getstores($sel_stores)?></select><em>*</em><br/>
        </div>
    <div class="topright" style="float:left; width: 75%;">
    <?php
           if (isset($_GET['code'])) {
            $G_inventoryID = $_GET['code'];
            $result = $_SESSION['pro_inventory_array'][$G_inventoryID];
            $db_proname = $result["ins_productname"];
            $db_qty = $result["ins_how_many"];
            $db_procode = $result["ins_product_code"];
            $db_buying = $result["ins_buying_price"];
            $db_selling = $result["ins_sellingprice"];
            $db_xtraprofit = $result["ins_extra_profit"];
            $db_profit = $result["ins_profit"];
            $db_prochartid = $result["ins_productid"];
        }
    ?>
        <form method="POST" onsubmit="return beforeSave();" action="store_to_store_transfer.php">
            <table width="100%" cellspacing="0"  cellpadding="0" style="border: #000000 inset 1px; font-size:20px;">
              <tr>
                  <td width="60%"><span style="color: #03C;"> প্রোডাক্টের কোড : </span><input name="pcode" id="pcode" type="text" value="<?php echo $db_procode; ?>" style="border:0px;font-size: 18px;width: 150px;" readonly/>
                      <input id="proInventID" name="proInventID" type="hidden" value="<?php echo $G_inventoryID; ?>"/></td>
                  <td colspan="2"><span style="color: #03C;"> বর্তমান পরিমান : </span><?php echo $db_qty;?> একক<input id="proChartID" name="proChartID" type="hidden" value="<?php echo $db_prochartid; ?>"/></td>           
              </tr>
              <tr>
                   <td ><span style="color: #03C;"> প্রোডাক্টের নাম : </span><input name="pname" id="pname" type="text" value="<?php echo $db_proname; ?>" style="border:0px;font-size: 18px;width: 315px;height: 50px;" readonly/></td>
                   <td colspan="2"><span style="color: #03C;">ট্রান্সফারকৃত পরিমাণ : </span> <input name="QTY" id="QTY" type="text" onkeypress=' return numbersonly(event)'  style="width:100px;" value="0"/><em>*</em></td>         
              </tr>
                <tr>
                    <td colspan="2">
                <table cellpadding="0" cellspacing="0" style="font-family: SolaimanLipi !important;">
                    <tr>
                        <td>
                            <fieldset style="border-width: 2px;width: 90%;">
                                <legend style="color: brown;">প্রোডাক্টের বর্তমান মূল্য</legend>
                                <table border="1" cellpadding="0" cellspacing="0" style="font-family: SolaimanLipi !important;">
                                    <tr>
                                        <td colspan="2">ক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" readonly name="buyingprice" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" value="<?php echo $db_buying; ?>" /> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">এক্সট্রা প্রফিট : <input type="text" name="xprofit" readonly value="<?php echo $db_xtraprofit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" readonly name="xprofit" value="<?php echo $db_profit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">বিক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" readonly name="sellingprice" value="<?php echo  $db_selling;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /> টাকা</td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                        <td>
                            <fieldset style="border-width: 2px;width: 90%;">
                                <legend style="color: brown;"> প্রোডাক্টের ট্রান্সফার মূল্য</legend>
                                <table border="1" cellpadding="0" cellspacing="0" style="font-family: SolaimanLipi !important;">
                                    <tr>
                                        <td colspan="2">ক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" name="updatedbuying" id="updatedbuying" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" readonly value="<?php echo $db_buying?>" /> টাকা
                                            <input type="hidden" name="type" id="type" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">এক্সট্রা প্রফিট : <input type="text" name="updatedxprofit" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" onkeyup="calculate(this.value)"  value="<?php echo $db_xtraprofit;?>"onkeypress='return checkIt(event)' /> টাকা
                                        <input type="hidden" name="id" id="id" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" name="updatedprofit" id="updatedprofit" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" readonly value="0"/> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">ট্রান্সফারমূল্য&nbsp;: <input type="text" name="updatedselling" id="updatedselling"  style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" readonly value="<?php echo $db_buying+$db_xtraprofit;?>" /> টাকা</td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;"><br/><input class="btn" type="submit" style="width: 150px;" readonly name="submit" value="ট্রান্সফার করুন" /></td>
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