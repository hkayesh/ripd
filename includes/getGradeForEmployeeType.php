<?php
include_once 'ConnectDB.inc';
if($_GET['step'] == 1)
{
$g_emptype = $_GET['type'];

  echo  ": <select class='box' onchange='showSalaryRange(this.value)' name='employee_grade'><em2> *</em2>
      <option value=0> -সিলেক্ট করুন- </option>";
    $sql_paygrade= mysql_query("SELECT * FROM `pay_grade` WHERE employee_type = '$g_emptype';");
    while($paygraderow = mysql_fetch_assoc($sql_paygrade))
    {
        echo  "<option value=".$paygraderow['idpaygrade'].">".$paygraderow['grade_name']."</option>";
    }
    echo "</select>";
}
elseif($_GET['step']== 2)
{
    $g_paygrdID = $_GET['paygrdid'];
    $sel_sal = mysql_query("SELECT * FROM `pay_grade` WHERE 	idpaygrade = '$g_paygrdID';");
    $salaryrow = mysql_fetch_assoc($sel_sal);
    $minsal = $salaryrow['min_salary'];
    $maxsal = $salaryrow['max_salary'];
    echo $salrange = $minsal."-".$maxsal;
}
elseif ($_GET['step']==3) {
                  $str_key = $_GET['searchkey'];
                  $type = $_GET['type'];
                  if($type == 'office')
                  {
                    $suggest_query = "SELECT * FROM  office WHERE account_number like('$str_key%') ORDER BY account_number";
                    $reslt= mysql_query($suggest_query);
                    while($suggest = mysql_fetch_assoc($reslt)) {
                                $acc = $suggest['account_number'];
                                $id = $suggest['idOffice'];
                                $sel_onsrel = mysql_query("SELECT * FROM ons_relation WHERE catagory = '$type' AND add_ons_id = $id");
                                $onsrow = mysql_fetch_assoc($sel_onsrel);
                                $onsID = $onsrow['idons_relation'];
                                echo "<u><a onclick=setParent('$acc','$onsID'),showPost(); style='text-decoration:none;color:brown;cursor:pointer;'>" . $suggest['account_number'] . " (".$suggest['office_name'].")</a></u></br>";
                            }
                  }
                  else
                  {
                        $suggest_query = "SELECT * FROM sales_store WHERE account_number like('$str_key%') ORDER BY account_number";
                        $reslt= mysql_query($suggest_query);
                        while($suggest = mysql_fetch_assoc($reslt)) {
                                    $acc = $suggest['account_number'];
                                    $id = $suggest['idSales_store'];
                                    $sel_onsrel = mysql_query("SELECT * FROM ons_relation WHERE catagory = '$type' AND add_ons_id = $id");
                                    $onsrow = mysql_fetch_assoc($sel_onsrel);
                                    $onsID = $onsrow['idons_relation'];
                                    echo "<u><a onclick=setParent('$acc','$onsID'),showPost(); style='text-decoration:none;color:brown;cursor:pointer;'>" . $suggest['account_number'] . " (".$suggest['salesStore_name'].")</a></u></br>";
                                }
                  }
}
elseif($_GET['step'] == 4)
{
$g_onsid = $_GET['onsid'];
$sel_ons = mysql_query("SELECT * FROM ons_relation WHERE idons_relation= $g_onsid");
$onsrow = mysql_fetch_assoc($sel_ons);
$db_onstype = $onsrow['catagory'];
$db_onsid = $onsrow['add_ons_id'];

  echo  ": <select class='box' name='post' onchange='showTypeBox()'><em2> *</em2><option value=0> -সিলেক্ট করুন- </option>";
    $sql_post= mysql_query("SELECT * FROM `post`, `post_in_ons` WHERE Post_idPost = 	idPost AND post_onsid = '$db_onsid' AND post_onstype='$db_onstype' AND free_post > '0';");
    while($postrow = mysql_fetch_assoc($sql_post))
    {
        echo  "<option value=".$postrow['idpostinons'].">".$postrow['post_name']."</option>";
    }
    echo "</select>";
}
?>
