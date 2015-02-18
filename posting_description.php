<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once './includes/selectQueryPDO.php';
$session_user_id = $_SESSION['userIDUser'];
$sel_emp = $conn->prepare("SELECT idEmployee,emp_ons_id FROM employee WHERE cfs_user_idUser=? ");
$sel_emp->execute(array($session_user_id));
$arr_cfs = $sel_emp->fetchAll();
foreach ($arr_cfs as $value) {
    $empID = $value['idEmployee'];
    $empOnSID = $value['emp_ons_id'];
}
$sel_posting = $conn->prepare("SELECT * FROM employee_posting, post_in_ons, post WHERE post_in_ons_idpostinons= idpostinons
                                                    AND Post_idPost= idPost AND Employee_idEmployee= ? ORDER BY posting_date DESC");
?>
<title>পোস্টিং ডেসক্রিপশন</title>
<style type="text/css"> @import "css/bush.css";</style>
<div class="main_text_box">
    <div style="padding-left: 110px;"><a href="personal_official_profile_employee.php"><b>ফিরে যান</b></a></div>
    <div>
        <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 80%;">          
            <tr><th colspan="6" style="text-align: center;font-size: 20px;">পোস্টিং ডেসক্রিপশন</th></tr>
            <?php
                $sel_posting->execute(array($empID));
                $arr_posting = $sel_posting->fetchAll();
                foreach ($arr_posting as $key=> $value) 
                { 
                    $sl = 1;
                    if(($value['ons_relation_idons_relation'] == $empOnSID) && $key == 0)
                    {
                        $db_current_post = $value['post_name'];
                        $db_current_posting_date = $value['posting_date'];
                        $db_officeType = $value['post_onstype'];
                        $db_officeID = $value['post_onsid'];
                        if( $db_officeType == 'office')
                        {
                            $sql_select_office->execute(array($db_officeID));
                            $offresult = $sql_select_office->fetchAll();
                            foreach ($offresult as $row) {
                                $offname = $row['office_name'];
                                $offnumber = $row['account_number'];
                                $offaddress= $row['office_details_address'];
                            }
                        }
                        else {
                            $sql_select_sales_store->execute(array($db_officeID));
                            $offresult = $sql_select_sales_store->fetchAll();
                            foreach ($offresult as $row) {
                                $offname = $row['salesStore_name'];
                                $offnumber = $row['account_number'];
                                $offaddress= $row['salesStore_details_address'];
                            }
                        } 
                        ?>
           <tr >
                <td style="text-align: right; width: 50%"><b>বর্তমান পোস্টঃ</b></td>
                <td><?php echo $db_current_post;?></td>
            </tr>
            <tr >
                <td style="text-align: right; width: 50%"><b>বর্তমান পোস্টিং অফিসঃ</b></td>
                <td><?php echo $offname;?></td>
            </tr>
            <tr >
                <td style="text-align: right; width: 50%"><b>অফিস নাম্বার / একাউন্টঃ</b></td>
                <td><?php echo $offnumber;?></td>
            </tr>
             <tr >
                <td style="text-align: right; width: 50%"><b>ঠিকানাঃ</b></td>
                <td><?php echo $offaddress;?></td>
            </tr>
             <tr >
                <td style="text-align: right; width: 50%"><b>পোস্টিং তারিখঃ</b></td>
                <td><?php echo english2bangla(date("d/m/Y",  strtotime($db_current_posting_date)));?></td>
            </tr> 
            <tr>
                <td colspan="2">
                    <fieldset style="border: #686c70 solid 3px;width: 80%;margin-left: 10%;">
                            <legend style="color: brown;">প্রিভিইয়াস পোস্টিং</legend>
                            <table style="width: 95%; margin: 0 auto" border="1" cellpadding="5px" cellspacing="0px">    
                            <tr  id="table_row_odd">
                                <td style="border: black 1px solid; text-align: center;font-weight: bold;">ক্রম</td>
                                <td style="border: black 1px solid; text-align: center;font-weight: bold;">পোস্ট</td>
                                <td style="border: black 1px solid; text-align: center;font-weight: bold;">অফিস নাম</td>
                                <td style="border: black 1px solid; text-align: center;font-weight: bold;" >নাম্বার / একাউন্ট</td>
                                <td style="border: black 1px solid; text-align: center;font-weight: bold;">পোস্টিং তারিখ</td>
                                <td style="border: black 1px solid; text-align: center;font-weight: bold;">পোস্টে অবস্থানকাল</td>
                            </tr>
                            <?php
                                }
                                else
                                {
                                    $db_post = $value['post_name'];
                                    $db_posting_date = $value['posting_date'];
                                    $db_previous_key = $key -1;
                                    $timestamp_start= strtotime( $arr_posting[$key]['posting_date']);
                                    $timestamp_end = strtotime($arr_posting[$db_previous_key]['posting_date']);
                                    $difference = abs($timestamp_end - $timestamp_start); 
                                    $postyears = english2bangla(floor($difference / (365 * 60 * 60 * 24)));
                                    $postmonths2 = english2bangla(floor(($difference - ($postyears * 365 * 60 * 60 * 24)) / ((365 * 60 * 60 * 24) / 12)));
                                    $postdays = english2bangla(floor(($difference - ($postyears * 365 * 60 * 60 * 24) -( $postmonths2 * 30 * 60 * 60 * 24))/ (60 * 60 * 24)));
                                    $db_officeType = $value['post_onstype'];
                                    $db_officeID = $value['post_onsid'];
                                    if( $db_officeType == 'office')
                                    {
                                        $sql_select_office->execute(array($db_officeID));
                                        $offresult = $sql_select_office->fetchAll();
                                        foreach ($offresult as $row) {
                                            $offname = $row['office_name'];
                                            $offnumber = $row['account_number'];
                                            $offaddress= $row['office_details_address'];
                                        }
                                    }
                                    else {
                                        $sql_select_sales_store->execute(array($db_officeID));
                                        $offresult = $sql_select_sales_store->fetchAll();
                                        foreach ($offresult as $row) {
                                            $offname = $row['salesStore_name'];
                                            $offnumber = $row['account_number'];
                                            $offaddress= $row['salesStore_details_address'];
                                        }
                                    }
                              ?>
                             <tr>
                                 <td style="border: black 1px solid; text-align: center"><?php echo english2bangla($sl);?></td>
                                <td style="border: black 1px solid; text-align: center"><?php echo $db_post;?></td>
                                <td style="border: black 1px solid; text-align: center"><?php echo $offname;?></td>
                                <td style="border: black 1px solid; text-align: center"><?php echo $offnumber;?></td>
                                <td style="border: black 1px solid; text-align: center"><?php echo english2bangla(date("d/m/Y",  strtotime($db_posting_date)));?></td>
                                <td style="border: black 1px solid; text-align: center"><?php echo $postyears ."বছর,". $postmonths2. "মাস,". $postdays ."দিন";?></td>
                            </tr>
                            <?php
                                     }
                                     $sl++;
                                 }
                             ?>
                        </table>
                        </fieldset>
                </td>
            </tr>
        </table>
    </div>           
</div>
<?php
include_once 'includes/footer.php';
?>
