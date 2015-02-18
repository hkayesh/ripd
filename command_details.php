<?php
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/MiscFunctions.php';
$arr_pv_all_name = array('কাস্টমার টাইপ', 'সেলস টাইপ', 'স্টোর টাইপ', 'লেস এমাউন্ট', 'সেলস স্টোর (সেলিং আর্ন)', 'প্যাটেন্ট নূর হোসেন (আউটসাইড)', 'রিপড ইনকাম', 'ডিরেক্ট সেলস (কাস্টমার)', 'একাউন্ট টাইপ',
                                                    'রেফারেন্স-১', 'রেফারেন্স-২', 'রেফারেন্স-৩', 'রেফারেন্স-৪', 'রেফারেন্স-৫',
                                                        'অফিস', 'কর্মচারী', 'শরীআহ কাউন্সিল', 'চ্যারিটি', 'প্রেজেন্টেশন', 'ট্রেনিং', 'প্রোগ্রাম', 'ট্রাভেল', 'প্যাটেন্ট', 'লীডারশীপ', 
                                                        'যাতায়াত', 'গবেষণা', 'সার্ভার', 'ব্যাগ', 'ব্রুসিয়র', 'ফরম', 'মানি রিসিট', 'প্যাড', 'বক্স', 'অতিরিক্ত');

$get_command_id = $_GET['id'];
$get_command_num = $_GET['no'];
?>

<title>কমান্ড লিস্ট</title>
<style type="text/css">@import "css/bush.css";</style>
 
<div style="font-size: 14px;">
        <form  action="" method="post">
                <div style="padding-top: 10px;">    
                    <div style="padding-left: 5%; width: 58%; float: left"><a href="command_list.php"><b>ফিরে যান</b></a></div>
                </div>
                <div style="width: 95%; height: 400px; overflow: auto;">
                <table class="formstyle" style =" width:100%; margin-left: 5%;">        
                    <tr>
                        <th colspan="11" id="table_row_odd">বিভিন্ন কনফিগারেশনে কমান্ড-<?php echo english2bangla($get_command_num);?> এ পিভি বন্টন</th>
                        <th colspan="11">বিভিন্ন কনফিগারেশনে কমান্ড-<?php echo english2bangla($get_command_num);?> এ পিভি বন্টন</th>
                        <th colspan="12">বিভিন্ন কনফিগারেশনে কমান্ড-<?php echo english2bangla($get_command_num);?> এ পিভি বন্টন</th>
                    </tr>
                    <tr>
                                <?php
                                foreach ($arr_pv_all_name as $spcl_val)
                                        {
                                        echo"<td id='table_row_odd'><b>$spcl_val</b></td>"; 
                                        }
                                ?>
                    </tr>
                        <?php
                        $arr_convert_value = array('office'=>'অফিস', 's_store'=>'সেলস স্টোর', 'both'=>'অফিস/সেলস স্টোর', 'general'=>'জেনারেল সেলিং', 'whole'=>'হোল সেল', 'account'=>'এ্যাকাউন্টধারী', 'no_acc'=>'আনরেজিস্টার্ড', 'none'=>'প্যাকেজহীন');
                        $sql_pv_view->execute(array($get_command_id));                        
                        $arr_all_pv = $sql_pv_view->fetchAll();
                        foreach ($arr_all_pv as $key)
                                {
                                $count = count($key);
                                echo
                                        "<tr>";
                                                    for($a=0; $a<$count/2; $a++) 
                                                            {
                                                            $show_value = english2bangla($key[$a]);
                                                            if(array_key_exists($show_value, $arr_convert_value)) $show_value = $arr_convert_value[$show_value];
                                                            echo "<td>$show_value</td>";
                                                            }
                                 echo "</r>"; 
                                 $var_loop_count += 1;                                
                                }
                        ?>
                        <?php
                        /*$sql_select_soft_account_pv->execute(array($get_command_id));
                        $arr_soft_account_pv = $sql_select_soft_account_pv->fetchAll();
                        $var_loop_count = 0;
                        foreach ($arr_soft_account_pv as $sap_key)
                                {
                                $count = count($sap_key);
                                echo
                                        "<td>
                                            <table style='font-size: 11px;'>";
                                                    echo "<tr><td>একাউন্টধারী</td></tr>";
                                                    echo "<tr><td>জেনারেল সেলিং</td></tr>";
                                                    echo "<tr><td>অফিস/সেলস স্টোর</td></tr>";
                                                    echo "<tr><td>০</td></tr>";
                                                    echo "<tr><td>০</td></tr>";
                                                    for($a=0; $a<$count; $a++) 
                                                            {
                                                            $show_value = english2bangla($sap_key[$a]);
                                                            echo "<tr><td>$show_value</td></tr>";
                                                            }
                                 echo "</table>
                                        </td>"; 
                                 $var_loop_count += 1;
                                }
                        $arr_convert_value = array('office'=>'অফিস', 's_store'=>'সেলস স্টোর', 'general'=>'জেনারেল সেলিং', 'whole'=>'হোল সেল');
                        $sql_select_unreg_account_pv->execute(array($get_command_id));
                        $arr_unreg_account_pv = $sql_select_unreg_account_pv->fetchAll();
                        $var_loop_count = 0;
                        foreach ($arr_unreg_account_pv as $uap_key)
                                {
                                $count = count($uap_key);
                                echo
                                        "<td>
                                            <table style='font-size: 11px;'>";
                                                    echo "<tr><td>আনরেজিস্টার্ড</td></tr>";
                                                    for($a=0; $a<5; $a++) 
                                                            {
                                                            $show_value = english2bangla($uap_key[$a]);
                                                            if(array_key_exists($show_value, $arr_convert_value)) $show_value = $arr_convert_value[$show_value];
                                                            echo "<tr><td>$show_value</td></tr>";
                                                            }
                                                    echo "<tr><td>০</td></tr>";
                                                    echo "<tr><td>০</td></tr>";
                                                    echo "<tr><td>প্যাকেজহীন</td></tr>";
                                                    for($b=0; $b<5; $b++) echo "<tr><td>০</td></tr>";
                                                    for($a=5; $a<$count; $a++) 
                                                            {
                                                            $show_value = english2bangla($uap_key[$a]);
                                                            echo "<tr><td>$show_value</td></tr>";
                                                            }
                                 echo "</table>
                                        </td>"; 
                                 $var_loop_count += 1;
                                }
                        $sql_pv_view->execute(array($get_command_id));                        
                        $arr_all_pv = $sql_pv_view->fetchAll();
                        foreach ($arr_all_pv as $key)
                                {
                                $count = count($key);
                                echo
                                        "<td>
                                            <table style='font-size: 11px;'>";
                                                    echo "<tr><td>একাউন্টধারী</td></tr>";
                                                    for($a=0; $a<$count; $a++) 
                                                            {
                                                            $show_value = english2bangla($key[$a]);
                                                            if(array_key_exists($show_value, $arr_convert_value)) $show_value = $arr_convert_value[$show_value];
                                                            echo "<tr><td>$show_value</td></tr>";
                                                            }
                                 echo "</table>
                                        </td>"; 
                                 $var_loop_count += 1;                                
                                }*/
                        ?>
                </table>
                </div>
        </form>
    </div>

<?php
        include_once 'includes/footer.php';
?> 
