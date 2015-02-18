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
        xmlhttp.open("GET","includes/infoOfficeFromThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id,true);
        xmlhttp.send();
    }
</script>

<div class="page_header_div">
    <div class="page_header_title">অফিস এন্ড কন্টাক্ট</div>
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
        <?php
        officeTableHead();
        $sql_officeTable = "SELECT * from $dbname.office ORDER BY office_name ASC";
        officeNcontactTable($sql_officeTable);
        officeTableEnd();
        ?>
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

