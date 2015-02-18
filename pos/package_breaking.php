<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$storeName= $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
$check = 0; $msg ="";

$stmt = $conn->prepare("SELECT * FROM package_inventory WHERE pckg_infoid=? AND ons_type=? AND ons_id=? AND pckg_type=?");
$selstmt2 = $conn->prepare("SELECT * FROM inventory WHERE ins_productid=? AND ins_ons_type=? AND ins_ons_id=?");
$insstmt = $conn ->prepare("INSERT INTO package_inventory(pckg_infoid ,pckg_quantity ,pckg_selling_price ,pckg_buying_price, pckg_profit, pckg_extraprofit, making_date, pckg_makerid, pckg_type, ons_type, ons_id) VALUES (?, ?, ?, ?, ?, ?, ?, ? ,?, ?, ?)");
$selectstmt = $conn ->prepare("SELECT * FROM package_info WHERE idpckginfo= ?");
$selectstmt2 = $conn ->prepare("SELECT * FROM package_details WHERE pckg_infoid = ?");
$selectstmt3 = $conn ->prepare("SELECT * FROM product_chart WHERE idproductchart= ? ");

if(isset($_POST['break']))
{
    $P_break = $_POST['breakingQty'];
    $P_pckgid = $_POST['pckgID'];
    
    $type = 'making';
    $instype = 'breaking';
    
    $stmt->execute(array($P_pckgid,$scatagory,$storeID,$type));
    $getpckg = $stmt->fetchAll();
              foreach($getpckg as $pckg)
                  {
                     $db_pckgqty = $pckg['pckg_quantity'];
                     $db_pckgsell = $pckg['pckg_selling_price'];
                     $db_pckgbuy = $pckg['pckg_buying_price'];
                     $db_pckgprofit = $pckg['pckg_profit'];
                     $db_pckgxprofit = $pckg['pckg_extraprofit'];
                   }
     $timestamp=time(); //current timestamp
     $date=date("Y/m/d", $timestamp);  
    
    $yes= $insstmt->execute(array($P_pckgid,$P_break,$db_pckgsell,$db_pckgbuy,$db_pckgprofit,$db_pckgxprofit,$date,$cfsID,$instype,$scatagory,$storeID));
    if($yes ==1){$msg = "প্যাকেজগুলো সফলভাবে ব্রেক হয়েছে";}
       else { $msg = "দুঃখিত প্যাকেজগুলো ব্রেক হয়নি";}
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>প্যাকেজ ব্রেক</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<script src="scripts/jquery-1.10.2.min.js"></script>
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
<script type="text/javascript">
function ShowTime()
{
      if (document.getElementById("breakingQty").value == '')
           {
               document.getElementById("ok").disabled = false;
           }
       
       if (document.getElementById("ok").disabled == true)
           {
               document.getElementById("break").disabled = false;
           }
       else {document.getElementById("break").disabled = true;}

}

$(document).ready(function(){
  $('#ok').click(function() {
    if(parseInt($('#breakingQty').val()) > parseInt($('#pckgQty').val()) )
        {
            $("#show").css('color','red');
            $("#show").html("দুঃখিত, এই পরিমান প্যাকেজ ব্রেক করা যাবে না");
            $('#break').attr('disabled','disabled');
        }
        else{ 
            $("#show").css('color','green');
            $("#show").html("প্যাকেজ ব্রেক করুন");
            $('#ok').attr('disabled','disabled');
            $('#break').removeAttr('disabled');
        }
  });
});

function numbersonly(e)
   {
        var unicode=e.charCode? e.charCode : e.keyCode
            if (unicode!=8)
            { //if the key isn't the backspace key (which we should allow)
                if (unicode<48||unicode>57) //if not a number
                return false //disable key press
            }
}
function beforeSubmit()
{
    var qty = Number(document.getElementById('pckgQty').value);
    var brkqty = Number(document.getElementById('breakingQty').value);
    if( brkqty > qty )
        {
            document.getElementById('ok').disabled = false;
            document.getElementById('break').disabled = true;
            return false;
        }
        else { return true; }
}
</script>	
<!--===========================================================================================================================-->
<script>
function searchInventoryPckg(str_key) // for searching packages from own inventory
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
            if(str_key.length ==0)
                {
                   document.getElementById('searchResult').style.display = "none";
               }
                else
                    {   document.getElementById('searchResult').style.visibility = "visible";
                         document.getElementById('searchResult').setAttribute('style','position:absolute;top:41%;left:33.5%;width:290px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
                    }
                document.getElementById('searchResult').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/searchPckgForBreak.php?searchKey="+str_key,true);
        xmlhttp.send();	
}

function checkqty(qty,left,ri8)
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
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
               document.getElementById('check').value=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/checkPckgQty.php?pckgqty="+qty+"&leftstr="+left+"&ri8str="+ri8,true);
        xmlhttp.send();
}

