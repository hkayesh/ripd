<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/areaSearchForProduct.php';
$url = end(explode("/",urldecode($_GET['url'])));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css"> @import "css/bush.css";</style>
<script type="text/javascript" src="javascripts/area3.js"></script>
<script>
function getOnSpost(typeNid)
{
    var xmlhttp;
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
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('postTable').innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","includes/postListByOnS.php?typeNid="+typeNid,true);
    xmlhttp.send();
}
</script>
</head>
<body>

    <form action="<?php echo $url?>" method="post" name="uploadnew" target="parentWindow" onsubmit="setTimeout('self.close()',1000)">
    <table  class="formstyle" style="margin: 5px 10px 15px 10px; width: 100%; font-family: SolaimanLipi !important;">          
        <tr><th colspan="3" style="text-align: center;">সিলেক্ট অফিস এন্ড পোস্ট</th></tr>
        <tr>
            <td>
                <fieldset style="border:3px solid #686c70;width: 99%;">
                    <legend style="color: brown;font-size: 14px;">সার্চ করুন</legend>
                    <table>
                              <tr>
                               <td><?php getAreaOffice(); ?></td>
                               <td><select class="box" id="offNsales" name="offNsales" style="width: 200px;font-family: SolaimanLipi !important;" onchange="getOnSpost(this.value)" >
                                        <option value="0">-- অফিস / সেলসস্টোর --</option>
                                        </select>
                               </td>
                               </tr>
                      </table>
                  </fieldset>
                  </td> 
               </tr>
                <tr>
                    <td>
                        <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">অফিস নাম পোস্ট</legend>
                            <table style="width: 96%;margin: 0 auto;" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr id="table_row_odd">
                                        <td  style="border: solid black 1px;"><div align="center"><strong>পোস্টের নাম</strong></div></td>
                                        <td  style="border: solid black 1px;"><div align="center"><strong>পোস্টের সংখ্যা</strong></div></td>
                                        <td style="border: solid black 1px;"><div align="center"><strong>খালি পোস্ট</strong></div></td>
                                        <td style="border: solid black 1px;"><div align="center"><strong></strong></div></td>
                                    </tr>
                                </thead>
                                <tbody style="background-color: #FCFEFE" id="postTable"></tbody>
                            </table>
                            <input class="btn" style =" font-size: 12px; margin-left: 400px" type="submit" name="submitPost" value="সাবমিট" />
                        </fieldset>
                    </td> 
                </tr>
                </table>
</form>
</body>
</html>

