<?php
//error_reporting(0); 
include_once 'includes/header.php'; 
include_once './includes/MiscFunctions.php';
?>
<title>আপডেট অ্যাকাউন্ট</title>
<style type="text/css">@import "css/style.css";</style>
<script type="text/javascript" src="javascripts/area.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<script type="text/javascript">
    function infoFromThana()
    {
        var xmlhttp;
        if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
        else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) 
                document.getElementById('office').innerHTML=xmlhttp.responseText;
        }
        var division_id, district_id, thana_id;
        division_id = document.getElementById('division_id').value;
        district_id = document.getElementById('district_id').value;
        thana_id = document.getElementById('thana_id').value;
        xmlhttp.open("GET","includes/updateEmpFromOffThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id,true);
        xmlhttp.send();
    }
function infoFromThana2()
    {
        var xmlhttp;
        if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
        else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) 
                document.getElementById('office').innerHTML=xmlhttp.responseText;
        }
        var division_id, district_id, thana_id;
        division_id = document.getElementById('division_id').value;
        district_id = document.getElementById('district_id').value;
        thana_id = document.getElementById('thana_id').value;
        xmlhttp.open("GET","includes/updateCustFromThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id,true);
        xmlhttp.send();
    }
</script>
<div class="column6">
    <div class="main_text_box">      
        <div style="padding-left: 110px;">
            <a href="hr_employee_management.php"><b>ফিরে যান</b></a></br>
        <div style="border: 1px solid grey;">
            <table  style=" width: 100%; margin-bottom: 10px;" > 
                    <tr><th style="text-align: center; background-image: radial-gradient(circle farthest-corner at center top , #FFFFFF 0%, #0883FF 100%);height: 45px;padding-bottom: 5px;padding-top: 5px;" colspan="2" ><h1>আপডেট <?php echo $showAccountType;?> অ্যাকাউন্ট</h1></th></tr>
            </table>
            <fieldset id="fieldset_style" style=" width: 90% !important; margin-left: 30px !important;" >
        <div>
            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                <thead>
                    <tr align="left" id="table_row_odd">
                        <th><?php echo "ধরন"; ?></th>
                        <th><?php echo " নাম"; ?></th>
                        <th><?php echo "  অ্যাকাউন্ট নাম্বার"; ?></th>
                        <th><?php echo " ইমেইল"; ?></th>
                        <th><?php echo " মোবাইল নং"; ?></th>
                        <th><?php echo "করনীয়"; ?></th>
                    </tr>
                </thead>
                <tbody>                    
                    <?php
                        $sql_officeTable = "SELECT * from cfs_user,employee WHERE (user_type='programmer' OR user_type='presenter' OR user_type='trainer')
                                                        AND status='contract' AND cfs_user_idUser= idUser ORDER BY user_type,account_name ASC";
                        $rs = mysql_query($sql_officeTable);
                            while ($row_officeNcontact = mysql_fetch_array($rs)) {
                            $db_Name = $row_officeNcontact['account_name'];
                            $db_accNumber = $row_officeNcontact['account_number'];
                            $db_email = $row_officeNcontact['email'];
                            $db_mobile = $row_officeNcontact['mobile'];
                            $db_empID = $row_officeNcontact['idEmployee'];
                            $db_empType = $row_officeNcontact['user_type'];
                            echo "<tr>";
                            echo "<td>".getProgramer2($db_empType)."</td>";
                            echo "<td>$db_Name</td>";
                            echo "<td>$db_accNumber</td>";
                            echo "<td>$db_email</td>";
                            echo "<td>$db_mobile</td>";
                            $v = base64_encode($db_empID);
                            echo "<td><a href='update_employee_account_inner.php?id=$v'>আপডেট</a></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>                        
        </div>
    </span>          
</fieldset>
        </div>
            </div>
    </div>
</div>
<script type="text/javascript">
    var filter = new DG.Filter({
        filterField : $('search_box_filter'),
        filterEl : $('office_info_filter')
    });
</script>
<?php include_once 'includes/footer.php'; ?>