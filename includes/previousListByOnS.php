<?php
include_once './connectionPDO.php';
include_once './MiscFunctions.php';
$g_str =$_GET['typeNid'];
$arr_str = explode(",", $g_str);
$type = $arr_str[0];
$id = $arr_str[1];
$slNo = 1;

$result = $conn->prepare("SELECT * FROM inventory WHERE ins_ons_id = ? AND ins_how_many = 0
                                      AND ins_ons_type=? AND ins_product_type='general' ORDER BY ins_productname ");
$result->execute(array($id,$type));
$row2 = $result->fetchAll();
foreach($row2 as $row)
    {
        $db_proname=$row["ins_productname"];
        $db_procode=$row["ins_product_code"];
        $db_lastsell = $row['ins_lastupdate'];
        $db_inventID = $row['idinventory'];
        $sel_selling = $conn->prepare("SELECT sal_salesdate FROM sales,sales_summary WHERE sal_store_type=? AND sal_storeid=? 
                                            AND idsalessummary=sales_summery_idsalessummery AND inventory_idinventory= ? ORDER BY sal_salesdate ASC");
        $sel_selling->execute(array($type,$id,$db_inventID));
        $row1 = $sel_selling->fetchAll();
        foreach ($row1 as $key=>$row_sell) {
            if($key == 0)
            {
                $db_sell_start = $row_sell['sal_salesdate'];
            }
        }
        echo '<tr>';
        echo '<td  style="border: solid black 1px;">' .  english2bangla($slNo). '</td>';
        echo '<td  style="border: solid black 1px;">' . $db_proname . '</td>';
        echo '<td  style="border: solid black 1px;">' . $db_procode . '</td>';
        echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla(date("d/m/Y",  strtotime($db_sell_start))) . '</div></td>';
        echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla(date("d/m/Y",  strtotime($db_lastsell))) . '</div></td>';
        echo "<td style='border: solid black 1px;'><a onclick=previousProductDetails('$db_inventID','$g_str') style='cursor:pointer;color:blue;'>বিস্তারিত</a></td>";
        echo '</tr>';
          $slNo++;
    }
?>