<?php
/*
 * This page need to security check
 */
error_reporting(0); 
include_once 'includes/session.inc';
include_once 'includes/header.php';         
?>
<title>আপডেট সেলসস্টোর</title>
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
        xmlhttp.open("GET","includes/updateSalesFromThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id,true);
        xmlhttp.send();
    }
</script>
    <div class="main_text_box">      
        <div style="padding-left: 110px;"><a href="office_sstore_management.php"><b>ফিরে যান</b></a></br></br>
        <div style="border: 1px solid grey;width: 90%;">
            <table  style=" width: 100%; margin-bottom: 10px;" > 
                    <tr><th style="text-align: center; background-image: radial-gradient(circle farthest-corner at center top , #FFFFFF 0%, #0883FF 100%);height: 45px;padding-bottom: 5px;padding-top: 5px;" colspan="2" ><h1>আপডেট সেলস স্টোর ইনফরমেশন</h1></th></tr>
            </table>
            <fieldset id="fieldset_style" style=" width: 95% !important; margin-left: 20px !important;" >

    

    <?php
    include_once 'includes/areaSearch.php';
    getArea("infoFromThana()");
    ?>
                <input type="hidden" id="method" value="infoFromThana()">সার্চ/খুঁজুন:  <input style="width: 150px;" type="text" id="search_box_filter">
    <span id="office">
        <br /><br />
        <div>
            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                <thead>
                    <tr align="left" id="table_row_odd">
                        <th><?php echo "সেলস স্টোরের নাম"; ?></th>
                        <th><?php echo "সেলস স্টোর নম্বর"; ?></th>
                        <th><?php echo "একাউন্ট নম্বর"; ?></th>
                        <th><?php echo "ইমেইল"; ?></th>
                        <th><?php echo "ঠিকানা"; ?></th>
                        <th><?php echo "করনীয়"; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //officeTableHead();
                    $sql_salesStoreTable = "SELECT * from ".$dbname.".sales_store ORDER BY salesStore_name ASC";
                    $rs = mysql_query($sql_salesStoreTable);

                    while ($row_officeNcontact = mysql_fetch_array($rs)) {
                        $db_salesStoreName = $row_officeNcontact['salesStore_name'];
                        $db_salesStoreNumber = $row_officeNcontact['salesStore_number'];
                        $db_salesStoreAN = $row_officeNcontact['account_number'];
                        $db_salesStoreAddress = $row_officeNcontact['salesStore_details_address'];
                        $db_salesStoreEmail = $row_officeNcontact['salesStore_email'];
                         $db_salesID = $row_officeNcontact['idSales_store'];
                        echo "<tr>";
                        echo "<td>$db_salesStoreName</td>";
                        echo "<td>$db_salesStoreNumber</td>";
                        echo "<td>$db_salesStoreAN</td>";
                        echo "<td>$db_salesStoreEmail</td>";
                        echo "<td>$db_salesStoreAddress</td>";
                         $v = base64_encode($db_salesID);
                        echo "<td><a href='update_salesStore.php?id=$v'>আপডেট</a></td>";
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

<script type="text/javascript">
    var filter = new DG.Filter({
        filterField : $('search_box_filter'),
        filterEl : $('office_info_filter')
    });
</script>
<?php include_once 'includes/footer.php'; ?>