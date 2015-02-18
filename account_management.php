<?php
//echo "test";
error_reporting(0);
session_start();
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/MiscFunctions.php';
$arrayUserType = array('employee' => 'কর্মচারী', 'programmer' => 'প্রোগ্রামার', 'presenter' => 'প্রেজেন্টার', 'trainer' => 'trainer');

$session_user_id = $_SESSION['userIDUser'];
$session_account_name = $_SESSION['acc_holder_name'];
$session_user_type = $_SESSION['userType'];
$sql_select_cfs_user_all->execute(array($session_user_id));
$arr_cfs_user = $sql_select_cfs_user_all->fetchAll();
foreach ($arr_cfs_user as $acu) {
    $aab_account_number = $acu['account_number'];
    $aab_open_date = english2bangla(date("d/m/Y",strtotime($acu['account_open_date'])));
    $aab_mobile = english2bangla($acu['mobile']);
    $aab_email = $acu['email'];
    $aab_user_type = $acu['user_type'];
    $cfs_user_id = $acu['idUser'];
}
if ($aab_user_type == 'customer') // for customer *********************************************
    {
        $sql_select_cust_basic->execute(array($cfs_user_id));
        $arr_cust_basic = $sql_select_cust_basic->fetchAll();
        foreach ($arr_cust_basic as $aab) {
            $aab_designation_name = $aab['designation_name'];
            $aab_designation_star = english2bangla($aab['designation_star']);
            $aab_picture = $aab['scanDoc_picture'];
            $aab_referrer_id = $aab['referer_id'];
        }
        $sql_select_cfs_user_all->execute(array($aab_referrer_id));
        $arr_referrer = $sql_select_cfs_user_all->fetchAll();
        foreach ($arr_referrer as $ar)
        {
            $ar_referrer = $ar['account_name'];
        }
        $sel_acc_balance = $conn->prepare("SELECT total_balanace FROM acc_user_balance WHERE cfs_user_iduser = ?");
        $sel_acc_balance->execute(array($session_user_id));
        $arr_balance= $sel_acc_balance->fetchAll();
        foreach ($arr_balance as $value) {
            $db_cust_balance = $value['total_balanace'];
        }
    } 
elseif ($aab_user_type == 'owner') // for proprietor *********************************
        {
            $sql_select_propritor_basic->execute(array($cfs_user_id));
            $arr_proprietor_basic = $sql_select_propritor_basic->fetchAll();
            foreach ($arr_proprietor_basic as $aab) {
                $aab_picture = $aab['prop_scanDoc_picture'];
            }
             $offid =  $_SESSION['loggedInOfficeID'];
            $sql_select_office->execute(array($offid));
            $offresult = $sql_select_office->fetchAll();
            foreach ($offresult as $value) {
                $offnumber = $value['office_number'];
                $offaddress= $value['office_details_address'];
            }
            $db_joiningDate = $aab_open_date;
            $db_empposition = "প্রোপ্রাইটার";
        } 
else  // for others ******************************************
    {
        $sql_select_employee_basic->execute(array($cfs_user_id));
        $arr_employee_basic = $sql_select_employee_basic->fetchAll();
        foreach ($arr_employee_basic as $aab) {
            $aab_picture = $aab['emplo_scanDoc_picture'];
             $db_paygrdid = $aab['pay_grade_id'];
             $db_joiningDate =  english2bangla(date("d/m/Y",  strtotime($aab['joining_date'])));
        }
        if( $_SESSION['loggedInOfficeType'] == 'office')
        {
            $offid =  $_SESSION['loggedInOfficeID'];
            $sql_select_office->execute(array($offid));
            $offresult = $sql_select_office->fetchAll();
            foreach ($offresult as $value) {
                $offnumber = $value['office_number'];
                $offaddress= $value['office_details_address'];
            }
        }
        else {
            $storeid =  $_SESSION['loggedInOfficeID'];
            $sql_select_sales_store->execute(array($storeid));
            $offresult = $sql_select_sales_store->fetchAll();
            foreach ($offresult as $value) {
                $offnumber = $value['salesStore_number'];
                $offaddress= $value['salesStore_details_address'];
            }
        }
        $sql_select_emp_post->execute(array($cfs_user_id));
        $sql_postrow = $sql_select_emp_post->fetchAll();
        foreach ($sql_postrow as $value) {
            $db_empposition = $value['post_name'];
            $db_postingdate = $value['posting_date'];
        }
       $sql_select_pay_grade->execute(array($db_paygrdid));
        $emgrade = $sql_select_pay_grade->fetchAll();
        foreach ($emgrade as $value) {
            $db_paygrd_name = $value['grade_name'];
        }
        $sql_select_first_grade->execute(array($cfs_user_id));
        $firstgrade = $sql_select_first_grade->fetchAll();
        foreach ($firstgrade as $value) {
            $db_firstgrade = $value['grade_name'];
        }
}
if (!file_exists($aab_picture))
    $aab_picture = "pic/default_profile.jpg";
?>

<title>প্রোফাইল ম্যানেজমেন্ট</title>
<style type="text/css">@import "css/domtab.css";</style>

