<?php
//error_reporting(0);
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/insertQueryPDO.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/MiscFunctions.php';

$arr_soft_cost_name = array('office'=>'অফিস', 'staff'=>'কর্মচারী', 'shariah'=>'শরীআহ কাউন্সিল', 'charity'=>'চ্যারিটি', 'presentation'=>'প্রেজেন্টেশন', 'training'=>'ট্রেনিং', 'program'=>'প্রোগ্রাম', 
                                                        'travel'=>'ট্রাভেল', 'patent'=>'প্যাটেন্ট', 'leadership'=>'লীডারশীপ', 'transport'=>'যাতায়াত', 'research'=>'গবেষণা', 'server'=>'সার্ভার', 'bag'=>'ব্যাগ', 'brochure'=>'ব্রুসিয়র', 
                                                            'form'=>'ফরম', 'money_receipt'=>'মানি রিসিট', 'pad'=>'প্যাড', 'box'=>'বক্স', 'extra'=>'অতিরিক্ত');

if($_POST['submit_command_soft_cost'])
        {
            $param_values = array_intersect_key($_POST, array_flip($columns_scc));
            $sql_insert_soft_cost_command->execute($param_values);
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
                                    //print_r($arr_command_list);
                                    foreach ($arr_command_list as $key) 
                                            {
                                            $var_command_id = $key['idcommand'];
                                            $var_command_name = $key['commandno'];
                                            $show_command_name = "কমান্ড - ".english2bangla($var_command_name);
                                            echo "<option value='$var_command_id'>$show_command_name</option>";
                                            }
                                    ?>    
                            </select>
                        </td>   
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: left; padding-left: 32%;"><b>সেলিং আর্ন</b></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;">সেলস স্টোর</td>
                        <td>: <input  class="box" type="text" name="store_selling_earn" /></td>   
                    </tr>  
                    <tr>
                        <td colspan="2" style="text-align: left; padding-left: 25%;"><b>কাস্টমারের ইনকাম</b></td>
                    </tr>
                        <td style="text-align: right; width: 40%;">ডিরেক্ট সেল</td>
                        <td>: <input  class="box" type="text" name="direct_sales_cust" /></td>   
                    </tr> 
                    <tr>
                        <td colspan='2' ><hr /></td>
                    </tr>
                    <?php
                    foreach ($arr_soft_cost_name as $scn_key=>$scn_value)
                            {
                            echo
                            "<tr>
                                <td style='text-align: right; width: 40%;'>$scn_value</td>
                                <td>: <input  class='box' type='text' name='$scn_key' value='0'/></td>   
                            </tr>"; 
                            }
                    ?>         
                    <tr>
                        <td colspan="2" style="text-align: center;"></br><input type="submit" class="btn" name="submit_command_soft_cost" id="submit_command_soft_cost" value="ঠিক আছে">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                    </tr>
                </table>
        </form>
    </div>

<?php
        include_once 'includes/footer.php';
?> 
