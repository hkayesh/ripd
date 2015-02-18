<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$logedinOfficeId = $_SESSION['loggedInOfficeID'];
$logedinOfficeType = $_SESSION['loggedInOfficeType'];
$loginUSERid = $_SESSION['userIDUser'] ;

$sel_physc_fund = $conn->prepare("SELECT * FROM acc_store_phys WHERE ons_type = ? AND ons_id = ?");
$sel_logc_fund = $conn->prepare("SELECT * FROM acc_store_logc WHERE ons_type = ? AND ons_id = ?");

if(isset($_POST['makesalary']))
{
    // parent ons id find --------------------------------
   if($logedinOfficeType == 'office') 
 {
     $sql_select_office->execute(array($logedinOfficeId));
     $offrow = $sql_select_office->fetchAll();
     foreach ($offrow as $value) {
         $db_parent_id = $value['parent_id'];
         $sql_select_id_ons_relation->execute(array($logedinOfficeType,$db_parent_id));
         $onsrow = $sql_select_id_ons_relation->fetchAll();
         foreach ($onsrow as $value) {
             $db_onsID = $value['idons_relation'];
         }
     }    
 }
 else
 {
     $sql_select_sales_store->execute(array($logedinOfficeId));
     $offrow = $sql_select_sales_store->fetchAll();
     foreach ($offrow as $value) {
         $db_parent_id = $value['powerstore_officeid'];
         if($db_parent_id == 0)
         {
              $sql_select_id_ons_relation->execute(array($logedinOfficeType,$logedinOfficeId));
                $onsrow = $sql_select_id_ons_relation->fetchAll();
                foreach ($onsrow as $value) {
                    $db_onsID = $value['idons_relation'];
                }
         }
         else
         {
             $catagory = 'office';
             $sql_select_id_ons_relation->execute(array($catagory,$db_parent_id));
                $onsrow = $sql_select_id_ons_relation->fetchAll();
                foreach ($onsrow as $value) {
                    $db_onsID = $value['idons_relation'];
                }
         }
     }    
 }
  //-----------------------------------------------------------------------
    $msg = "salary make";
    $p_onsid = $_POST['onsID'];
    $p_empCfsID = $_POST['empCFSid'];
    $p_monthlyPay = $_POST['monthlySalary'];
    $p_xtrapay = $_POST['xtrapay'];
    $p_deduct = $_POST['deductpay'];
    $p_totalpay = $_POST['totalSalary'];
    $p_monthNo = $_POST['monthNo'];
    $p_yearNo = $_POST['yearNo'];
    $p_officeTotalSalary = $_POST['totalOfficeSalary'];
    $numberOfRows = count($p_empCfsID);
    
    $conn->beginTransaction(); 
    $sqlrslt1= $insert_sal_approval->execute(array($p_officeTotalSalary,$p_monthNo,$p_yearNo,$p_onsid,$loginUSERid));
    $sal_approval_id = $conn->lastInsertId();
    for($i=1;$i<=$numberOfRows;$i++)
    {
         $sqlrslt2= $insert_sal_chart->execute(array($p_monthNo, $p_yearNo, $p_monthlyPay[$i], $p_deduct[$i], $p_xtrapay[$i], $p_totalpay[$i-1], $p_empCfsID[$i], $sal_approval_id));
    }
    $url = "salary_approval.php?id=".$sal_approval_id;
    $status = "unread";
    $type="action";
    $nfc_catagory="official";
    $sqlrslt3 = $insert_notification->execute(array($loginUSERid,$db_onsID,$msg,$url,$status,$type,$nfc_catagory));
   
     if($sqlrslt1  && $sqlrslt2 && $sqlrslt3)
        {
            $conn->commit();
            echo "<script>alert('বেতন সফলভাবে এন্ট্রি হয়েছে')</script>";
        }
        else {
            $conn->rollBack();
            echo "<script>alert('দুঃখিত,বেতন এন্ট্রি হয়নি')</script>";
        }
}
?>
<style type="text/css"> @import "css/bush.css";</style>
<style type="text/css">
    #search {
        width: 50px;background-color: #009933;border: 2px solid #0077D5;cursor: pointer; color: wheat;
    }
    #search:hover {
        background-color: #0077D5;border: 2px inset #009933;color: wheat;
    }
</style>
<script type="text/javascript">
    function checkIt(evt) // float value-er jonno***********************
    {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        status = "";
        return true;
    }
    status = "This field accepts numbers only.";
    return false;
}

