<?php
//include 'includes/session.inc';
include_once 'includes/header.php';
$userID = $_SESSION['userIDUser'];
$select_refered = $conn->prepare("SELECT * FROM replace_product_summary, sales_summary,cfs_user
                                                WHERE sal_invoiceno = reprosum_invoiceno AND sal_buyerid = ? AND replace_product_summary.cfs_userid = idUser
                                                AND (sal_buyer_type = 'customer' ||  sal_buyer_type = 'employee' ) ORDER BY reprosum_replace_date DESC");

?>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/print.css" type="text/css">
<link rel="stylesheet" href="css/tinybox.css" type="text/css">
<script type="text/javascript" src="javascripts/tinybox.js"></script>
<script type="text/javascript">
function details_show(id)
      { TINY.box.show({url:'pos/replace_details.php?rep_id='+id,width:900,height:400,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
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
                <tr><th style="text-align: center" colspan="2"><h1>পণ্য রিপ্লেসের স্টেটমেন্ট</h1></th></tr>
<!--                <tr id="noprint"><td style="text-align: right"><div style="width: 30px;height: 30px;background-image: url('images/print.gif');background-size: 100% 100%;cursor: pointer;" onclick="printthis()"></div></td></tr>-->
                <tr>
                    <td>
                        <fieldset style="border: 3px solid #686c70 ; width: 99%;font-family: SolaimanLipi !important;">
                            <legend style="color: brown;font-size: 14px;">পণ্য রিপ্লেসের স্টেটমেন্ট</legend>
                            <div id="resultTable">
                                <table style="width: 98%;margin: 0 auto;" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr id="table_row_odd">
                                            <td width="10%" style="border: solid black 1px;"><div align="center"><strong>তারিখ</strong></div></td>
                                            <td width="12%"  style="border: solid black 1px;"><div align="center"><strong>সময়</strong></div></td>
                                            <td width="25%"  style="border: solid black 1px;"><div align="center"><strong>রশিদ নং</strong></div></td>
                                            <td width="11%"  style="border: solid black 1px;"><div align="center"><strong>মূল্য(টাকা)</strong></div></td>
                                            <td width="11%"  style="border: solid black 1px;"><div align="center"><strong>রিপ্লেসকারী</strong></div></td>     
                                        </tr>
                                    </thead>
                                    <tbody style="background-color: #FCFEFE">
                                        <?php                                     
                                            $select_refered->execute(array($userID));
                                                $row1 = $select_refered->fetchAll();
                                                foreach ($row1 as $value) {
                                                $db_sal_salesdate = $value["reprosum_replace_date"];
                                                $db_sal_salestime = $value["reprosum_replace_time"];
                                                $db_sal_totalamount = $value["reprosum_total_amount"];
                                                $db_sal_invoiceno = $value["reprosum_invoiceno"];
                                                $db_salsumid = $value['idreproductsum'];
                                                $db_account_name = $value['account_name'];
                                                echo '<tr>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla(date("d/m/Y",  strtotime($db_sal_salesdate))) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="left">' . english2bangla(date('g:i a' , strtotime($db_sal_salestime))) . '</div></td>';
                                                echo "<td  style='border: solid black 1px;'><a onclick=details_show('$db_salsumid') style='color:green;cursor:pointer;'><u>$db_sal_invoiceno<u><a></td>";
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla($db_sal_totalamount) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . $db_account_name . '</div></td>';
                                                echo '</tr>';
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