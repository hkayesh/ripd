<?php
include_once 'includes/session.inc';
include 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/areaSearch.php';
?>
<style type="text/css"> @import "css/bush.css";</style>
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
        xmlhttp.open("GET","includes/updateOfficeFromThanaForChequeOut.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id,true);
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
                document.getElementById('office2').innerHTML=xmlhttp.responseText;
        }
        var division_id, district_id, thana_id;
        division_id = document.getElementById('division_id').value;
        district_id = document.getElementById('district_id').value;
        thana_id = document.getElementById('thana_id').value;
        xmlhttp.open("GET","includes/updateOfficeFromThanaForChequeOut2.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id,true);
        xmlhttp.send();
    }
        
</script>
<script>
    var fieldName='chkName[]';
    function selectall(){
        var i=document.frm.elements.length;
        var e=document.frm.elements;
        var name=new Array();
        var value=new Array();
        var j=0;
        for(var k=0;k<i;k++)
        {
            if(document.frm.elements[k].name==fieldName)
            {
                if(document.frm.elements[k].checked==true){
                    value[j]=document.frm.elements[k].value;
                    j++;
                }
            }
        }
        checkSelect();
    }
    function selectCheck(obj)
    {
        var i=document.frm.elements.length;
        for(var k=0;k<i;k++)
        {
            if(document.frm.elements[k].name==fieldName)
            {
                document.frm.elements[k].checked=obj;
            }
        }
        selectall();
    }

    function selectallMe()
    {
        if(document.frm.allCheck.checked==true)
        {
            selectCheck(true);
        }
        else
        {
            selectCheck(false);
        }
    }
    function checkSelect()
    {
        var i=document.frm.elements.length;
        var berror=true;
        for(var k=0;k<i;k++)
        {
            if(document.frm.elements[k].name==fieldName)
            {
                if(document.frm.elements[k].checked==false)
                {
                    berror=false;
                    break;
                }
            }
        }
        if(berror==false)
        {
            document.frm.allCheck.checked=false;
        }
        else
        {
            document.frm.allCheck.checked=true;
        }
    }
    
    function numbersonly(e)
   {
        var unicode=e.charCode? e.charCode : e.keyCode
            if (unicode!=8)
            { //if the key isn't the backspace key (which we should allow)
                if (unicode<48||unicode>57) //if not a number
                return false //disable key press
            }
}
</script>

