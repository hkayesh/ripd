<?php
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include_once 'includes/selectQueryPDO.php';
include 'includes/header.php';
$user_own_id = $_SESSION['userIDUser'];
?>
<title>জেনোলজি ট্রি</title>
<style type="text/css"> @import "css/bush.css";</style>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
function show_stepWise_account()
        {
        TINY.box.show({iframe:'includes/show_stepWise_account.php',width:800,height:300,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'});
        }
</script>

<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="tree_view.php"><b>ফিরে যান</b></a></div>
        <div>
                <table  class="formstyle" style="font-family: SolaimanLipi !important;">          
                    <tr><th style="text-align: center;">জেনোলজি ট্রি</th></tr>
                    <tr><td><a onclick='show_stepWise_account()' style='cursor:pointer; color: blue;'><b>প্রতি স্টেপে টোটাল একাউন্টধারীর সংখ্যা</b></a></td></tr>
                    <tr>
                        <td>
                            <table border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                                <thead style="background-color: #ffcccc">
                                    <tr align="left" id="table_row_odd">
                                        <th style="border: black 1px solid;">ক্রম</th>
                                        <th style="border: black 1px solid;" >নাম</th>
                                        <th style="border: black 1px solid;">অ্যাকাউন্ট নং</th>
                                        <th style="border: black 1px solid;">পিন নং</th>
                                        <th style="border: black 1px solid;">প্যাকেজের নাম</th>
                                        <th style="border: black 1px solid;">অ্যাকাউন্ট করার তারিখ</th>
                                        <th style="border: black 1px solid;">রেফারারের নাম</th>
                                        <th style="border: black 1px solid;">স্টেপ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                        $db_slNo = 0;
                                        for($a=1; $a<=5; $a++)
                                                {
                                                $arr_referrer = array();
                                                $sql_genologyTable = "SELECT cu.account_name, cu.account_number, ct.opening_pin_no, cu.account_open_date, at.account_name as act, ct.referer_id as rfid, ct.cfs_user_idUser
                                                                                                FROM account_type as at, customer_account as ct, cfs_user as cu
                                                                                                    WHERE idAccount_type=Account_type_idAccount_type AND idUser=cfs_user_idUser AND referer_id IN ($user_own_id)";
                                                $row_genologyTree = mysql_query($sql_genologyTable);
                                                $num_rows = mysql_num_rows($row_genologyTree);
                                                while ($row_user_info = mysql_fetch_array($row_genologyTree)) 
                                                        {
                                                        $db_slNo = $db_slNo + 1;
                                                        $show_slno = english2bangla($db_slNo);
                                                        $db_referid = $row_user_info['rfid'];
                                                        if($db_referid != 0)
                                                                {
                                                                $sql_select_cfs_user_all->execute(array($db_referid));
                                                                $arr_reffer_name = $sql_select_cfs_user_all->fetchAll();
                                                                foreach($arr_reffer_name as $arn) 
                                                                        {
                                                                        $db_referer_name = $arn['account_name'];
                                                                        }
                                                                $db_cfs_user = $row_user_info['cfs_user_idUser'];
                                                                $sql_select_cfs_user_all->execute(array($db_cfs_user));
                                                                $arr_cfsUser_name = $sql_select_cfs_user_all->fetchAll();
                                                                foreach($arr_cfsUser_name as $acn) 
                                                                        {
                                                                        $db_cfs_user_id = $acn['idUser'];
                                                                        $arr_referrer[] = $db_cfs_user_id;
                                                                        }
                                                                $db_cfs_acc_name = $row_user_info['account_name'];
                                                                $db_cfs_acc_no = $row_user_info['account_number'];
                                                                $db_pin_no = $row_user_info['opening_pin_no'];
                                                                $db_cfs_acc_open_date = $row_user_info['account_open_date'];
                                                                $db_package = $row_user_info['act'];
                                                                $show_date = date("d/m/Y", strtotime($db_cfs_acc_open_date));
                                                                $show_date = english2bangla($show_date);
                                                                echo "<tr>";
                                                                echo "<td style='border: black 1px solid;'>$show_slno</td>";
                                                                echo "<td style='border: black 1px solid;'>$db_cfs_acc_name</td>";
                                                                echo "<td style='border: black 1px solid;'>$db_cfs_acc_no</td>";
                                                                echo "<td style='border: black 1px solid;'>$db_pin_no</td>";
                                                                echo "<td style='border: black 1px solid;'>$db_package</td>";
                                                                echo "<td style='border: black 1px solid;'>$show_date</td>"; 
                                                                echo "<td style='border: black 1px solid;'>$db_referer_name</td>";                                        
                                                                echo "<td style='border: black 1px solid;'>স্টেপ ".english2bangla($a)."</td>";                                        
                                                                echo "</tr>";
                                                                }
                                                        }
                                                        $user_own_id = implode(", ", $arr_referrer);
                                                }
                                    ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>   
                </table>
        </div>           
    </div>
<?php
        include 'includes/footer.php';
?>