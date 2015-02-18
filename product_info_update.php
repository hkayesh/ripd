<?php
error_reporting(0);
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$g_proChartID = $_GET['proID'];
$sql_select_product = $conn->prepare("SELECT * FROM product_chart WHERE idproductchart = ?");
$sql_up_prochart = $conn->prepare("UPDATE product_chart SET pro_code = ?, pro_productname=?, pro_article=?,
    pro_guarantee=?, pro_warantee=?, pro_companyname=?, pro_madein=?, pro_picture=? WHERE  idproductchart = ?");

$sql_up_inventory = $conn->prepare("UPDATE inventory SET ins_product_code = ?, ins_productname=? WHERE  ins_product_code = ?");

$msg ="";

$sql_select_product->execute(array($g_proChartID));
$prorow = $sql_select_product->fetchAll();
foreach ($prorow as $row) {
    $db_name = $row['pro_productname'];
    $db_code = $row['pro_code'];
    $db_article = $row['pro_article']; 
    $db_guarantee = $row['pro_guarantee'];
    $db_warantee = $row['pro_warantee'];
    $db_company = $row['pro_companyname'];
    $db_madein = $row['pro_madein'];
    $db_pic = $row['pro_picture'];
}
if(isset($_POST['update']))
{
    $p_name = $_POST['pro_productname'];
    $p_oldname = $_POST['old_productname'];
    $p_code = $_POST['pro_productcode'];
    $p_oldcode = $_POST['old_productcode'];
    $p_article = $_POST['pro_article'];
    $p_guarantee = $_POST['pro_guarantee'];
    $p_warantee = $_POST['pro_warantee'];
    $p_company = $_POST['pro_companyname'];
    $p_madein = $_POST['pro_madein'];
    $p_proid = $_POST['proID'];
    $p_oldimgpath = $_POST['oldimg'];
    
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
    $extension = end(explode(".", $_FILES["image"]["name"]));
    $image_name = $_FILES["image"]["name"];
     if($image_name=="")
    {
         $image_path = $p_oldimgpath;
    }
    else
    {
        $image_name = "picture_".$image_name;
        $image_path = "pic/" . $image_name;
        if (($_FILES["image"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                {
                    move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);
                } 
    }
    
    $conn->beginTransaction();
    $upquery = $sql_up_prochart->execute(array($p_code,$p_name,$p_article,$p_guarantee,$p_warantee,$p_company,$p_madein,$image_path,$p_proid));
    $upquery1 = $sql_up_inventory->execute(array($p_code,$p_name,$p_oldcode));

    if ($upquery  && $upquery1)
        {
            $conn->commit();
            $msg = "আপডেট হয়েছে"; 
        }
        else 
            { 
                $conn->rollBack();
                $msg ="আপডেট হয়নি"; 
            }
}
?>
<script>
    function out()
    {
        setTimeout(function(){parent.location.href=parent.location.href;},1000);
    }
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css"> @import "css/bush.css";</style>
</head>
<body>
    <form method="POST"  action="">	
        <table  class="formstyle" style="font-family: SolaimanLipi !important;margin: 0 !important;">          
            <tr><th colspan="2" style="text-align: center;">আপডেট পণ্য তথ্য</th></tr>
            <?php if($msg == "") {?>
            <tr>
                <td><b>প্রোডাক্টের নাম</b></td>
                <td>: <input class="box" style="width: 250px;" type="text" id="pro_productname" name="pro_productname" value="<?php echo $db_name;?>"/>
                <input type="hidden" name="old_productname" value="<?php echo $db_name;?>"/></td>
            </tr>
            <tr>         
                <td><b>প্রোডাক্ট কোড</b></td>
                <td>: <input class="box" style="width: 250px;" type="text" name="pro_productcode" value="<?php echo $db_code;?>" />
                <input type="hidden" name="old_productcode" value="<?php echo $db_code;?>" /></td>
            </tr>
            <tr>
                <td ><b>আটিকেল</b></td>
                <td>:   <input class="box" style="width: 250px;" type="text" id="pro_article" name="pro_article" value="<?php echo $db_article;?>" />
                <input type="hidden" name="proID" value="<?php echo $g_proChartID;?>" /></td>                          
            </tr>
            <tr>
                <td><b>গ্যারান্টি</b></td>
                <td>: <input  class="box" style="width: 250px;" type="text" id="pro_guarantee" name="pro_guarantee" value="<?php echo $db_guarantee;?>" /></td>            
            </tr>
            <tr>
                <td><b>ওয়ারেন্টি</b></td>
                <td>: <input  class="box" style="width: 250px;" type="text" id="pro_warantee" name="pro_warantee" value="<?php echo $db_warantee;?>" /></td>            
            </tr>
            <tr>
                <td><b>তৈরীকৃত প্রতিষ্ঠানের নাম</b></td>
                <td>: <input  class="box" style="width: 250px;" type="text" id="pro_companyname" name="pro_companyname" value="<?php echo $db_company;?>" /></td>            
            </tr>
            <tr>
                <td><b>মেড ইন</b></td>
                <td>: <input  class="box" style="width: 250px;" type="text" id="pro_madein" name="pro_madein" value="<?php echo $db_madein;?>" /></td>            
            </tr>        
        <tr>
            <td><b>প্রোডাক্টের ছবি</b></td> 
            <td>: <img src="<?php echo $db_pic;?>" width="80px" height="80px"/>&nbsp;<input class="filefield" type="file" id="image" name="image" />
            <input type="hidden" name="oldimg" value="<?php echo $db_pic;?>" /></td>
        </tr>
            <tr>                    
                <td colspan="2" style="padding-left: 150px; " ></br><input class="btn" style =" font-size: 12px; " type="submit" name="update" value="আপডেট করুন" />
                <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
            </tr>
            <?php }    
            else { ?>
            <tr>
                <td colspan="2" style="text-align: center; font-size: 16px;color: green;"><?php echo $msg;  echo "<script>out();</script>";?></td>          
            </tr><?php }?>
        </table>
    </form>
</body>
</html>