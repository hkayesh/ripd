<?php
include_once 'includes/header.php';
include_once 'includes/showTables.php';
?>
<script type="text/javascript" src="javascripts/area.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>

<script type="text/javascript">
    function send_mail(emailAddress)
    {
        TINY.box.show({iframe:'send_email.php?office_sstore_mail='+emailAddress,width:600,height:300,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'});
    }
</script>

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
        xmlhttp.open("GET","includes/infoSalesStoreFromThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id,true);
        xmlhttp.send();
    }
</script>

<div class="page_header_div">
    <div class="page_header_title">সেলসস্টোর এন্ড কন্টাক্ট</div>
</div>
<fieldset id="award_fieldset_style">
    <div style="float: left;">
        <?php
        include_once('includes/areaSearch.php');
        getArea("infoFromThana()");
        ?>
    </div>
    <div style="float: right; margin-right: 10px;">        
        <input type="hidden" id="method" value="infoFromThana()">
        সার্চ/খুঁজুন:  <input type = "text" id ="search_box_filter">
    </div>
    <span id="office">
        <br /><br />
        <div>
            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
               <thead>
                    <tr align="left" id="table_row_odd">
                        <th><?php echo "সেলস স্টোর নং"; ?></th>
                        <th><?php echo "সেলস স্টোর নেইম"; ?></th>
                        <th><?php echo "সেলস স্টোর ঠিকানা"; ?></th>
                        <th><?php echo "ই-মেইল"; ?></th>
                        <th><?php echo ""; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //officeTableHead();
                    $sql_salesStoreTable = "SELECT * from " . $dbname . ".sales_store ORDER BY salesStore_name ASC";
                    $db_slNo = 0;
                    $rs = mysql_query($sql_salesStoreTable);

                    //echo mysql_num_rows($rs);
                    while ($row_officeNcontact = mysql_fetch_array($rs)) {
                        $db_slNo = $db_slNo + 1;
                        $db_salesStoreName = $row_officeNcontact['salesStore_name'];
                        $db_salesStoreNumber = $row_officeNcontact['salesStore_number'];
                        $db_salesStoreAN = $row_officeNcontact['account_number'];
                        $db_salesStoreAddress = $row_officeNcontact['salesStore_detailsAddress'];
                        $db_salesStoreEmail = $row_officeNcontact['salesStore_email'];
                        echo "<tr>";
                        echo "<td>$db_slNo</td>";
                        echo "<td>$db_salesStoreName</td>";
                        echo "<td>$db_salesStoreAddress</td>";
                        echo "<td>$db_salesStoreEmail</td>";
                        echo "<td><a onclick=send_mail('$db_salesStoreEmail') style='cursor:pointer;color:blue;'>Send Mail</a></td>";
                        echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>                        
        </div>
    </span>          
</fieldset>

<script type="text/javascript">
    var filter = new DG.Filter({
        filterField : $('search_box_filter'),
        filterEl : $('office_info_filter')
    });
</script>

<?php
include_once 'includes/footer.php';
?>
