<?php
error_reporting(0);
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$loginUSERid = $_SESSION['userIDUser'] ;
$g_progcost_id = $_GET['id'];
$g_nfcid = $_GET['nfcid'];
$arr_fundtype = array('presentation'=>'SPR','program'=>'SPG','training'=>'STR','travel'=>'STL');

$sql_update_notification = $conn->prepare("UPDATE notification SET nfc_status=? WHERE idnotification=? ");
$upl_program_cost = $conn->prepare("UPDATE program_cost SET pc_status='approved' , pc_approver_id = ?, pc_approve_date = NOW() WHERE idprogcost=? ");
$insert_notification = $conn->prepare("INSERT INTO notification (nfc_senderid,nfc_receiverid,nfc_message,nfc_actionurl,nfc_date,nfc_status, nfc_type, nfc_catagory) 
                                                            VALUES (?,?,?,?,NOW(),?,?,?)");
$sel_program_cost = $conn->prepare("SELECT * FROM program_cost JOIN program ON fk_program_id = idprogram 
                                                                WHERE idprogcost= ? AND pc_status = 'made' ");
$sql_select_ons = $conn->prepare("SELECT * FROM ons_relation WHERE add_ons_id = ? AND catagory='office' ");
$sql_select_office = $conn->prepare("SELECT * FROM office WHERE idOffice = ?");
$sql_sel_fundamount = $conn->prepare("SELECT fund_amount FROM main_fund WHERE fund_code = ?");

// get program info...........................................
$sel_program_cost->execute(array($g_progcost_id)); 
$progrow = $sel_program_cost->fetchAll();
foreach ($progrow as $value) {
    $db_prog_type = $value['program_type'];
    $db_prog_no = $value['program_no'];
    $db_prog_name = $value['program_name'];
    $db_prog_location = $value['program_location'];
    $db_prog_date = $value['program_date'];
    $db_prog_time = $value['program_time'];
    $db_prog_officeID = $value['Office_idOffice'];
    $db_need_amount = $value['pc_need_amount'];
    $db_budget_date = $value['pc_make_date'];
    
    $sql_select_office->execute(array($db_prog_officeID));
        $row3 = $sql_select_office->fetchAll();
        foreach ($row3 as $value3) {
            $db_officename = $value3['office_name'];
        }
}
$sql_select_ons->execute(array($db_prog_officeID));
   $row2 = $sql_select_ons->fetchAll();
    foreach ($row2 as $value2) {
        $db_receiver_ons_ID = $value2['idons_relation'];
    }
    
$typeinbangla = getProgramType($db_prog_type);
$fundcode = $arr_fundtype[$db_prog_type];
$sql_sel_fundamount->execute(array($fundcode));
$row = $sql_sel_fundamount->fetchAll();
foreach ($row as $value) {
     $fundamount = $value['fund_amount'];
}

if(isset($_POST['submit']))
{
    $nfcID=$_POST['nfcID'];
    $progCostID=$_POST['progcostID'];
    $onsID = $_POST['senderOnsID'];
    
     $conn->beginTransaction(); 
        $sqlrslt1= $upl_program_cost->execute(array($loginUSERid , $progCostID));
        $status = 'complete';
        $sqlrslt2 = $sql_update_notification->execute(array($status,$nfcID));
        $url = "program_cost_paid.php?id=".$progCostID;
        $status1 = "unread";
        $type="action";
        $nfc_catagory="official";
        $msg = "প্রোগ্রাম বাজেট অনুমোদন";
        $sqlrslt3 = $insert_notification->execute(array($loginUSERid,$onsID,$msg,$url,$status1,$type,$nfc_catagory));
    if($sqlrslt1 && $sqlrslt2 && $sqlrslt3)
       {
           $conn->commit();
           echo "<script>alert('বাজেট অনুমোদন করা হল');</script>";
           header('Location:main_account_management.php');
       }
       else {
           $conn->rollBack();
           echo "<script>alert('দুঃখিত,বাজেট অনুমোদন করা যায়নি)</script>";
       }

}
?>

<style type="text/css">@import "css/bush.css";</style>
<script type="text/javascript">
   function beforeSave()
   {
       var fundamount = <?php echo $fundamount?>;     
       var needamount = Number(document.getElementById('need_amount').value);
       if(needamount > Number(fundamount))
           {
               alert("দুঃখিত,নির্ধারিত ফান্ডে প্রয়োজনীয় পরিমান টাকা নেই");
               return false;
           }
           else { return true;}
   }
</script>

<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="notification.php"><b>ফিরে যান</b></a></div> 
        <div>
            <form method="POST" onsubmit="return beforeSave()" action="program_cost_approval.php">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;">          
                    <tr><th colspan="4" style="text-align: center;">বাজেট তৈরি</th></tr>
                    <tr>
                        <td><?php echo $typeinbangla;?> এর নম্বর</td>
                        <td>:  <input class="box" type="text" id="prgrm_number" name="prgrm_number" readonly="" value="<?php echo $db_prog_no;?>" />
                            <input type="hidden" name="nfcID" value="<?php echo $g_nfcid;?>" /></td>
                    </tr>
                    <tr>
                        <td><?php echo $typeinbangla;?> এর নাম</td>
                        <td>:  <input class="box" type="text" id="prgrm_number" name="prgrm_number" readonly="" value="<?php echo $db_prog_name;?>" />
                         <input type="hidden" name="progcostID" value="<?php echo $g_progcost_id;?>" /></td>
                    </tr>
                    <tr>
                    <td>অফিস</td>               
                    <td colspan="3">: <input class="box" id="off_name" name="offname" readonly="" value="<?php echo $db_officename;?>" />
                    <input type="hidden" name="senderOnsID" value="<?php echo $db_receiver_ons_ID?>" /></td>
                </tr>
                <tr>
                    <td>স্থান</td>
                    <td colspan="3">: <input  class="box" type="text" id="place" name="place" readonly="" value="<?php echo $db_prog_location;?>"/></td>            
                </tr>
                <tr>
                    <td >তারিখ </td>
                    <td colspan="3">: <input class="box"type="text" id="presentation_date" name="presentation_date" readonly="" value="<?php echo english2bangla(date('d/m/Y',  strtotime($db_prog_date)));?>"/></td>      
                </tr>
                <tr>
                    <td> সময় </td>
                    <td colspan="3">: <input  class="box" type="text" id="presentation_time" name="presentation_time" readonly="" value="<?php echo english2bangla(date('h:i a',  strtotime($db_prog_time)));?>"/></td>  
                </tr>
                <tr>
                    <td>বাজেট তৈরির তারিখ </td>
                    <td colspan="3">: <input  class="box" type="text" id="budget_date" name="budget_date" readonly="" value="<?php echo english2bangla(date('d/m/Y',  strtotime($db_budget_date)));?>"/></td>  
                </tr>
                    <tr>
                        <td>প্রয়োজনীয় টাকার পরিমান</td>
                        <td>: <input  class="box" type="text" id="need_amount" name="need_amount" readonly="" value="<?php echo $db_need_amount;?>"  /> টাকা</td>
                    </tr>
                    <tr>                    
                        <td colspan="2" style="padding-left: 300px; padding-top: 10px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="ঠিক আছে" /></td>
                    </tr>    
                </table>
            </form>
        </div>
    </div>      
</div>
<?php include 'includes/footer.php'; ?>