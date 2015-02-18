<?php
error_reporting(0);
include_once 'selectQueryPDO.php';
include_once 'ConnectDB.inc';
include_once 'MiscFunctions.php';
$user_own_id = $_SESSION['userIDUser'];
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css"> @import "../css/bush.css";</style>
    </head>
    <body>
            <table  class="formstyle" style="margin: 5px 10px 15px 10px; width: 100%; font-family: SolaimanLipi !important; font-size: 13px;">          
                <tr><th colspan="7" style="text-align: center; font-size: 14px;">প্রতি স্টেপে টোটাল একাউন্টধারীর সংখ্যা</th></tr>
                    <tr>
                        <td style="width: 14%"></td>
                        <?php
                                $sql_select_accountType->execute();
                                $arr_account_type_list = $sql_select_accountType->fetchAll();
                                foreach($arr_account_type_list as $aactl)
                                    {
                                    $accountType_name = $aactl['account_name'];
                                    echo "<td><b>$accountType_name</b></td>";
                                    }
                        ?>
                        <td><b>সর্বমোট</b></td>
                    </tr>
                    <?php
                                $total_account = 0;
                                for($a=1; $a<=5; $a++)
                                        {
                                        if($a==1) 
                                                {
                                                $user_own_id = $user_own_id;
                                                }
                                        else
                                                {
                                                $referrer_array = array();
                                                $sql_reffer_list = mysql_query("SELECT cfs_user_idUser FROM cfs_user, customer_account WHERE idUser=cfs_user_idUser AND referer_id IN ($user_own_id)");
                                                while($arr_referred_id = mysql_fetch_array($sql_reffer_list))
                                                        {
                                                        $referrer_array[] = $arr_referred_id['cfs_user_idUser'];
                                                        }  
                                                $user_own_id = implode(", ", $referrer_array);
                                                } 
                                        $sql_show_innerRow_flag = mysql_query("SELECT COUNT(*) as ct FROM customer_account where referer_id IN ($user_own_id)");
                                        $arrCount_inner = mysql_fetch_array($sql_show_innerRow_flag);
                                        $rowCount_inner = $arrCount_inner['ct'];
                                        if($rowCount_inner > 0)
                                                {
                                                $step = english2bangla($a);
                                                $sub_total = 0;
                                                $sql_countAccount = mysql_query("SELECT idAccount_type, count FROM account_type as at LEFT JOIN (SELECT Account_type_idAccount_type, COUNT(*) as count FROM cfs_user, customer_account WHERE idUser=cfs_user_idUser AND referer_id IN ($user_own_id) 
                                                                                                                        GROUP BY Account_type_idAccount_type) as temp ON at.idAccount_type = temp.Account_type_idAccount_type");
                                                echo "<tr>";
                                                echo "<td><b>স্টেপ - $step</b></td>";
                                                while($arr_account_count_list = mysql_fetch_array($sql_countAccount))
                                                        {
                                                        $count_number = $arr_account_count_list['count'];
                                                        if($count_number == NULL) $count_number = 0;
                                                        $sub_total += $count_number;
                                                        $count_number = english2bangla($count_number);
                                                        echo "<td style='text-align: center;'>$count_number টি</td>";
                                                        }
                                                $total_account = $total_account + $sub_total;
                                                $sub_total = english2bangla($sub_total);
                                                echo "<td style='text-align: center;'><b>$sub_total টি</b></td>";
                                                echo "</tr>";
                                                }
                                        else break;
                                        }
                                $total_account = english2bangla($total_account);
                                echo "<tr><td colspan='7'><hr></td></tr>";
                                echo "<tr><td colspan='6' style='text-align: right;'><b>সর্বমোট একাউন্ট :</b></td><td><b>$total_account টি</b></td></tr>";
                    ?>
            </table>
    </body>
</html>