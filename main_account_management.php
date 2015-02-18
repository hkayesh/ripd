<?php
/*
 * All accessible modules will be shown here, Need to define what will be default module to show in detail. May be first module page will be default module page.
 */
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/columnLeftMainMenu.php';
include_once 'includes/selectQueryPDO.php';
$officename = $_SESSION['loggedInOfficeName'] ;
$officeID = $_SESSION['loggedInOfficeID'];
$offType = $_SESSION['loggedInOfficeType'];
if($offType == 'office')
{
    $sql_select_office -> execute(array($officeID));
    $arr_office = $sql_select_office->fetchAll();
    foreach ($arr_office as $offrow) {
        $officeAddress = $offrow['office_details_address']; 
        $officeEmail = $offrow['office_email']; 
        $officeOpeningDate = $offrow['opening_date']; 
        $date = date("d/m/Y",strtotime($officeOpeningDate));
        $officebranchName = $offrow['branch_name'];
        $parent_id = $offrow['parent_id'];
        $sql_select_office -> execute(array($parent_id));
        $arr_office = $sql_select_office->fetchAll();
        foreach ($arr_office as $offrow1) {
            $parentName = $offrow1['office_name'];
        }
    }
}
else{
    $sql_select_sales_store -> execute(array($officeID));
    $arr_sales = $sql_select_sales_store->fetchAll();
    foreach ($arr_sales as $storerow) {
        $officeAddress = $storerow['salesStore_details_address']; 
        $officeEmail = $storerow['salesStore_email']; 
        $officeOpeningDate = $storerow['opening_date']; 
        $date = date("d-m-Y",  strtotime($officeOpeningDate));
        $parent_id = $storerow['office_id'];
        $sql_select_office -> execute(array($parent_id));
        $arr_office = $sql_select_office->fetchAll();
        foreach ($arr_office as $offrow1) {
            $parentName = $offrow1['office_name'];
        }
    }
}

$session_user_id = $_SESSION['userIDUser'];
$sql_select_cfs_user_all->execute(array($session_user_id));
$arr_cfs_user = $sql_select_cfs_user_all->fetchAll();
foreach ($arr_cfs_user as $acu) {
    $aab_account_name = $acu['account_name'];
    $aab_account_number = $acu['account_number'];
    $aab_open_date = english2bangla($acu['account_open_date']);
    $aab_mobile = english2bangla($acu['mobile']);
    $aab_email = $acu['email'];
    $aab_user_type = $acu['user_type'];
    $cfs_user_id = $acu['idUser'];
}
 if ($aab_user_type == 'owner') {
    $sql_select_propritor_basic->execute(array($cfs_user_id));
    $arr_proprietor_basic = $sql_select_propritor_basic->fetchAll();
    foreach ($arr_proprietor_basic as $aab) {
        $aab_picture = $aab['prop_scanDoc_picture'];
    }
} elseif(($aab_user_type != 'customer') && ($aab_user_type != 'owner')) {
    $sql_select_employee_basic->execute(array($cfs_user_id));
    $arr_employee_basic = $sql_select_employee_basic->fetchAll();
    foreach ($arr_employee_basic as $aab) {
        $aab_picture = $aab['emplo_scanDoc_picture'];
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
            <th colspan="2" style="font-size: 15px;">স্বাগতম <?php echo $officename;?></th>
        </tr>
        <tr>
            <td>
                 <fieldset style="border: #686c70 solid 3px;width: 95%;">
                    <legend style="color: brown;">অফিসের তথ্য</legend>
                        <table>                          
                            <tr>
                                <td style="width: 40%;"><b>একাউন্ট নম্বর</b></td>
                                <td style="width: 60%;">: <?php echo $aab_account_number; ?></td>
                            </tr>
                            <tr>
                                <td><b> ব্রাঞ্চ নাম </b></td>
                                <td>: <?php echo $officebranchName; ?></td>
                            </tr>
                            <tr>
                                <td><b> প্যারেন্ট অফিসের নাম </b></td>
                                <td>: <?php echo $parentName; ?></td>
                            </tr>
                            <tr>
                                <td><b> ঠিকানা </b></td>
                                <td>: <?php echo $officeAddress; ?></td>
                            </tr>
                            <tr>
                                <td><b>ইমেইল </b></td>
                                <td>: <?php echo $officeEmail; ?></td>
                            </tr>
                            <tr>
                                <td><b>মোবাইল নং</b></td>
                                <td>: </td>
                            </tr>
                            <tr>
                                <td><b>শুরুর তারিখ</b></td>
                                <td>: <?php echo english2bangla($date); ?></td>
                            </tr>
                        </table>
                 </fieldset>
            </td>
            <td style="width: 35%; text-align: center;">
                <table >
                    <tr>
                        <td style="font-size: 16px; text-align: center;"><b><?php echo $aab_account_name; ?></b></td>
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
        <tr>
            <td></br></br></br></td>
        </tr>
    </table>
</div>
<?php  include_once 'includes/footer.php';?>