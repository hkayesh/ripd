<?php
error_reporting(0);
include_once './connectionPDO.php';
if($_GET['what'] == 'left')
{
    $g_id = $_GET['cfsid'];
    $g_step = $_GET['step'];
    $arr_stepcount[0][0] = $g_id;
    
    $sql= $conn->prepare("SELECT * FROM cfs_user,customer_account WHERE cfs_user_idUser = idUser AND  idUser = ?");
    $sql->execute(array($g_id));
    $cfs_row = $sql->fetchAll();
        foreach ($cfs_row as $row) {
            $db_number = $row['account_number'];
            $db_mbl = $row['mobile'];
            $db_pic = $row['scanDoc_picture'];
        }
        for($i=1;$i<=5;$i++)
        {
            $count = 0;
            foreach ($arr_stepcount[$i-1] as $value) {
                $sql_count= $conn->prepare("SELECT cfs_user_idUser FROM customer_account WHERE referer_id = ?");
                $sql_count->execute(array($value));
                $count_row = $sql_count->fetchAll();
                    foreach ($count_row as $row) {
                        $db_stepmember = $row['cfs_user_idUser'];
                        $arr_stepcount[$i][$count] = $db_stepmember;
                        $count++; 
                    }
            }
        }
        
    echo '<table>
                <tr><td colspan="2" style="border:1px solid black;"><img src="'.$db_pic.'" width="50px" height="50px"/></td></tr>
                <tr><td colspan="2" style="border:1px solid black;">স্টেপ '.$g_step.'</td></tr>
                <tr><td style="border:1px solid black;"><b>অ্যাকাউন্ট নং</b> </td><td style="border:1px solid black;">'.$db_number.'</td></tr>
                <tr><td style="border:1px solid black;"><b>মোবাইল নং </b></td><td style="border:1px solid black;">'.$db_mbl.'</td></tr>
                <tr><td style="border:1px solid black;"><b>আর ১</b></td><td style="border:1px solid black;">'.count($arr_stepcount[1]).'</td></tr>
                <tr><td style="border:1px solid black;"><b>আর ২</b></td><td style="border:1px solid black;">'.count($arr_stepcount[2]).'</td></tr>
                <tr><td style="border:1px solid black;"><b>আর ৩</b></td><td style="border:1px solid black;">'.count($arr_stepcount[3]).'</td></tr>
                <tr><td style="border:1px solid black;"><b>আর ৪</b></td><td style="border:1px solid black;">'.count($arr_stepcount[4]).'</td></tr>
                <tr><td style="border:1px solid black;"><b>আর ৫</b></td><td style="border:1px solid black;">'.count($arr_stepcount[5]).'</td></tr>
            </table>';
}
else
{
    $g_id = $_GET['cfsid'];
    $g_step = $_GET['step'];
    $step = $g_step+1;
    $arr_refered = array();
    $sel_all_refered = $conn->prepare("SELECT * FROM customer_account,cfs_user 
                                                                WHERE cfs_user_idUser = idUser AND referer_id = ?");
    $sel_all_refered->execute(array($g_id));
    $refered_row = $sel_all_refered->fetchAll();
    foreach ($refered_row as $row) {
        $db_refered_id = $row['cfs_user_idUser'];
        $db_refered_name = $row['account_name'];
        $arr_refered[$db_refered_id] = $db_refered_name;
    }
    echo '<ul style="position:relative;width:100%;">';
    foreach ($arr_refered as $key =>$value) {
        echo '<li><a style="width:100%;" href="dropdown_tree.php?refered='.$key.'&name='.$value.'&step='.$step.'"><b>'.$value.'</b></a></li>';
    }
    echo '</ul>';
                    
                
}
?>
