<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$msg = "";

$loginUSERname = $_SESSION['UserID'];
$queryemp = mysql_query("SELECT idUser FROM cfs_user WHERE user_name = '$loginUSERname';");
$emprow = mysql_fetch_assoc($queryemp);
$db_onsid = $emprow['idUser'];
?>
<title>কনভার্ট একাউন্ট প্যাকেজ</title>
<style type="text/css"> @import "css/bush.css";</style>
<script>
    function getAccount(keystr) //search employee by account number***************
    {
        var xmlhttp;
        //alert("gdgfdg..........");
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if(keystr.length ==0)
            {
                document.getElementById('accountfound').style.display = "none";
            }
            else
            {document.getElementById('accountfound').style.visibility = "visible";
                document.getElementById('accountfound').setAttribute('style','position:absolute;top:36%;left:81%;width:225px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
            }
            document.getElementById('accountfound').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("POST","includes/accountSearch.php?key="+keystr+"&location=convert_package_admin.php",true);
        xmlhttp.send();	
    }    
</script>

<div class="main_text_box">
    <div style="padding-left: 110px;"><a href="crm_management.php"><b>ফিরে যান</b></a></div>
    <div>
        <form method="POST" onsubmit="" name="" enctype="multipart/form-data" action="">	
            <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 80%;">          
                <tr><th colspan="2" style="text-align: center;font-size: 18px;">কনভার্ট একাউন্ট প্যাকেজ</th></tr>
                <tr>
                <?php
                if (isset($_GET['id'])) {
                    $empCfsid = $_GET['id'];
                    $selreslt = mysql_query("SELECT * FROM  cfs_user WHERE idUser = $empCfsid");
                    $getrow = mysql_fetch_assoc($selreslt);
                    $db_empname = $getrow['account_name'];
                    $db_empmobile = $getrow['mobile'];
                    $sql_post = mysql_query("SELECT post_name FROM employee, employee_posting, post_in_ons, post
                                                                                        WHERE idPost = Post_idPost AND idpostinons = post_in_ons_idpostinons AND Employee_idEmployee = idEmployee
                                                                                            AND  cfs_user_idUser = $empCfsid");
                    $sql_postrow = mysql_fetch_assoc($sql_post);
                    $db_empposition = $sql_postrow['post_name'];
                    $sql_employee = mysql_query("SELECT * FROM employee WHERE cfs_user_idUser = $empCfsid");
                    $emprow = mysql_fetch_assoc($sql_employee);
                    $db_paygrdid = $emprow['pay_grade_id'];
                    $db_empid = $emprow['idEmployee'];
                    $sql_empinfo = mysql_query("SELECT * FROM employee_information WHERE Employee_idEmployee = $db_empid");
                    $empinforow = mysql_fetch_assoc($sql_empinfo);
                    $db_empphoto = $empinforow['emplo_scanDoc_picture'];
                    $sql_empsal = mysql_query("SELECT * FROM employee_salary WHERE user_id=$db_empid AND pay_grade_idpaygrade= $db_paygrdid;");
                    $empsalrow = mysql_fetch_assoc($sql_empsal);
                    $db_empsalary = $empsalrow['total_salary'];
                }
                ?>
                    <td>
                        <table style="margin-left: 0px !important;">
                            <tr>
                                <td style="padding-left: 0px; text-align: left; width: 35%;font-weight: bold;" >একাউন্ট ধারীর নাম</td>
                                <td style="width: 65%; text-align: left">: </td>	 
                            </tr> 
                            <tr>
                                <td style="padding-left: 0px; text-align: left; width: 35%;font-weight: bold;" >একাউন্ট নাম্বার</td>
                                <td style="width: 65%; text-align: left">: </td>	 
                            </tr> 
                            <tr>
                                <td style="padding-left: 0px; text-align: left; width: 35%;font-weight: bold;"  >বর্তমান প্যাকেজ</td>
                                <td style="width: 65%; text-align: left">: <input class="box" type="text" name="loanamount" id="loanamount" onkeypress="return checkIt(event)" /></td>	 
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: left; width: 35%;font-weight: bold;"  >পরবর্তী প্যাকেজ</td>
                                <td style="width: 65%; text-align: left">: <select class="box" name="fund"><?php ?></select></td>	 
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: left; width: 35%;font-weight: bold;"  >প্রয়োজনীয় পি.ভি.</td>
                                <td style="width: 65%; text-align: left">: <input class="box" type="text" name="loanamount" id="loanamount" onkeypress="return checkIt(event)" /></td>	 
                            </tr>
                             <tr>
                                <td style="padding-left: 0px; text-align: left; width: 35%;font-weight: bold;" >পিন নাম্বার</td>
                                <td style="width: 65%; text-align: left">: <input class="box" type="text" id="instalment_period" name="instalment_period" /></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: left; width: 35%;font-weight: bold;" >মোট পি.ভি.</td>
                                <td style="width: 65%; text-align: left">: <input class="box" type="text" id="instalment_period" name="instalment_period" /></td>
                            </tr>
                             <tr>
                                <td style="padding-left: 0px; text-align: left; width: 35%;font-weight: bold;">নতুন প্যাকেজ</td>
                                <td style="width: 65%; text-align: left">: <input class="box" type="text" id="instalment_period" name="instalment_period" /></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: left; width: 35%;font-weight: bold;" >কনভার্ট চার্জ</td>
                                <td style="width: 65%; text-align: left">: <input class="box" type="text" id="instalment_period" name="instalment_period" /></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: left; width: 35%;font-weight: bold;" >সার্ভিস চার্জ</td>
                                <td style="width: 65%; text-align: left">: <input class="box" type="text" id="instalment_period" name="instalment_period" /></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px; text-align: left; width: 35%;font-weight: bold;">মোট প্রদেয়</td>
                                <td>: <input class="box" type="text" id="instalment_period" name="instalment_period" /></td>
                            </tr>
                        </table>     
                    </td>
                    <td width="41%">
                        <table>
                            <tr>
                                <td colspan="2" style="text-align: right">একাউন্ট:  <input type="text" class="box" style="width: 200px;" id="accountsearch" name="accountsearch" onkeyup="getAccount(this.value)" placeholder="টাইপ একাউন্ট নাম্বার"/>
                                    <div id="accountfound"></div></td>
                            </tr>
                            <tr>
                                <td  colspan="2"  style="padding-left: 0px;text-align: center;"> <img src="<?php echo $db_empphoto; ?>" width="128px" height="128px" alt=""></td> 
                            </tr>
                            <tr>
                                <td width="57%"><input type="hidden" readonly="" value="<?php echo $db_empname; ?>" /><?php echo $db_empname; ?></td>
                            </tr>     
                            <tr>
                                <td><input type="hidden" readonly="" value="<?php echo $db_empposition; ?>" /><?php echo $db_empposition; ?>
                                    <input type="hidden" readonly="" id="emp_paygrade" name="emp_paygrade" value="<?php echo $db_paygrdid; ?>" /></td>
                            </tr>    
                            <tr>
                                <td><input type="hidden" readonly="" value="<?php echo $db_empmobile; ?>" /><?php echo $db_empmobile; ?>
                                    <input type="hidden" readonly="" name="empid"value="<?php echo $db_empid; ?>" /></td>
                            </tr>                                 
                            <tr>
                                <td style="text-align: center;">নামঃ</td>
                                <td></td>
                            </tr>   
                            <tr>
                                <td style="text-align: center;">মোবাইলঃ</td>
                                <td></td>
                            </tr> 
                            <tr>
                                <td style="text-align: center;">ইমেলঃ</td>
                                <td></td>
                            </tr>    
                        </table>
                    </td>
                </tr>
                <tr>                    
                    <td colspan="2" style="padding-left: 350px; " ></br><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="কনভার্ট" />
                  </br></br></td>                           
                </tr>    
            </table>
            </fieldset>
        </form>
    </div>           
</div>
<?php
include_once 'includes/footer.php';
?>
