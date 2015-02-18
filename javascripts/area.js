function getDistrict()
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
            document.getElementById('did').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id, method_name;
    division_id = document.getElementById('division_id').value;
    method_name = document.getElementById('method').value;
    xmlhttp.open("GET","includes/getDistrict.php?did="+division_id+"&mtD="+method_name,true);
    xmlhttp.send();
}

function getThana()
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
            document.getElementById('tid').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id, district_id, method_name;
    division_id = document.getElementById('division_id').value;
    district_id = document.getElementById('district_id').value;
    method_name = document.getElementById('method').value;
    xmlhttp.open("GET","includes/getThana.php?tDsId="+district_id+"&tDfId="+division_id+"&mtT="+method_name,true);
    xmlhttp.send();
}
function getPostOffice()
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
            document.getElementById('pid').innerHTML=xmlhttp.responseText;
        }
    }
    var thana_id = document.getElementById('thana_id').value;
    var method_name = document.getElementById('method').value;
    xmlhttp.open("GET","includes/getPostOfficeCust.php?ThId="+thana_id+"&mtT="+method_name,true);
    xmlhttp.send();
}

function getVillage()
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
            document.getElementById('vid').innerHTML=xmlhttp.responseText;
        }
    }
    var post_id = document.getElementById('post_id').value;
    var method_name = document.getElementById('method').value;
    xmlhttp.open("GET","includes/getVillageCust.php?PoId="+post_id+"&mtT="+method_name,true);
    xmlhttp.send();
}
    