<div class="columnSubmodule">
    <table class="formstyle">    
        <tr>
            <th colspan="2" style="font-size: 15px;">একাউন্ট নম্বরঃ <?php echo $aab_account_number; ?></th>
        </tr>
        <tr>
            <?php
            if ($aab_user_type == "customer") {
                ?>
                <td>
                    <table>
                        <tr>
                            <td style='font-size: 20px; text-align:center;' colspan="2"><b>আপনার একাউন্টে স্বাগতম</b></td>
                        </tr>                            
                        <tr>
                            <td><b>রেফারার নামঃ </b></td>
                            <td><?php echo $ar_referrer; ?></td>
                        </tr>
                        <tr>
                            <td><b>একাউন্ট খোলার তারিখঃ </b></td>
                            <td><?php echo $aab_open_date; ?></td>
                        </tr>
                        <tr>
                            <td><b>ডেজিগনেশনঃ </b></td>
                            <td><?php echo "$aab_designation_name ($aab_designation_star স্টার)"; ?></td>
                        </tr>
                        <tr>
                            <td><b>একাউন্ট টাইপঃ </b></td>
                            <td>সেটেল একাউন্ট</td>
                        </tr>
                        <tr>
                            <td><b>মোট এমাউন্টঃ </b></td>
                            <td><?php echo english2bangla($db_cust_balance)." টাকা";?></td>
                        </tr>
                    </table>
                </td>

                <?php
            }
            elseif($aab_user_type == "owner")
                {                
                ?>
            <td>
                <table>
                    <tr>
                        <td style='font-size: 20px; text-align:center;' colspan="2"><b>আপনার একাউন্টে স্বাগতম</b></td>
                    </tr>                            
                    <tr>
                        <td><b>কর্মরত হেড পাওয়ারস্টোরের নামঃ </b></td>
                        <td><?php echo $_SESSION['loggedInOfficeName'];?></td>
                    </tr>
                    <tr>
                        <td><b>হেড পাওয়ারস্টোরের নাম্বারঃ </b></td>
                        <td><?php echo $offnumber;?></td>
                    </tr>
                    <tr>
                        <td><b>হেড পাওয়ারস্টোরের ঠিকানাঃ </b></td>
                        <td><?php echo $offaddress;?></td>
                    </tr>
                    <tr>
                        <td><b> যোগদানের তারিখঃ </b></td>
                        <td><?php echo $db_joiningDate;?></td>
                    </tr>
                    <tr>
                        <td><b>দায়িত্ব/পোস্টঃ </b></td>
                        <td><?php echo $db_empposition;?></td>
                    </tr>
                </table>
            </td>
                <?php }
            else{                
                ?>
            <td>
                <table>
                    <tr>
                        <td style='font-size: 20px; text-align:center;' colspan="2"><b>আপনার একাউন্টে স্বাগতম</b></td>
                    </tr>                            
                    <tr>
                        <td><b>কর্মরত অফিসের নামঃ </b></td>
                        <td><?php echo $_SESSION['loggedInOfficeName'];?></td>
                    </tr>
                    <tr>
                        <td><b>অফিসের নাম্বারঃ </b></td>
                        <td><?php echo $offnumber;?></td>
                    </tr>
                    <tr>
                        <td><b>অফিসের ঠিকানাঃ </b></td>
                        <td><?php echo $offaddress;?></td>
                    </tr>
                    <tr>
                        <td><b> যোগদানের তারিখঃ </b></td>
                        <td><?php echo english2bangla(date("d/m/Y",  strtotime($db_postingdate)));?></td>
                    </tr>
                    <tr>
                        <td><b>বর্তমান গ্রেডঃ </b></td>
                        <td><?php echo $db_paygrd_name;?></td>
                    </tr>
                    <tr>
                        <td><b>বর্তমান দায়িত্ব/পোস্টঃ </b></td>
                        <td><?php echo $db_empposition;?></td>
                    </tr>
                </table>
            </td>
            <?php
            }
            ?>
            <td style="width: 35%; text-align: center;">
                <table >
                    <tr>
                        <td style="font-size: 16px; text-align: center;"><b><?php echo $session_account_name; ?></b></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;"><img src="<?php echo $aab_picture; ?>" width='120px' height='120px'/></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;"><?php echo $aab_mobile; ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;"><?php echo $aab_email; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php
        if ($aab_user_type == "customer") {
            ?>
            <tr>
                <td colspan="2"><hr style="height: 4px;"></hr></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table>
                        here some PV report will be kept
                    </table>
                </td>
            </tr>
            <?php
        }
        elseif($aab_user_type != "customer" && $aab_user_type != "owner"){
        ?>            
        <tr>
            <td colspan="2" ><hr /></td>
        </tr>
        <tr>
            <td style="padding-left: 20px;"><b>কর্মচারীর টাইপ</b></td>
            <td>: <?php echo $arrayUserType[$session_user_type];?></td>
        </tr>
        <tr>
            <td style="padding-left: 20px;"><b>চাকরিতে সর্বপ্রথম যোগদান </b></td>
            <td>: <?php echo $db_joiningDate;?></td>
        </tr>
        <tr>
            <td style="padding-left: 20px;"><b>চাকরিতে সর্বপ্রথম গ্রেড</b></td>
            <td>: <?php echo $db_firstgrade;?></td>
        </tr>
            <?php
        }
            ?>
    </table>
</div>
<?php
include_once 'includes/footer.php';
?>