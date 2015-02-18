<?php
error_reporting(0);
include 'ConnectDB.inc';
include_once 'selectQueryPDO.php';
$loggedInOfficeType = $_SESSION['loggedInOfficeType'];
$loggedInOfficeId = $_SESSION['loggedInOfficeID'];
$sql_select_id_ons_relation = $conn->prepare("SELECT idons_relation FROM  ons_relation WHERE catagory =  ? AND add_ons_id = ?");
$sql_select_id_ons_relation->execute(array($loggedInOfficeType,$loggedInOfficeId));
$row = $sql_select_id_ons_relation->fetchAll();
foreach ($row as $value) {
    $loggedInOnSid = $value['idons_relation'];
}
if (isset($_GET['key']) && $_GET['key'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['key'];
                    $location = $_GET['location'];
	$suggest_query = "SELECT * FROM  cfs_user,employee WHERE cfs_account_status = 'active' AND account_number like('$str_key%') 
                                                AND cfs_user_idUser = idUser AND emp_ons_id=$loggedInOnSid ORDER BY  account_number";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
	            echo "<a style='text-decoration:none;color:brown;'href=".$location."?id=" . $suggest['idUser'] . ">" . $suggest['account_number'] . " (".$suggest['account_name'].")</a></br>";
        	}            
}

elseif (isset($_GET['paygradid']) && $_GET['paygradid'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$emp_paygrdid = $_GET['paygradid'];
                    $lvpolicyid = $_GET['lvpolicyid'];
                    $location = $_GET['location'];
                    $cfsuserid  = $_GET['cfsid']; 
	$sql_lvingrade =mysql_query("SELECT * FROM `leave_in_grade`WHERE pay_grade_idpaygrade =$emp_paygrdid  AND leave_policy_idleavepolicy=$lvpolicyid");
	$getrow = mysql_fetch_assoc($sql_lvingrade);
                  $grantedleavedays = $getrow['no_of_days'];
                  $db_leaveingradID = $getrow['idleaveingrd'];
                  $sql_empleave =mysql_query("SELECT * FROM `emp_in_leave`WHERE emp_id =$cfsuserid  AND leave_in_grade_idleaveingrd=$db_leaveingradID");
	while($emplvrow = mysql_fetch_assoc($sql_empleave))
                    {
                        $timestamp=time(); //current timestamp
                        $da=date("Y/m/d",$timestamp);
                        $currentyear = date('Y', strtotime($da));
                        $db_strtday = $emplvrow['starting_date'];
                        $db_totalday = $emplvrow['total_day'];
                        $strtyear = date('Y', strtotime($db_strtday));
                       if($currentyear == $strtyear)
                       {
                           $grantedleavedays = $grantedleavedays - $db_totalday;
                       }
                    }
                    echo $grantedleavedays;                
}
elseif (isset($_GET['account'])) {
	$g_accontNo = $_GET['account'];
	$suggest_query = "SELECT * FROM  cfs_user WHERE cfs_account_status = 'active' AND account_number= '$g_accontNo' ";
	$reslt= mysql_query($suggest_query);
                    if(mysql_num_rows($reslt) > 0)
                    {
                        $suggest = mysql_fetch_assoc($reslt);
                        $name = $suggest['account_name'];
                        $mobile = $suggest['mobile'];
                        $cfs_user_id = $suggest['idUser'];
                        $aab_user_type = $suggest['user_type'];
                        if($aab_user_type == 'customer')
                            {
                                $sql_select_cust_basic->execute(array($cfs_user_id));
                                $arr_cust_basic = $sql_select_cust_basic->fetchAll();
                                foreach ($arr_cust_basic as $aab) 
                                        {
                                        $aab_picture = $aab['scanDoc_picture'];
                                          }
                            }
                            elseif($aab_user_type == 'owner')
                            {
                                $sql_select_propritor_basic->execute(array($cfs_user_id));
                                $arr_proprietor_basic = $sql_select_propritor_basic->fetchAll();
                                foreach ($arr_proprietor_basic as $aab) 
                                        {
                                            $aab_picture = $aab['prop_scanDoc_picture'];
                                        }
                            }
                            else
                            {
                                $sql_select_employee_basic->execute(array($cfs_user_id));
                                $arr_employee_basic = $sql_select_employee_basic->fetchAll();
                                foreach ($arr_employee_basic as $aab) 
                                        {
                                          $aab_picture = $aab['emplo_scanDoc_picture'];
                                        }
                            }
                        echo "<table><tr><td style='text-align:center;'><img src='$aab_picture' width='128px' height='128px' alt=''></td></tr>
                            <tr>
                                <td><b>নাম :</b> $name<input type='hidden' name='receiver_user_id' value='$cfs_user_id'></td>
                            </tr>
                            <tr>
                                <td><b>মোবাইল :</b> $mobile<input type='hidden' name='user_mobile' value='$mobile'></td>
                            </tr>
                            </table>";
                    }
 else {
                    echo "দুঃখিত, একাউন্ট নাম্বারটি সঠিক নয়";    
                    }
	                   	            
}
?>
