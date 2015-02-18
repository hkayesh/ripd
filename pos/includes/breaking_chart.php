<?php
error_reporting(0);
include 'ConnectDB.inc';
include_once 'MiscFunctions.php';
$office_id = $_SESSION['loggedInOfficeID'];
$office_type = $_SESSION['loggedInOfficeType'];
//**************************** package breaking***************************
if ($_GET['type'] == 'package_breaking') {
    echo " <table width='100%' border='1' cellspacing='0' cellpadding='0' style='border-color:#000000; border-width:thin; font-size:18px;'>
      <tr>
          <td width='8%' style='color: blue; font-size: 20px'><div align='center'><strong>তারিখ</strong></div></td>
        <td width='23%' style='color: blue; font-size: 20px'><div align='center'><strong>প্যাকেজ কোড</strong></div></td>
        <td width='30%' style='color: blue; font-size: 20px'><div align='center'><strong>প্যাকেজের নাম</strong></div></td>
        <td width='11%' style='color: blue; font-size: 20px'><div align='center'><strong>পরিমাণ</strong></div></td>
        <td width='6%' style='color: blue; font-size: 20px'><div align='center'><strong>ব্রেকার</strong></div></td>
      </tr>";
    $result = mysql_query("SELECT pckg_quantity, pckg_name, pckg_code, account_name, making_date
                                        FROM package_info, package_inventory, cfs_user
                                        WHERE pckg_infoid = idpckginfo
                                        AND pckg_type =  'breaking'
                                        AND package_info.pckg_makerid = idUser
                                        AND ons_id = $office_id
                                        AND ons_type = '$office_type'
                                        ORDER BY making_date DESC ");
    while ($row = mysql_fetch_assoc($result)) {
        $db_making_date = $row['making_date'];
        $db_making_date = english2bangla(date("d/m/Y", strtotime($db_making_date)));
        $db_pckg_quantity = english2bangla($row["pckg_quantity"]);
        $db_pckg_name = $row["pckg_name"];
        $db_pckg_code = $row["pckg_code"];
        $db_account_name = $row['account_name'];

        echo '<tr>';
        echo '<td><div align="center">' . $db_making_date . '</div></td>';
        echo '<td><div align="center">' . $db_pckg_code . '</div></td>';
        echo '<td><div align="center">' . $db_pckg_name . '</div></td>';
        echo '<td><div align="center">' . $db_pckg_quantity . '</div></td>';
        echo '<td><div align="center">' . $db_account_name . '</div></td>';

        echo '</tr>';
    }

    echo "</table>";
}
// ---------------------------- product breaking-----------------------------------------------------------
elseif ($_GET['type'] == 'pro_breaking') {
    echo " <table width='100%' border='1' cellspacing='0' cellpadding='0' style='border-color:#000000; border-width:thin; font-size:18px;'>
       <tr>
          <td width='10%' style='color: blue; font-size: 20px'><div align='center'><strong></strong></div></td>
        <td width='40%' colspan='3' style='color: blue; font-size: 20px'><div align='center'><strong>ব্রেকিং প্রোডাক্ট</strong></div></td>
        <td width='40%' colspan='3' style='color: blue; font-size: 20px'><div align='center'><strong>রুপান্তরিত প্রোডাক্ট</strong></div></td>
        <td width='10%' style='color: blue; font-size: 20px'><div align='center'><strong></strong></div></td>
      </tr>
      <tr>
          <td width='10%' style='color: blue; font-size: 20px'><div align='center'><strong>তারিখ</strong></div></td>
        <td style='color: blue; font-size: 20px'><div align='center'><strong>কোড</strong></div></td>
        <td style='color: blue; font-size: 20px'><div align='center'><strong>নাম</strong></div></td>
        <td style='color: blue; font-size: 20px'><div align='center'><strong>পরিমাণ</strong></div></td>
        <td style='color: blue; font-size: 20px'><div align='center'><strong>কোড</strong></div></td>
        <td style='color: blue; font-size: 20px'><div align='center'><strong>নাম</strong></div></td>
        <td style='color: blue; font-size: 20px'><div align='center'><strong>পরিমান</strong></div></td>
        <td width='10%' style='color: blue; font-size: 20px'><div align='center'><strong>ব্রেকার</strong></div></td>
      </tr>";
    $result = mysql_query("SELECT breaking_date, breaking_pro_id, breaking_qty, converted_pro_id, converted_qty, account_name
                                FROM product_breaking, cfs_user
                                WHERE cfs_user_id = idUser
                                AND ons_id = $office_id
                                AND ons_type = '$office_type'
                                ORDER BY breaking_date DESC ");
    while ($row = mysql_fetch_assoc($result)) {
        $db_breaking_date = $row['breaking_date'];
        $db_breaking_date = english2bangla(date("d/m/Y", strtotime($db_breaking_date)));
        $db_breaking_qty = english2bangla($row["breaking_qty"]);
        $db_converted_qty = english2bangla($row["converted_qty"]);
        $db_breaking_pro_id = $row['breaking_pro_id']; 
        $prdt = mysql_query("SELECT pro_code, pro_productname
                                FROM product_chart
                                WHERE idproductchart = $db_breaking_pro_id");
        while($r = mysql_fetch_assoc($prdt)){
            $db_pro_code = $r['pro_code'];
            $db_pro_productname = $r['pro_productname'];
        }
        $db_converted_pro_id = $row['converted_pro_id'];
        $prdt = mysql_query("SELECT pro_code, pro_productname
                                FROM product_chart
                                WHERE idproductchart = $db_converted_pro_id");
        while($r = mysql_fetch_assoc($prdt)){
            $db_cnvt_code = $r['pro_code'];
            $db_cnvt_productname = $r['pro_productname'];
        }
        $db_account_name = $row['account_name'];

        echo '<tr>';
        echo '<td><div align="center">' . $db_breaking_date . '</div></td>';
        echo '<td>' . $db_pro_code . '</div></td>';
        echo '<td><div align="center">' . $db_pro_productname . '</div></td>';
        echo '<td><div align="center">' . $db_breaking_qty . '</div></td>';
        echo '<td>' . $db_cnvt_code . '</div></td>';
        echo '<td><div align="center">' . $db_cnvt_productname . '</div></td>';
        echo '<td><div align="center">' . $db_converted_qty . '</div></td>';
        echo '<td><div align="center">' . $db_account_name . '</div></td>';

        echo '</tr>';
    }
    echo "</table>";
}
?>