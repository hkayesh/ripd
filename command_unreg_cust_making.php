<?php
error_reporting(0);
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/insertQueryPDO.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/MiscFunctions.php';

$arr_unreg_customer = array('less_amount'=>'লেস এমাউন্ট', 'selling_earn'=>'সেলিং আর্ন', 'patent_nh'=>'প্যাটেন্ট নুর হোসেন', 'ripd_income'=>'রিপড ইনকাম');

$msg = "";

if($_POST['submit_command_unreg_cust'])
        {
        $param_values = array_intersect_key($_POST, array_flip($columns_unreg_customer));
        if($param_values['sales_type']!='ss' && $param_values['store_type']!='st')
                {
                $sql_insert_unreg_customer_command->execute($param_values);
                $msg = "সফলভাবে ডাটা প্রবেশ করানো হয়েছে";
                }
        elseif($param_values['sales_type']=='ss' && $param_values['store_type']!='st')
                $msg = "অনুগ্রহ করে সেলসের ধরণ সিলেক্ট করুন";
        elseif($param_values['store_type']=='st')
                $msg = "অনুগ্রহ করে স্টোর সিলেক্ট করুন";
        else
                $msg = "সবগুলো অপশন সিলেক্ট করে আসুন";
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
                    <tr><td style="text-align: center;" colspan="2"><?php echo $msg;?></td></tr>
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
                        <td style="text-align: right; width: 40%;"><b>সেলিং-এর ধরণ</b></td>
                        <td>: 
                            <select class="box" name="sales_type">
                                <option value="ss">- সেলিং টাইপ -</option>
                                <option value="general">জেনারেল সেল</option>
                                <option value="whole">হোল সেল</option>
                            </select>
                        </td>   
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;"><b>স্টোরের ধরণ</b></td>
                        <td>: 
                            <select class="box" name="store_type">
                                <option value="st">- স্টোর সিলেক্ট করুন -</option>
                                <option value="office">অফিস</option>
                                <option value="s_store">সেল স্টোর</option>
                            </select>
                        </td>   
                    </tr>
                    <?php
                    foreach ($arr_unreg_customer as $ucc_key=>$ucc_value)
                            {
                            echo
                            "<tr>
                                <td style='text-align: right; width: 40%;'>$ucc_value</td>
                                <td>: <input  class='box' type='text' name='$ucc_key' value='0'/></td>   
                            </tr>"; 
                            }
                    ?>         
                    <tr>
                        <td colspan="2" style="text-align: center;"></br><input type="submit" class="btn" name="submit_command_unreg_cust" id="submit_command_unreg_cust" value="ঠিক আছে">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                    </tr>
                </table>
        </form>
    </div>

<?php
        include_once 'includes/footer.php';
?> 
