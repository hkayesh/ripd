<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$storeName = $_SESSION['loggedInOfficeName'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory = $_SESSION['loggedInOfficeType'];

$sql_select_own_buy = $conn->prepare("SELECT * FROM sal_for_own_store, inventory, cfs_user WHERE fk_inventory_id = idinventory
                                                                            AND buyerid = idUser AND ons_id = ? AND ons_type = ? ORDER BY buying_date DESC");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>নিজস্ব ক্রয়ের তালিকা</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
</head>

<body>
    <div id="maindiv">
        <div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
        <div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
            <div style="width: 40%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
            <div style="width: 60%;height: 100%;float: left;font-family: SolaimanLipi !important;text-align: left;font-size: 36px;"><?php echo $storeName; ?></div></br>
        </div>

        <fieldset   style="border-width: 3px;margin:0 20px 50px 20px;font-family: SolaimanLipi !important;">
            <legend style="color: brown;">নিজস্ব ক্রয়ের তালিকা</legend>
            <div id="resultTable">
                <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;">
                    <tr>
                        <td width="10%" style="color: blue; font-size: 25px"><div align="center"><strong>তারিখ</strong></div></td>
                        <td width="15%" style="color: blue; font-size: 25px"><div align="center"><strong>প্রোডাক্টের কোড</strong></div></td>
                        <td width="25%" style="color: blue; font-size: 25px"><div align="center"><strong>প্রোডাক্টের নাম</strong></div></td>
                        <td width="8%" style="color: blue; font-size: 25px"><div align="center"><strong>একক ক্রয়মূল্য</strong></div></td>
                        <td width="15%" style="color: blue; font-size: 25px"><div align="center"><strong>ক্রয়কৃত পরিমান</strong></div></td>   
                        <td width="8%" style="color: blue; font-size: 25px"><div align="center"><strong>মোট ক্রয়মূল্য</strong></div></td><td width="10%" style="color: blue; font-size: 25px"><div align="center"><strong>ক্রয়কারী</strong></div></td>
                    </tr>
                    <?php
                       $sql_select_own_buy->execute(array($storeID, $scatagory));
                       $arr_discount = $sql_select_own_buy->fetchAll();
                       foreach ($arr_discount as $row) {
                            $db_date = english2bangla(date('d-m-Y', strtotime($row["buying_date"])));
                            $db_procode = $row["ins_product_code"];
                            $db_pro_name = $row["ins_productname"];
                            $db_how_many =  english2bangla($row['qty']);
                            $db_buying_price_org = english2bangla($row['ins_buying_price']);
                            $db_buying_price_total = english2bangla($row['total_buying_price']);
                            $db_username = $row['account_name'];
                            echo '<tr>';
                            echo '<td><div align="center">' . $db_date . '</div></td>';
                            echo '<td>' . $db_procode . '</td>';
                            echo '<td>' . $db_pro_name . '</td>';
                            echo '<td><div align="center">' . $db_buying_price_org . '</div></td>';
                            echo '<td><div align="center">' . $db_how_many . '</div></td>';
                            echo '<td><div align="center">' . $db_buying_price_total . '</div></td>';                      
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