<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$msg = "";

$loginUSERname = $_SESSION['UserID'];
$queryemp = mysql_query("SELECT idUser FROM cfs_user WHERE user_name = '$loginUSERname';");
$emprow = mysql_fetch_assoc($queryemp);
?>
<title>কনভার্ট একাউন্ট প্যাকেজ</title>
<style type="text/css"> @import "css/bush.css";</style>

<div class="main_text_box">
    <div style="padding-left: 110px;"><a href="profile_account_management.php"><b>ফিরে যান</b></a></div>
    <div>
        <form method="POST" onsubmit="" name="" enctype="multipart/form-data" action="">	
            <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 80%;">          
                <tr><th colspan="2" style="text-align: center;">কনভার্ট একাউন্ট প্যাকেজ</th></tr>
<?php
if ($msg != "") {
    echo "<tr><td colspan='2' style='color:red;font-size:16px;text-align:center;'>$msg</td></tr>";
}
?>
                <tr>
                <?php
                if (isset($_GET['id'])) {
                    $empCfsid = $_GET['id'];
                    $selreslt = mysql_query("SELECT * FROM  cfs_user WHERE idUser = $empCfsid");
                    $getrow = mysql_fetch_assoc($selreslt);
                    $db_empname = $getrow['account_name'];
                    $db_empmobile = $getrow['mobile'];
                    $sql_post = mysql_query("SELECT post_name FROM employee, employee_posting, post_in_ons, post
                                                                                        WHERE idPost = Post_idPost AND idpostinons = post_in_ons_idpostinons AND Employee_idEmployee = idEmployee
                                                                                            AND  cfs_user_idUser = $empCfsid");
                    $sql_postrow = mysql_fetch_assoc($sql_post);
                    $db_empposition = $sql_postrow['post_name'];
                    $sql_employee = mysql_query("SELECT * FROM employee WHERE cfs_user_idUser = $empCfsid");
                    $emprow = mysql_fetch_assoc($sql_employee);
                    $db_paygrdid = $emprow['pay_grade_id'];
                    $db_empid = $emprow['idEmployee'];
                    $sql_empinfo = mysql_query("SELECT * FROM employee_information WHERE Employee_idEmployee = $db_empid");
                    $empinforow = mysql_fetch_assoc($sql_empinfo);
                    $db_empphoto = $empinforow['emplo_scanDoc_picture'];
                    $sql_empsal = mysql_query("SELECT * FROM employee_salary WHERE user_id=$db_empid AND pay_grade_idpaygrade= $db_paygrdid;");
                    $empsalrow = mysql_fetch_assoc($sql_empsal);
                    $db_empsalary = $empsalrow['total_salary'];
                }
                ?>
                    <td></br>
                        <table style="margin-left: 0px !important;">
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%" >একাউন্ট ধারীর নামঃ</td>
                                <td style="width: 65%"></td>	 
                            </tr> 
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%">একাউন্ট নাম্বারঃ</td>
                                <td width="65%"></td>	 
                            </tr> 
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%" >বর্তমান প্যাকেজঃ</td>
                                <td width="65%"><input class="box" type="text" name="loanamount" id="loanamount" /></td>	 
                            </tr> 
                            <tr>
                                <td colspan="2">
                                    <fieldset style="border: #686c70 solid 3px;width: 80%; margin-left: 50px">
                                        <legend style="color: brown;">সার্চ প্যাকেজ</legend>
                                        পরবর্তী প্যাকেজঃ <select class="box" name="fund" style="width: 200px">
                                             <option value="">-সিলেক্ট করুন-</option>
                                        <option value="pension">পেনশন</option>
                                        </select>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        প্রয়োজনীয় পি.ভি. : 
                                        <input class="box" type="text" id="instalment_period" name="instalment_period" style="width: 100px" />
                                    </fieldset>
                                </td>
                            </tr>
                             <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%" >এন্টার পিন নং :</td>
                                <td><input class="box" type="text" id="instalment_period" name="instalment_period" /></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%" >টোটাল পি.ভি. :</td>
                                <td><input class="box" type="text" id="instalment_period" name="instalment_period" /></td>
                            </tr>
                             <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%">নিউ প্যাকেজ :</td>
                                <td><input class="box" type="text" id="instalment_period" name="instalment_period" /></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%">কনভার্ট সার্ভিস চার্জ :</td>
                                <td> <input class="box" type="text" id="instalment_period" name="instalment_period" /></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%">একাউন্ট চার্জ :</td>
                                <td> <input class="box" type="text" id="instalment_period" name="instalment_period" /></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%">টোটাল একাউন্ট পে:</td>
                                <td> <input class="box" type="text" id="instalment_period" name="instalment_period" /></td>
                            </tr>
                             <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%">পাসওয়ার্ড:</td>
                                <td> <input class="box" type="text" id="instalment_period" name="instalment_period" /></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: right; width: 35%">রি-পাসওয়ার্ড:</td>
                                <td> <input class="box" type="text" id="instalment_period" name="instalment_period" /></td>
                            </tr>
                        </table>     
                    </td>
                    
                </tr>
                <tr>                    
                    <td colspan="2" style="padding-left: 250px; " ></br></br><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="কনভার্ট" />
                  </br></br></td>                           
                </tr>    
            </table>
            </fieldset>
        </form>
    </div>           
</div>
<?php
include_once 'includes/footer.php';
?>
