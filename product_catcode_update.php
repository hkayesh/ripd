<?php
error_reporting(0);
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$g_catcode = $_GET['catCode'];
$g_cataname = $_GET['catName'];

$sql_up_category = $conn->prepare("UPDATE product_catagory SET pro_cat_code = ? WHERE  pro_cat_code = ?");
$sql_sel_prochart = $conn->prepare("SELECT pro_code FROM product_chart WHERE  pro_code LIKE ?");
$sql_up_prochart = $conn->prepare("UPDATE product_chart SET pro_code = ? WHERE  pro_code = ?");
$sql_sel_inventory = $conn->prepare("SELECT ins_product_code FROM inventory WHERE ins_product_code LIKE ?");
$sql_up_inventory = $conn->prepare("UPDATE inventory SET ins_product_code = ? WHERE ins_product_code = ?");
$msg ="";

if(isset($_POST['update']))
{
    $conn->beginTransaction();
    
    $p_current = $_POST['current_code'];
    $p_update = $_POST['up_code'];
    $upquery1 = $sql_up_category->execute(array($p_update,$p_current));
    
    $searchkey = $p_current.'%';
    $sql_sel_prochart->execute(array($searchkey));
    $chartrow = $sql_sel_prochart->fetchAll();
    foreach ($chartrow as $value) {
        $db_code = $value['pro_code'];
        $new_code = str_replace($p_current, $p_update, $db_code);
        $upquery2 = $sql_up_prochart->execute(array($new_code,$db_code));
    }
     
    $sql_sel_inventory->execute(array($searchkey));
    $inventrow = $sql_sel_inventory->fetchAll();
    foreach ($inventrow as $value) {
        $db_code = $value['ins_product_code'];
        $new_code = str_replace($p_current, $p_update, $db_code);
        $upquery3 = $sql_up_inventory->execute(array($new_code,$db_code));
    }
    
    if ($upquery1 && $upquery2 && $upquery3)
        {
            $conn->commit();
            $msg = "আপডেট হয়েছে"; 
        }
        else {
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
                    <tr><th colspan="2" style="text-align: center;">আপডেট ক্যাটাগরির কোড</th></tr>
                    <?php if($msg == "") {?>
                     <tr>
                    <td style="text-align: center; width: 50%;">ক্যাটাগরি</td>
                    <td>: <input  class="box" type="text" name="catagori"  id="catagori" value="<?php echo $g_cataname;?>" readonly /></td>   
                    </tr>
                  <tr>
                    <td style="text-align: center; width: 50%;">বর্তমান কোড</td>
                    <td>: <input  class="box" type="text" name="current_code"  id="current_code" value="<?php echo $g_catcode;?>" readonly /></td>   
                    </tr>
                    <tr>
                    <td style="text-align: center; width: 50%;">নতুন কোড</td>
                    <td>: <input  class="box" type="text" name="up_code"  id="up_code" /></td>   
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