<?php
error_reporting(0);
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/insertQueryPDO.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/MiscFunctions.php';

$arr_hitting_customer = array('Rone'=>'রেফারেন্স ১', 'Rtwo'=>'রেফারেন্স ২', 'Rthree'=>'রেফারেন্স ৩', 'Rfour'=>'রেফারেন্স ৪', 'Rfive'=>'রেফারেন্স ৫', 'pv_ripd_income'=>'রিপড ইনকাম');

if($_POST['submit_command_hitting_cust'])
        {
        $param_values = array_intersect_key($_POST, array_flip($columns_hitting_customer));
        $sql_insert_hitting_customer_command->execute($param_values);
        }
?>

<title>কমান্ড অপশন</title>
<style type="text/css">@import "css/bush.css";</style>
 
<div style="font-size: 14px;">
        <form  action="" method="post">
                <div style="padding-top: 10px;">    
                    <div style="padding-left: 110px; width: 58%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
                </div>
                <table class="formstyle" style =" width:78%;">        
                    <tr>
                        <th colspan="2">সফট কস্টিং সংক্রান্ত পিভি বন্টণ</th>
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;"><b>কমান্ড নম্বর</b></td>
                        <td>: 
                            <select class="box" name="command_idcommand">
                                <option value="0">- কমান্ড সিলেক্ট করুন -</option>
                                    <?php
                                    $sql_select_command->execute();
                                    $arr_command_list = $sql_select_command->fetchAll();
                                    foreach ($arr_command_list as $key_cmd) 
                                            {
                                            $var_command_id = $key_cmd['idcommand'];
                                            $var_command_name = $key_cmd['commandno'];
                                            $show_command_name = "কমান্ড - ".english2bangla($var_command_name);
                                            echo "<option value='$var_command_id'>$show_command_name</option>";
                                            }
                                    ?>    
                            </select>
                        </td>   
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;"><b>একাউন্ট টাইপ</b></td>
                        <td>: 
                            <select class="box" name="Account_type_idAccount_type">
                                <option value="0">- একাউন্ট টাইপ -</option>
                                    <?php
                                    $sql_select_account_type->execute();
                                    $arr_account_type_list = $sql_select_account_type->fetchAll();
                                    foreach ($arr_account_type_list as $key_acc) 
                                            {
                                            $var_acc_type_id = $key_acc['idAccount_type'];
                                            $var_acc_name = $key_acc['account_name'];
                                            echo "<option value='$var_acc_type_id'>$var_acc_name</option>";
                                            }
                                    ?>    
                            </select>
                        </td>   
                    </tr>
                    <?php
                    foreach ($arr_hitting_customer as $hcc_key=>$hcc_value)
                            {
                            echo
                            "<tr>
                                <td style='text-align: right; width: 40%;'>$hcc_value</td>
                                <td>: <input  class='box' type='text' name='$hcc_key' value='0'/></td>   
                            </tr>"; 
                            }
                    ?>         
                    <tr>
                        <td colspan="2" style="text-align: center;"></br><input type="submit" class="btn" name="submit_command_hitting_cust" id="submit_command_soft_cost" value="ঠিক আছে">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                    </tr>
                </table>
        </form>
    </div>

<?php
        include_once 'includes/footer.php';
?> 
