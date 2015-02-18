<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$storeName = $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory = $_SESSION['loggedInOfficeType'];

$sql_select_purchase_list = $conn->prepare("SELECT in_input_date, chalan_no, pro_code, pro_productname, in_howmany, in_buying_price, account_name
                                                    FROM cfs_user, product_purchase, product_chart, product_purchase_summary
                                                    WHERE product_purchase.Product_chart_idproductchart = product_chart.idproductchart
                                                    AND product_purchase.pps_id = product_purchase_summary.ppsid
                                                    AND product_purchase_summary.cfs_user_idUser = cfs_user.idUser
                                                    AND in_onsid = ? AND in_ons_type = ? ORDER BY in_input_date DESC");

$sql_select_category = $conn->prepare("SELECT DISTINCT pro_catagory, pro_cat_code FROM product_catagory ORDER BY pro_catagory");

function get_catagory() {
    echo "<option value=0> -সিলেক্ট করুন- </option>";
    $sql_select_category->execute();
    $arr_category = $sql_select_category->fetchAll();
    foreach ($arr_category as $catrow) {
        echo "<option value=" . $catrow['pro_cat_code'] . ">" . $catrow['pro_catagory'] . "</option>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>ক্রয়কৃত পণ্যের তালিকা</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
<script type="text/javascript">
    function ShowTime()
    {
        var time=new Date()
        var h=time.getHours()
        var m=time.getMinutes()
        var s=time.getSeconds()

        m=checkTime(m)
        s=checkTime(s)
        document.getElementById('txt').value=h+" : "+m+" : "+s
        t=setTimeout('ShowTime()',1000)
        if(document.getElementById('pname').value !="")
        { document.getElementById("QTY").disabled = false;}
        else {document.getElementById("QTY").disabled = true;}

        if(document.getElementById('tretail').value !="")
        { document.getElementById("cash").disabled = false;}
        else {document.getElementById("cash").disabled = true;}

        a=Number(document.abc.QTY.value);
        if (a!=0) {document.getElementById("addtoCart").disabled = false;}
        else {document.getElementById("addtoCart").disabled = true;}
        payable = Number(document.getElementById('gtotal').value);
        cash = Number(document.getElementById('cash').value);
        if(cash<payable)
        {document.getElementById("print").disabled = true;}
        else {document.getElementById("print").disabled =false ;}

    }
    function checkTime(i)
    {
        if (i<10)
        {
            i="0" + i
        }
        return i
    }
</script>
</head>

    <body onLoad="ShowTime()">
        <div id="maindiv">
            <div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
            <div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
                <div style="width: 40%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
                <div style="width: 60%;height: 100%;float: left;font-family: SolaimanLipi !important;text-align: left;font-size: 36px;"><?php echo $storeName; ?></div></br>
            </div>

            <fieldset   style="border-width: 3px;margin:0 20px 50px 20px;font-family: SolaimanLipi !important;">
                <legend style="color: brown;">ক্রয়কৃত পণ্যের তালিকা</legend>
                <div id="resultTable">
                    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;">
                        <tr>
                            <td width="10%" style="color: blue; font-size: 25px"><div align="center"><strong>তারিখ</strong></div></td>
                            <td width="12%"style="color: blue; font-size: 25px"><div align="center"><strong>চালান নং</strong></div></td>
                            <td width="20%" style="color: blue; font-size: 25px"><div align="center"><strong>প্রোডাক্টের কোড</strong></div></td>
                            <td width="25%" style="color: blue; font-size: 25px"><div align="center"><strong>প্রোডাক্টের নাম</strong></div></td>
                            <td width="8%" style="color: blue; font-size: 25px"><div align="center"><strong>পরিমাণ</strong></div></td>
                            <td width="15%" style="color: blue; font-size: 25px"><div align="center"><strong>ক্রয়মূল্য (টাকা)</strong></div></td>
                            <td width="10%" style="color: blue; font-size: 25px"><div align="center"><strong>এন্ট্রিকারী</strong></div></td>
                        </tr>
                        <?php
                           $sql_select_purchase_list->execute(array($storeID, $scatagory));
                           $arr_purchase = $sql_select_purchase_list->fetchAll();
                           foreach ($arr_purchase as $row) {
                            $db_date = english2bangla(date('d-m-Y', strtotime($row["in_input_date"])));
                            $db_chalan_no = english2bangla($row["chalan_no"]);
                            $db_procode = $row["pro_code"];
                            $db_pro_name = $row["pro_productname"];
                            $db_how_many =  english2bangla($row['in_howmany']);
                            $db_buying_price = english2bangla($row['in_buying_price']);
                            $db_username = $row['account_name'];
                            echo '<tr>';
                            echo '<td><div align="center">' . $db_date . '</div></td>';
                            echo '<td><div align="center">' . $db_chalan_no . '</div></td>';
                            echo '<td>' . $db_procode . '</div></td>';
                            echo '<td>' . $db_pro_name . '</div></td>';
                            echo '<td><div align="center">' . $db_how_many . '</div></td>';
                            echo '<td><div align="center">' . $db_buying_price . '</div></td>';
                            echo '<td><div align="center">' . $db_username . '</div></td>';
                            echo '</tr>';
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