<?php
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include 'includes/header.php';
$arr_refered = array();
$sel_cfsuser = $conn->prepare("SELECT * FROM cfs_user,customer_account WHERE cfs_user_idUser = idUser AND  idUser = ?");
$sel_all_refered = $conn->prepare("SELECT * FROM customer_account WHERE referer_id = ?");
$sel_user = $conn->prepare("SELECT * FROM cfs_user WHERE idUser = ?");
$sel_parent = $conn->prepare("SELECT * FROM customer_account WHERE cfs_user_idUser = ?");

if(isset($_GET['refered']))
{
    $logedInUser = $_GET['name'];
    $logedInUserID = $_GET['refered'];
    $sel_parent->execute(array($logedInUserID));
    $refered_row = $sel_parent->fetchAll();
    foreach ($refered_row as $row) {
        $parentID = $row['referer_id'];
    }
    $sel_user->execute(array($parentID));
    $userrow = $sel_user->fetchAll();
    foreach ($userrow as $value) {
        $parentUser = $value['account_name'];
    }
    $stepPosition = $_GET['step'];
}
 else {
    $logedInUser = $_SESSION['acc_holder_name'];
    $logedInUserID = $_SESSION['userIDUser'];
    $parentUser = 0;
    $parentID = 0;
    $stepPosition = 0;
}

$sel_all_refered->execute(array($logedInUserID));
$refered_row = $sel_all_refered->fetchAll();
foreach ($refered_row as $row) {
    $db_refered_id = $row['cfs_user_idUser'];
    array_push($arr_refered, $db_refered_id);
}

function showList($referedid,$sl,$sql,$step)
{
    $sql->execute(array($referedid));
    $cfs_row = $sql->fetchAll();
    foreach ($cfs_row as $row) {
        $db_name = $row['account_name'];
    }
     echo '<li>
                  <div id="left" style="height:auto;width:350px;opacity:0;position: absolute;left:-999999px;">
                     <div id="info" style="float:left;border:1px solid black;background-color:cornsilk;width:80%"></div>
                        <div style="width:15%;height:25px;float:left; text-align:right;background-image: url(images/left.png); background-size: 100% 100%;background-repeat: no-repeat;"></div>
                   </div>
                   <a id="target" onmouseover="showspecifics('.$sl.');showLeftInfo('.$referedid.','.$step.');showRightInfo('.$referedid.','.$step.')" ><b>'.$db_name.'</b></a>
                    <div id="ri8" style="height:auto;width:330px;opacity:0;position: absolute;left:-999999px;">
                        <div style="width:15%;height:25px;float:left; text-align:right;background-image: url(images/right.png); background-size: 100% 100%;background-repeat: no-repeat;"></div>
                            <div id="ri8info" style="float:left;width:70%;height:100px;"></div>
                      </div>
              </li>';
}
?>
<title>ড্রপডাউন ট্রি</title>
<style type="text/css"> @import "css/bush.css";</style>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<script type="text/javascript" src="javascripts/jquery-1.10.2.min.js"></script>
<script>
     function showall()
    {
        document.getElementById('stepBYstep').style.opacity = 1;
    }
    function hideall()
    {
        document.getElementById('stepBYstep').style.opacity = 0;
    }
    function showspecifics(index)
    {
        document.getElementById('left').style.opacity = 1;
         document.getElementById('left').style.left = "-331px";
        var topposition = ((document.getElementById("target").offsetHeight * index)+(5*index))+"px";
        document.getElementById('left').style.top = topposition;
        document.getElementById('ri8').style.opacity = 1;
         document.getElementById('ri8').style.left = "298px";
        document.getElementById('ri8').style.top = topposition;
    }
    function hideIT()
    {
        document.getElementById('left').style.opacity = 0;
        document.getElementById('ri8').style.opacity = 0;
    }
</script>
<script type="text/javascript">
function showLeftInfo(id,step) // for showing left info 
{
    var xmlhttp;
       if (window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
                document.getElementById('info').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/dropdown_info.php?what=left&cfsid="+id+"&step="+step,true);
        xmlhttp.send();	
}
function showRightInfo(id,step) // for showing right info
{
    var xmlhttp;
       if (window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
                document.getElementById('ri8info').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/dropdown_info.php?what=ri8&cfsid="+id+"&step="+step,true);
        xmlhttp.send();	
}
</script>

<div class="column6" style="width: 100% !important;">
    <div class="main_text_box" style="width: 100% !important;height: 500px;">
        <div style="padding-left: 10px;"><a href="tree_view.php"><b>ফিরে যান</b></a></div>
        <div>
            <form method="POST" onsubmit="" name="" action="cheque_make_out.php">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important; margin:0 !important;width: 98% !important; height: 480px !important;">          
                    <tr><th colspan="2" style="text-align: center;">ড্রপডাউন ট্রি</th></tr>
                    <tr id="print">
                        <td height="368" style="padding-left: 35%;">
                            <div class="treeButton">
                                <ul>
                                    <li><a href="dropdown_tree.php?refered=<?php echo $parentID?>&name=<?php echo $parentUser;?>&step=<?php echo $stepPosition-1;?>" onmouseover="showspecifics(-1);showLeftInfo('<?php echo $logedInUserID?>','<?php echo $stepPosition;?>')" style="background-color:#698B22;">
                                        <b><?php echo $logedInUser;?></b></a>                                  
                                    <ul>
                                           <?php
                                           $sl = 0;
                                           $step = $stepPosition+1;
                                                foreach ($arr_refered as $value) {
                                                    showList($value,$sl,$sel_cfsuser,$step);
                                                    $sl++;
                                                }
                                            ?>
                                    </ul>
                                </li>
                                </ul>
                            </div>
                        </td>
                    </tr> 
                </table>
            </form>
        </div>           
    </div>
    <?php
    include 'includes/footer.php';
    ?>