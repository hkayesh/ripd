<?php
//include 'includes/session.inc';
include_once 'includes/header.php';
$userID = $_SESSION['userIDUser'];

$sql_runningpv = $conn->prepare("SELECT * FROM running_command ;");
$sql_runningpv->execute();
$pvrow = $sql_runningpv->fetchAll();
foreach ($pvrow as $value) {
    $current_pv = $value['pv_value'];
}

$select_refered = $conn->prepare("SELECT ss.sal_salesdate, ss.sal_salestime, ss.sal_totalamount,ss.sal_invoiceno, ss.sal_total_profit,idsalessummary,temp.refered,temp.package  
    FROM sales_summary AS ss
    LEFT JOIN 
        (SELECT pin.pin_state, pin.pin_usedby_cfsuserid, cfs.idUser, cust.cfs_user_idUser, cust.Account_type_idAccount_type, acc.idAccount_type, pin.sales_summery_idsalessummery, cfs.account_name AS refered, acc.account_name AS package 
        FROM pin_makingused AS pin, cfs_user AS cfs, customer_account AS cust, account_type AS acc
        WHERE pin.pin_state='newaccount' AND pin.pin_usedby_cfsuserid= cfs.idUser
         AND cfs.idUser = cust.cfs_user_idUser AND cust.Account_type_idAccount_type = acc.idAccount_type) AS temp
    ON ss.idsalessummary = temp.sales_summery_idsalessummery
    WHERE ss.sal_buyerid = ? ");

$select_refered_selected = $conn->prepare("SELECT ss.sal_salesdate, ss.sal_salestime, ss.sal_totalamount,ss.sal_invoiceno, ss.sal_total_profit,idsalessummary,temp.refered,temp.package  
    FROM sales_summary AS ss
    LEFT JOIN 
        (SELECT pin.pin_state, pin.pin_usedby_cfsuserid, cfs.idUser, cust.cfs_user_idUser, cust.Account_type_idAccount_type, acc.idAccount_type, pin.sales_summery_idsalessummery, cfs.account_name AS refered, acc.account_name AS package 
        FROM pin_makingused AS pin, cfs_user AS cfs, customer_account AS cust, account_type AS acc
        WHERE pin.pin_state='newaccount' AND pin.pin_usedby_cfsuserid= cfs.idUser
         AND cfs.idUser = cust.cfs_user_idUser AND cust.Account_type_idAccount_type = acc.idAccount_type) AS temp
    ON ss.idsalessummary = temp.sales_summery_idsalessummery
    WHERE ss.sal_buyerid = ? AND ss.sal_salesdate BETWEEN ? AND ? ORDER BY ss.sal_salesdate ");
?>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/print.css" type="text/css">
<link rel="stylesheet" href="css/tinybox.css" type="text/css">
<script type="text/javascript" src="javascripts/tinybox.js"></script>
<script type="text/javascript">
function details_show(id){
           TINY.box.show({url:'includes/personal_purchase_details.php?sum_id='+id,width:900,height:400,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'});           
}
function printthis()
{
    window.print();
}
</script>

<div class="main_text_box">
    <div id="noprint" style="padding-left: 112px;"><a href="personal_reporting.php"><b>ফিরে যান</b></a></div>
    <div>
        <div id="onprint" style="display: none;text-align: center;"><font style="font-size: 16px;">রিপড ইউনিভার্সেল</font> <sub>লিমিটেড</sub></br><?php echo english2bangla(date("d-m-Y"))?></div>
            <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 80%;">
                <tr><th style="text-align: center" colspan="2"><h1>ব্যক্তিগত ক্রয় স্টেটমেন্ট</h1></th></tr>
                <tr>
                    <td id="noprint">
                        <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">সার্চ</legend>
                            <form method="POST" action="">	
                            <table>
                                <tr>
                                    <td style="padding-left: 0px; text-align: left;" >শুরুর তারিখঃ</td>
                                    <td style="text-align: left"><input class="box" type="date" name="startDate" /></td>	 
                                    <td style="padding-left: 0px; text-align: left;"  >শেষের তারিখঃ</td>
                                    <td style=" text-align: left"><input class="box" type="date" name="lastDate" /></td>
                                    <td style="padding-left: 50px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সার্চ" /></td>
                                </tr>
                            </table>
                           </form>
                        </fieldset>
                    </td> 
                </tr>
                <tr id="noprint"><td style="text-align: right"><div style="width: 30px;height: 30px;background-image: url('images/print.gif');background-size: 100% 100%;cursor: pointer;" onclick="printthis()"></div></td></tr>
                <tr>
                    <td>
                        <fieldset style="border: 3px solid #686c70 ; width: 99%;font-family: SolaimanLipi !important;">
                            <legend style="color: brown;font-size: 14px;">ব্যক্তিগত ক্রয় স্টেটমেন্ট</legend>
                            <div id="resultTable">
                                <table style="width: 98%;margin: 0 auto;" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr id="table_row_odd">
                                            <td width="10%" style="border: solid black 1px;"><div align="center"><strong>তারিখ</strong></div></td>
                                            <td width="12%"  style="border: solid black 1px;"><div align="center"><strong>সময়</strong></div></td>
                                            <td width="25%"  style="border: solid black 1px;"><div align="center"><strong>রশিদ নং</strong></div></td>
                                            <td width="11%"  style="border: solid black 1px;"><div align="center"><strong>মূল্য(টাকা)</strong></div></td>
                                            <td width="12%" style="border: solid black 1px;"><div align="center"><strong>মোট পিভি</strong></div></td>
                                            <td width="20%" style="border: solid black 1px;"><div align="center"><strong>রেফার্ড</strong></div></td>
                                            <td width="18%" style="border: solid black 1px;"><div align="center"><strong>প্যাকেজ</strong></div></td>                                          
                                        </tr>
                                    </thead>
                                    <tbody style="background-color: #FCFEFE">
                                        <?php
                                        if(isset($_POST['submit']))
                                        {
                                            $p_startdate = $_POST['startDate'];
                                            $p_lastDate = $_POST['lastDate'];
                                            $select_refered_selected->execute(array($userID,$p_startdate,$p_lastDate));
                                                $row1 = $select_refered_selected->fetchAll();
                                                foreach ($row1 as $value) {
                                                $db_sal_salesdate = $value["sal_salesdate"];
                                                $db_sal_salestime = $value["sal_salestime"];
                                                $db_sal_totalamount = $value["sal_totalamount"];
                                                $db_sal_invoiceno = $value["sal_invoiceno"];
                                                $db_sal_totalpv = $value['sal_total_profit'] * $current_pv;
                                                $db_salsumid = $value['idsalessummary'];
                                                $db_refered = $value['refered'];
                                                $db_package = $value['package'];
                                                echo '<tr>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla(date("d/m/Y",  strtotime($db_sal_salesdate))) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="left">' . english2bangla(date('g:i a' , strtotime($db_sal_salestime))) . '</div></td>';
                                                echo "<td  style='border: solid black 1px;'><a onclick=details_show('$db_salsumid') style='color:green;cursor:pointer;'><u>$db_sal_invoiceno<u><a></td>";
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla($db_sal_totalamount) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla($db_sal_totalpv) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">'.$db_refered.'</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">'.$db_package.'</div></td>';                                                
                                                echo '</tr>';
                                            }
                                        }
                                        else
                                        {                                         
                                            $select_refered->execute(array($userID));
                                                $row1 = $select_refered->fetchAll();
                                                foreach ($row1 as $value) {
                                                $db_sal_salesdate = $value["sal_salesdate"];
                                                $db_sal_salestime = $value["sal_salestime"];
                                                $db_sal_totalamount = $value["sal_totalamount"];
                                                $db_sal_invoiceno = $value["sal_invoiceno"];
                                                $db_sal_totalpv = $value['sal_total_profit'] * $current_pv;
                                                $db_salsumid = $value['idsalessummary'];
                                                $db_refered = $value['refered'];
                                                $db_package = $value['package'];
                                                echo '<tr>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla(date("d/m/Y",  strtotime($db_sal_salesdate))) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="left">' . english2bangla(date('g:i a' , strtotime($db_sal_salestime))) . '</div></td>';
                                                echo "<td  style='border: solid black 1px;'><a onclick=details_show('$db_salsumid') style='color:green;cursor:pointer;'><u>$db_sal_invoiceno<u><a></td>";
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla($db_sal_totalamount) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla($db_sal_totalpv) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">'.$db_refered.'</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">'.$db_package.'</div></td>';                                              
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                    </td>
                </tr>
            </table>
    </div>
</div>   
<?php include_once 'includes/footer.php'; ?>