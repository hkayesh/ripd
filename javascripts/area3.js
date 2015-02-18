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
    var division_id;
    division_id = document.getElementById('division_id').value;
    xmlhttp.open("GET","includes/getDistrict.php?did="+division_id+"&mtD=blank",true);
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
    var division_id, district_id;
    division_id = document.getElementById('division_id').value;
    district_id = document.getElementById('district_id').value;
    xmlhttp.open("GET","includes/getThana.php?tDsId="+district_id+"&tDfId="+division_id+"&mtT=getOffice(this.value)",true);
    xmlhttp.send();
}
function getOffice(id)
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
            document.getElementById('offNsales').innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","includes/getOfficeAndSales.php?thanaid="+id,true);
    xmlhttp.send();
}
function showProductsForOnS(typeNid)
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
            document.getElementById('resultTable').innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","includes/productListByOnS.php?typeNid="+typeNid,true);
    xmlhttp.send();
}
function previousProductsForOnS(typeNid)
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
            document.getElementById('resultTable').innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","includes/previousListByOnS.php?typeNid="+typeNid,true);
    xmlhttp.send();
}