function calculateWithdraw(amount,i)
{
    var physAmount = Number(document.getElementById("physFund["+i+"]").value);
    if(amount > physAmount)
        {
            document.getElementById("withdraw["+i+"]").value = 0;
            document.getElementById('totalWithdraw').value = 0;
            alert("দুঃখিত,এই পরিমান টাকা নেই");
        }
    else
        {
            var finalamount = 0;
            for (var j=1;j<=document.getElementsByName('withdraw[]').length;j++){
                finalamount = finalamount + Number(document.getElementById('withdraw['+j+']').value);
            }
            document.getElementById('totalWithdraw').value = finalamount;
        }
}
function beforeSubmit()
{
    if ((document.getElementById('totalOfficeSalary').value !="") && (document.getElementById('totalOfficeSalary').value !=0))
        { return true; }
    else {
        return false; 
    }
}
</script>

    <div class="main_text_box" style="width: 100% !important;">
        <div style="padding-left: 50px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
          <div>
               <table  class="formstyle" style="width: 90% !important; font-family: SolaimanLipi !important;margin:0 auto !important;">          
                    <tr><th colspan="6" style="text-align: center;font-size: 22px;">টাকা উত্তোলন</th></tr>
                    <tr>
                    <td colspan="2"></br>
                        <form method="post" action="" onsubmit="return beforeSubmit();">
                        <table cellspacing="0" cellpadding="0">
                            <tr id="table_row_odd">
                                        <td style='border: 1px solid #000099;text-align: center;width: 20%;' ><strong>খাত</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 20%;' ><strong>টাকার পরিমান (হিসাবকৃত)</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 20%;' ><strong>টাকার পরিমান (ক্যাশ)</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 20%;' ><strong>উত্তোলনের পরিমান (টাকা)</strong></td>
                            </tr>
                                <tbody style="font-size: 12px !important">
                                 <?php
                                            $sel_logc_fund->execute(array($logedinOfficeType,$logedinOfficeId));
                                            $logical_fund = $sel_logc_fund->fetchAll();
                                            foreach ($logical_fund as $row) {
                                                $db_logc_acm = $row['ACM'];
                                                $db_logc_aep = $row['AEP'];
                                                $db_logc_ase = $row['ASE'];
                                                $db_logc_ari = $row['ARI'];
                                                $db_logc_soc = $row['SOC'];
                                                $db_logc_rhc = $row['RHC'];
                                                $db_logc_avg = $row['AVG'];
                                                $db_logc_spo = $row['SPO'];
                                                }
                                                $arr_logc_fund = array('ক্রয়মূল্য'=>$db_logc_acm,'এক্সট্রা প্রফিট'=>$db_logc_aep,'সেলিং আর্ন'=>$db_logc_ase,'রিপড ইনকাম'=>$db_logc_ari,'সফট কস্টিং'=>$db_logc_soc,'হিটিং কাস্টমার'=>$db_logc_rhc,'ভগ্নাংশ'=>$db_logc_avg,'প্যাটেন্ট আউটসাইড'=>$db_logc_spo, );
                                                $sel_physc_fund->execute(array($logedinOfficeType,$logedinOfficeId));
                                                $physical_fund = $sel_physc_fund->fetchAll();
                                                foreach ($physical_fund as $row) {
                                                    $db_phys_acm = $row['ACM'];
                                                    $db_phys_aep = $row['AEP'];
                                                    $db_phys_ase = $row['ASE'];
                                                    $db_phys_ari = $row['ARI'];
                                                    $db_phys_soc = $row['SOC'];
                                                    $db_phys_rhc = $row['RHC'];
                                                    $db_phys_avg = $row['AVG'];
                                                    $db_phys_spo = $row['SPO'];
                                                    }
                                                    $arr_phys_fund = array('ক্রয়মূল্য'=>$db_phys_acm,'এক্সট্রা প্রফিট'=>$db_phys_aep,'সেলিং আর্ন'=>$db_phys_ase,'রিপড ইনকাম'=>$db_phys_ari,'সফট কস্টিং'=>$db_phys_soc,'হিটিং কাস্টমার'=>$db_phys_rhc,'ভগ্নাংশ'=>$db_phys_avg,'প্যাটেন্ট আউটসাইড'=>$db_phys_spo, );
                                                    $sl = 1;
                                                    foreach ($arr_logc_fund as $key => $value) 
                                                    {
                                                        echo "<tr>
                                                            <td style='border: 1px solid black; text-align: center'>$key</td>
                                                            <td style='border: 1px solid black; text-align: center'><input class='box' type='text' style='width:92%;text-align:right' id='logcFund[$sl]' name='logcFund[$sl]' readonly value='$value' /></td>
                                                            <td style='border: 1px solid black; text-align: center'><input class='box' type='text' style='width:92%;text-align:right;' id='physFund[$sl]' name='physFund[$sl]' readonly value='$arr_phys_fund[$key]' /></td>
                                                            <td style='border: 1px solid black; text-align: center'><input class='box' type='text' style='width:92%;text-align:right;' id='withdraw[$sl]' name='withdraw[]' onkeyup=calculateWithdraw(this.value,'$sl') /></td></tr>";
                                                        $sl++;                                                       
                                                    }
                                            echo '<tr>
                                                     <td colspan="3" style="border: 1px solid black; text-align: right"><b>মোট</b></td>
                                                     <td style="border: 1px solid black; text-align: center"><input class="box" type="text" style="width:92%;text-align:right;" readonly name="totalWithdraw" id="totalWithdraw" value="0" /></td>
                                                 </tr>
                                                 <tr><td colspan="11" style="text-align: center;"></br><input class="btn" readonly="" type="submit" name="makesalary" value="ঠিক আছে" style="width: 150px;" /></td></tr>';
                                ?>     
                                </tbody>
                            </table>
                            </form>
                           </td>
                    </tr>
                </table>
        </div>                 
    </div>
    <?php include_once 'includes/footer.php';?>