<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div class="domtab">
            <ul class="domtabs">
                <li class="current"><a href="#01">অটো মেইকিং</a></li> 
                <li class="current"><a href="#02">ম্যানুয়েলি মেইকিং</a>
            </ul>
        </div>   

        <div>
            <h2><a name="01" id="01"></a></h2><br/>
            <form method="POST" onsubmit="" name="" action="cheque_make_out.php">	
                <table  class="formstyle">          
                    <tr><th colspan="2" style="text-align: center;">অটো মেইকিং</th></tr>
                    <tr>
                        <td>পার্সেন্টেজ (%)</td>
                        <td>:    <input  class="box" type="text" id="percent" name="percent" onkeypress=' return numbersonly(event)' /><em2> *</em2></td>            
                    </tr>
                    <tr>
                        <td >গড় এমাউন্ট</td>
                        <td>:   <input class="box" type="text" id="avg_amount" name="avg_amount" onkeypress=' return numbersonly(event)' /><em2> *</em2></td>                                  
                    </tr>
                    <tr>
                        <td>আউটের ধরন</td>
                        <td>: <select class="box2" name="transfer_to" style="width: 167px;">
                                <option value="CA">লোন এমাউন্ট</option>
                                <option value="AA">আর্ন এমাউন্ট</option>
                                <option value="EA">অতিরিক্ত এমাউন্ট</option>
                            </select>    
                        </td>                         
                    </tr>
                    <tr> 
                        <td >সিলেক্ট এরিয়া</td>
                        <td>:
                            <?php
                           // include_once 'includes/areaSearch.php';
                            getArea("infoFromThana()");
                            ?>
                            <input type="hidden" id="method" value="infoFromThana()"/>
                        </td>                    
                    </tr>
                    <tr>
                          <td colspan="6">
                            <span id="office">
                                <table  style="border: black solid 1px;" align="center" width= 90%" cellpadding="1px" cellspacing="1px">
                                    <thead>
                                        <tr style="border: black solid 1px;">
                                        <th>ক্রম</th>
                                        <th>অফিসের নাম</th>
                                        <th>অফিসের নাম্বার</th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $sql_officeTable = "SELECT * from ".$dbname.".office ORDER BY office_name ASC";
                                    $db_slNo = 0;
                                    $rs = mysql_query($sql_officeTable);

                                    while ($row_officeNcontact = mysql_fetch_assoc($rs)) 
                                    {
                                        $db_slNo = $db_slNo + 1;
                                        $db_offName = $row_officeNcontact['office_name'];
                                        $db_offNumber = $row_officeNcontact['office_number'];
                                        $db_offID = $row_officeNcontact['idOffice'];
                                        echo "<tr style='border: black solid 1px;'>";
                                        echo "<td>$db_slNo</td>";
                                        echo "<td>$db_offName</td>";
                                        echo "<td>$db_offNumber <input type='hidden'  name='officelist[]' value= $db_offID  /></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                           </span>  
                        </td>
                    </tr>    
                    <tr>                    
                        <td colspan="2" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সেভ করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>

        <div>
            <h2><a name="02" id="02"></a></h2><br/>
            <form method="POST" onsubmit="" name="frm" action="cheque_make_out.php">	
                <table  class="formstyle">          
                    <tr><th colspan="2" style="text-align: center;">ম্যানুয়েলি মেইকিং</th></tr>
                    <tr>
                        <td>আউটের ধরন</td>
                        <td>: <select class="box2" name="transfer_to" style="width: 167px;">
                                <option value="CA">লোন এমাউন্ট</option>
                                <option value="AA">আর্ন এমাউন্ট</option>
                                <option value="EA">অতিরিক্ত এমাউন্ট</option>
                            </select>    
                        </td>                         
                    </tr>
                    <tr> 
                        <td >সিলেক্ট এরিয়া</td>
                        <td>:
                            <?php
                          //  include_once 'includes/areaSearch.php';
                            getArea("infoFromThana2()");
                            ?>
                            <input type="hidden" id="method" value="infoFromThana2()"/>
                        </td>                    
                    </tr>
                    <tr>
                          <td colspan="6">
                            <span id="office2">
                                <table  style="border: black solid 1px;" align="center" width= 90%" cellpadding="1px" cellspacing="1px">
                                    <thead>
                                        <tr style="border: black solid 1px;">
                                        <th>ক্রম</th>
                                        <th>অফিসের নাম</th>
                                        <th>অফিসের নাম্বার</th>
                                        <th>টোটাল ব্যালেন্সড এমাউন্ট</th>
                                        <th>ফান্ড ব্যালেন্স</th>
                                        <th>নীড এমাউন্ট</th>
                                        <th><input type="checkbox" name="allCheck" onClick="selectallMe()" /></th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $sql_officeTable = "SELECT * from ".$dbname.".office ORDER BY office_name ASC";
                                    $db_slNo = 0;
                                    $rs = mysql_query($sql_officeTable);

                                    while ($row_officeNcontact = mysql_fetch_assoc($rs)) 
                                    {
                                        $db_slNo = $db_slNo + 1;
                                        $db_offName = $row_officeNcontact['office_name'];
                                        $db_offNumber = $row_officeNcontact['office_number'];
                                        $db_offID = $row_officeNcontact['idOffice'];
                                        echo "<tr style='border: black solid 1px;'>";
                                        echo "<td>$db_slNo</td>";
                                        echo "<td>$db_offName</td>";
                                        echo "<td>$db_offNumber</td>";
                                        echo "<td>total amount</td>";
                                        echo "<td>total fund amount</td>";
                                        echo "<td><input class='box' type='text' name ='need_amount[]' id='need_amount' onkeypress=' return numbersonly(event)'</td>";
                                        echo "<td><input type='checkbox'  name='chkName[]' value= $db_offID onClick='selectall()' /></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                           </span>  
                        </td>
                    </tr>    
                    <tr>                    
                        <td colspan="2" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit2" value="সেভ করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                    </tr>    
                </table>
            </form>
        </div>                 
    </div>
    <?php
    include 'includes/footer.php';
    ?>