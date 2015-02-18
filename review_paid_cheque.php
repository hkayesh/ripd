<?php
include 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/selectQueryPDO.php';
?>
<style type="text/css"> @import "css/bush.css";</style>

    <div class="main_text_box">
        <div id="noprint" style="padding-left: 110px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="" name="cheque" action="">	
                <table  class="formstyle" style="width: 80%;font-family: SolaimanLipi !important; font-size: 14px;">          
                    <tr ><th colspan="4" style="text-align: center;font-size: 16px;">রিভিউ চেক</th></tr>
                    <tr>
                        <td colspan="2" style="text-align: right;width: 50%;">চেক নাম্বার</td>
                        <td colspan="2" style="text-align: left;width: 50%;"> : <input class="box" type="text" name='chequeNo' /> </td>
                    </tr>
                    <tr>
                        <td  colspan="4" style="text-align: center;" ></br><input class="btn" style =" font-size: 12px; " name='check' type="submit" value="যাচাই করুন" /></td>
                    </tr>
                    <?php if(isset($_POST['check'])) {
                        $p_chequeNo = $_POST['chequeNo'];
                        $sql_select_cheque_all->execute(array($p_chequeNo));
                        $cheque_all = $sql_select_cheque_all->fetchAll();
                        foreach ($cheque_all as $row){
                            $db_cheque_num = $row['cheque_num'];
                            $db_cheque_amount = $row['cheque_amount'];
                            $db_accNumber = $row['account_number'];
                            $db_acc_name = $row['account_name'];
                            $db_cheque_status = $row['cheque_status'];
                            $db_cheque_mak_datetime = $row['cheque_mak_datetime'];
                            $db_cheque_update_datetime = $row['cheque_update_datetime'];
                            $db_cheque_updated_userid = $row['cheque_updated_userid'];
                            $sql_select_cfs_user_all->execute(array($db_cheque_updated_userid));
                            $db_user = $sql_select_cfs_user_all->fetchAll();
                            foreach ($db_user as $r){
                                $db_account_name = $r['account_name'];
                            }
                            $db_chqupd_officeid = $row['chqupd_officeid'];
                            $sql_select_office->execute(array($db_chqupd_officeid));
                            $db_office = $sql_select_office->fetchAll();
                            foreach ($db_office as $r_office){
                                $db_office_name = $r_office['office_name'];
                            }
                            $count++;
                            $arr_sts = array("made" => "তৈরি হয়েছে", "postpond" => "স্থগিতকৃত", "paid" => "পরিশোধিত", "in_amount" => "জমাকৃত");
                            $show_sts = $arr_sts[$db_cheque_status];
                        }
                        if($count != 0){
                        ?>
                    <tr>
                        <td colspan="2" style="width: 50%; text-align: right"><b>চেক নাম্বার</b> </td>
                        <td colspan="2" style="width: 50%; text-align: left"> : <?php echo $db_cheque_num; ?></td>
                    </tr>
                    <tr>
                        <td style=" width: 25%; text-align: right"><b>চেক তৈরির দিন</b> </td>
                        <td style="width: 25%; text-align: left"> : <?php echo english2bangla(date("d.m.y", strtotime($db_cheque_mak_datetime))); ?></td>
                        <td style="width: 25%; text-align: right"><b>সময়</b></td>
                        <td style="width: 25%; text-align: left"> : <?php echo english2bangla(date('g:i a', strtotime($db_cheque_mak_datetime)))?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%; text-align: right"><b>একাউন্টধারীর নাম</b> </td>
                        <td colspan="2" style="width: 50%; text-align: left"> : <?php echo $db_acc_name; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%; text-align: right"><b>একাউন্ট নাম্বার</b></td>
                        <td colspan="2" style="width: 50%; text-align: left"> : <?php echo $db_accNumber; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%; text-align: right"><b>চেক এমাউন্ট</b></td>
                        <td colspan="2" style="width: 50%; text-align: left"> : <?php echo english2bangla($db_cheque_amount); ?> টাকা</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%; text-align: right"><b>চেক স্ট্যাটাস</b></td>
                        <td colspan="2" style="width: 50%; text-align: left"> : <?php echo $show_sts; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 30%; text-align: right"><b>টাকা উত্তোলন / স্থগিতের তারিখ</b></td>
                        <td style="width: 20%;text-align: left"> : <?php echo english2bangla(date("d.m.y", strtotime($db_cheque_update_datetime))); ?></td>
                         <td style="width: 30%;text-align: right"><b>সময়</b></td>
                        <td style="width: 20%;text-align: left"> : <?php echo english2bangla(date('g:i a', strtotime($db_cheque_update_datetime)))?></td>
                    </tr>
                    <tr>
                        <td style="width: 25%; text-align: right"><b>অফিসের নাম</b></td>
                        <td style="width: 25%; text-align: left"> : <?php echo $db_office_name; ?></td>
                         <td style="width: 25%; text-align: right"><b>কর্মচারীর নাম</b></td>
                        <td style="width: 25%; text-align: left"> : <?php echo $db_account_name; ?></td>
                    </tr>
                    <?php }}?>
                </table>
            </form>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>
