<?php
error_reporting(0);
include 'includes/ConnectDB.inc';
include 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';

$pckgid =$_GET['pckgid'];
$str_price = "";
$selsql ="SELECT * FROM package_info WHERE idpckginfo=?";
$selstmt = $conn->prepare($selsql);
$selstmt->execute(array($pckgid));
 $all = $selstmt->fetchAll();
                    foreach($all as $row)
                    {
                        $pckgname = $row['pckg_name'];
                        $pckgcode = $row['pckg_code'];
                    }
$selsql2 ="SELECT * FROM inventory WHERE ins_productid = ? AND ins_product_type='package' ";
$selstmt2 = $conn->prepare($selsql2);
$selstmt2->execute(array($pckgid));
$all2 = $selstmt2->fetchAll();
$count = count($all2);
if($count >1)
{
    foreach ($all2 as $row2)
    {
        $str_price = $str_price.$row2['ins_sellingprice'].", ";
    }
}
else {
    foreach ($all2 as $row2)
    {
        $str_price = $row2['ins_sellingprice'];
    }
}
$sql3 = "SELECT * FROM package_details WHERE pckg_infoid = ?";
$selectstmt3 = $conn ->prepare($sql3);
$arr_pro_chartid = array();
$arr_pro_qty = array();
$selectstmt3->execute(array($pckgid));
$getall = $selectstmt3->fetchAll();
foreach($getall as $row3)
    {
        array_push($arr_pro_chartid, $row3['product_chartid']);
        array_push($arr_pro_qty, $row3['product_quantity']);
    }
    
    $sql4 = "SELECT * FROM product_chart WHERE idproductchart= ? ";
    $selectstmt4 = $conn ->prepare($sql4);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>প্যাকেজের ইনভেন্টরি</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
</head>
<body>
    <div id="maindiv">
        <div align="center" style="width: 100%;font-family: SolaimanLipi !important; padding: 10px;color: #000;">
            
                                    <fieldset style="border-width: 3px;width: 90%;font-family: SolaimanLipi !important;">
                                         <legend style="color: brown;">প্যাকেজ বিবরণ</legend>
                                         <b>প্যাকেজের নাম &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input type="text" id="pckgName" name="pckgName" readonly style="width: 200px;" value="<?php echo $pckgname;?>"/></br>
                                         <b>প্যাকেজ কোড &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b> <input type="text" id="pckgCode" name="pckgCode" readonly style="width: 200px;" value="<?php echo $pckgcode;?>"/></br>
                                         <b>প্যাকেজের বিক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b> <input type="text" id="pckgPrice" name="pckgPrice" readonly style="width: 200px;text-align: right" value="<?php echo $str_price;?>"/> টাকা</br>
                                         <table border="1" style="font-family: SolaimanLipi !important;">
                                             <thead style="background-color: #ffcccc">
                                                 <th width="33%">পণ্যের কোড</th>
                                                 <th width="41%">পণ্যের নাম</th>
                                                 <th width="24%">পরিমাণ</th>
                                             </thead>
                                             <?php
                                                            $rowNumber = count($arr_pro_chartid);
                                                            for($i = 0 ; $i< $rowNumber; $i++)
                                                            {
                                                                $prochartid = $arr_pro_chartid[$i];
                                                                $proqty = $arr_pro_qty[$i];
                                                                $selectstmt4->execute(array($prochartid));
                                                                $all4 = $selectstmt4->fetchAll();
                                                                foreach($all4 as $row4)
                                                                {
                                                                    $procode = $row4['pro_code'];
                                                                    $proname = $row4['pro_productname'];
                                                                }
                                                                echo "<tbody><td>$procode </td>
                                                                         <td>$proname</td>
                                                                         <td align='center'>$proqty</td></tbody>";
                                                           }
                                                     ?>
                                         </table>
                                    </fieldset>
                                
        </div>
    </div>
</body>
</html>