function getUpdate(xprofit)
{
   var profit = Number(document.getElementById('updateprofit').value);
   var totalprft = profit + Number(xprofit);
    var curprft = Number(document.getElementById('currentpckgprft').value);
    var curxprft = Number(document.getElementById('currentpckgxprft').value);
    var totalcurprft = curprft + curxprft;
    if(totalprft < totalcurprft)
        {
            var difference = totalcurprft - totalprft;
            var currentsell = Number(document.getElementById('currentpckgprz').value);
            var updatesell = currentsell - difference;
            document.getElementById('updatesellprz').value = updatesell;
        }
        else
            {
                var difference = totalprft - totalcurprft;
                var currentsell = Number(document.getElementById('currentpckgprz').value);
                var updatesell = currentsell +difference;
                document.getElementById('updatesellprz').value = updatesell;
            }
}
</script>  
</head>
    
<body onLoad="ShowTime()">
<div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
    <div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
    <div style="width: 33%;height: 100%;float: left;text-align: right;font-family: SolaimanLipi !important;"><a href="" style="text-decoration: none;" onclick="javasrcipt:window.open('package_list.php');return false;"><img src="images/packagelist.png" style="width: 100px;height: 70px;"/></br>প্যাকেজ লিস্ট</a></div>
</div>
</br>
 <?php
    if($msg != "")
    {
?>
<div align="center" style="color: green;font-size: 26px; font-weight: bold; width: 90%;height: 20px;margin: 0 5% 0 5%;float: none;"><?php if($msg != "") echo $msg;?></div></br></br></br></br></br></br></br></br></br>
    <?php } 
    else { ?>
<div class="wraper" style="width: 80%;font-family: SolaimanLipi !important;float: none;">
<fieldset style="border-width: 3px;width: 100%;">
         <legend style="color: brown;">প্যাকেজ খুঁজুন</legend>
    <div class="top" style="width: 100%;height: auto;">
        <div class="topleft" style="width: 60%;float: left;"><b>প্যাকেজ কোড&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            : <input type="text" id="searchPckg" name="searchPckg" onKeyUp="searchInventoryPckg(this.value)" autocomplete="off" style="width: 300px;"/></br>
                <div id="searchResult"></div>
        </div>
   </div>
</fieldset>
</div></br>
<div  class="wraper" style="width: 80%;font-family: SolaimanLipi !important;float: none;border: solid 1px #000;">
    <form method="post" action="package_breaking.php" onsubmit="return beforeSubmit();">
        <div style="width: 100%;height: auto;float: none;">
            <table>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>
                                    <fieldset style="border-width: 3px;width: 95%;">
                                         <legend style="color: brown;">প্যাকেজ বিবরণ</legend>
                                         <?php
                                                    if(isset($_GET['id']))
                                                    {
                                                        $pckgid = $_GET['id'];
                                                        $selectstmt->execute(array($pckgid));
                                                        $all = $selectstmt->fetchAll();
                                                        foreach($all as $row)
                                                        {
                                                            $db_pckgname= $row['pckg_name'];
                                                            $db_pckgcode = $row['pckg_code'];
                                                        }
                                                        $selstmt2->execute(array($pckgid,$scatagory,$storeID));
                                                        $getpckg = $selstmt2->fetchAll();
                                                        foreach($getpckg as $pckg)
                                                        {
                                                            $db_pckgqty = $pckg['ins_how_many'];
                                                        }
                                                        if($db_pckgqty == 0)
                                                        {
                                                            $check =1;
                                                        }
                                                        $arr_pro_chartid = array();
                                                        $arr_pro_qty = array();
                                                        $selectstmt2->execute(array($pckgid));
                                                        $getall = $selectstmt2->fetchAll();
                                                        foreach($getall as $row2)
                                                        {
                                                            array_push($arr_pro_chartid, $row2['product_chartid']);
                                                            array_push($arr_pro_qty, $row2['product_quantity']);
                                                        }
                                                    }
                                         ?>
                                         <b>প্যাকেজের নাম&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input type="text" id="pckgName" name="pckgName" readonly value="<?php echo $db_pckgname;?>" style="width: 300px;"/><input type="hidden" name="pckgID"  value="<?php echo $pckgid;?>"/></br>
                                         <b>প্যাকেজ কোড&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b> <input type="text" id="pckgCode" name="pckgCode" readonly value="<?php echo $db_pckgcode;?>" style="width: 300px;"/></br>
                                         <b>প্যাকেজের পরিমাণ :</b> <input type="text" id="pckgQty" name="pckgQty" style="width: 300px;" readonly value="<?php echo $db_pckgqty;?>" /></br>
                                         <input type='hidden' name='pckgproid' value='<?php echo serialize($arr_pro_chartid); ?>' />
                                         <input type='hidden' name='pckgqty' value='<?php echo serialize($arr_pro_qty); ?>' /></br>
                                         <table border="">
                                             <thead style="background-color: #ffcccc">
                                                 <th width="33%">পণ্যের কোড</th>
                                                 <th width="53%">পণ্যের নাম</th>
                                                 <th width="14%">পরিমাণ</th>
                                             </thead>                                       
                                                 <?php
                                                            $rowNumber = count($arr_pro_chartid);
                                                            for($i = 0 ; $i< $rowNumber; $i++)
                                                            {
                                                                $prochartid = $arr_pro_chartid[$i];
                                                                $proqty = $arr_pro_qty[$i];
                                                                $selectstmt3->execute(array($prochartid));
                                                                $all3 = $selectstmt3->fetchAll();
                                                                foreach($all3 as $row3)
                                                                {
                                                                    $procode = $row3['pro_code'];
                                                                    $proname = $row3['pro_productname'];
                                                                }
                                                                echo "<tbody><td>$procode </td>
                                                                         <td>$proname</td>
                                                                         <td align='center'>$proqty</td></tbody>";
                                                             }
                                                     ?>
                                         </table>
                                    </fieldset>
                                </td>                               
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <?php if($check !=1) {?>
                        <b>যতটা প্যাকেজ ভাঙতে চাই : </b> <input type="text" id="breakingQty" name="breakingQty" onkeypress=' return numbersonly(event)' style="width: 200px;"/></br>
                        <input type="hidden"  id="check"  value="0" /><span id="show"></span></br>
                        <input  id="ok" type="button" value="ঠিক আছে" style="cursor:pointer;width:80px;height: 25px;font-family: SolaimanLipi !important;" />
                        <input name="break" id="break" type="submit" value="ব্রেক" style="cursor:pointer;width:80px;height: 25px;font-family: SolaimanLipi !important;" /></br></br>
                        <?php } else { echo "<span style='color:red;'>দুঃখিত, এই প্যাকেজটি ব্রেক করার জন্য প্রয়োজনীয় পরিমান পণ্য নেই </span>";}?>
                    </td>
                </tr>
            </table>
        </div>
</form>
</div>
<?php }?>
<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
</body>
</html>