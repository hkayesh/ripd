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
    xmlhttp.open("GET","includes/getDistrict2.php?did="+division_id,true);
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
    xmlhttp.open("GET","includes/getThana2.php?tDsId="+district_id+"&tDfId="+division_id,true);
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
    xmlhttp.open("GET","includes/getPostOffice.php?ThId="+thana_id,true);
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
    xmlhttp.open("GET","includes/getVillage.php?PoId="+post_id,true);
    xmlhttp.send();
}

//**************###########****************##########********************###############******************
function getDistrict1()
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
            document.getElementById('did1').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id;
    division_id = document.getElementById('division_id1').value;
    xmlhttp.open("GET","includes/getDistrict21.php?did="+division_id,true);
    xmlhttp.send();
}

function getThana1()
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
            document.getElementById('tid1').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id, district_id;
    division_id = document.getElementById('division_id1').value;
    district_id = document.getElementById('district_id1').value;
    xmlhttp.open("GET","includes/getThana21.php?tDsId="+district_id+"&tDfId="+division_id,true);
    xmlhttp.send();
}

function getPostOffice1()
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
            document.getElementById('pid1').innerHTML=xmlhttp.responseText;
        }
    }
    var thana_id = document.getElementById('thana_id1').value;
    xmlhttp.open("GET","includes/getPostOffice1.php?ThId="+thana_id,true);
    xmlhttp.send();
}

function getVillage1()
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
            document.getElementById('vid1').innerHTML=xmlhttp.responseText;
        }
    }
    var post_id = document.getElementById('post_id1').value;
    xmlhttp.open("GET","includes/getVillage1.php?PoId="+post_id,true);
    xmlhttp.send();
}

//**************###########****************##########********************###############******************
function getDistrict2()
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
            document.getElementById('did2').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id;
    division_id = document.getElementById('division_id2').value;
    xmlhttp.open("GET","includes/getDistrict22.php?did="+division_id,true);
    xmlhttp.send();
}

function getThana2()
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
            document.getElementById('tid2').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id, district_id;
    division_id = document.getElementById('division_id2').value;
    district_id = document.getElementById('district_id2').value;
    xmlhttp.open("GET","includes/getThana22.php?tDsId="+district_id+"&tDfId="+division_id,true);
    xmlhttp.send();
}

function getPostOffice2()
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
            document.getElementById('pid2').innerHTML=xmlhttp.responseText;
        }
    }
    var thana_id = document.getElementById('thana_id2').value;
    xmlhttp.open("GET","includes/getPostOffice2.php?ThId="+thana_id,true);
    xmlhttp.send();
}

function getVillage2()
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
            document.getElementById('vid2').innerHTML=xmlhttp.responseText;
        }
    }
    var post_id = document.getElementById('post_id2').value;
    xmlhttp.open("GET","includes/getVillage2.php?PoId="+post_id,true);
    xmlhttp.send();
}

//**************###########****************##########********************###############******************
function getDistrict3()
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
            document.getElementById('did3').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id;
    division_id = document.getElementById('division_id3').value;
    xmlhttp.open("GET","includes/getDistrict23.php?did="+division_id,true);
    xmlhttp.send();
}

function getThana3()
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
            document.getElementById('tid3').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id, district_id;
    division_id = document.getElementById('division_id3').value;
    district_id = document.getElementById('district_id3').value;
    xmlhttp.open("GET","includes/getThana23.php?tDsId="+district_id+"&tDfId="+division_id,true);
    xmlhttp.send();
}

function getPostOffice3()
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
            document.getElementById('pid3').innerHTML=xmlhttp.responseText;
        }
    }
    var thana_id = document.getElementById('thana_id3').value;
    xmlhttp.open("GET","includes/getPostOffice3.php?ThId="+thana_id,true);
    xmlhttp.send();
}

function getVillage3()
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
            document.getElementById('vid3').innerHTML=xmlhttp.responseText;
        }
    }
    var post_id = document.getElementById('post_id3').value;
    xmlhttp.open("GET","includes/getVillage3.php?PoId="+post_id,true);
    xmlhttp.send();
}
//**************###########****************##########********************###############******************
function getDistrict4()
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
            document.getElementById('did4').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id;
    division_id = document.getElementById('division_id4').value;
    xmlhttp.open("GET","includes/getDistrict24.php?did="+division_id,true);
    xmlhttp.send();
}

function getThana4()
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
            document.getElementById('tid4').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id, district_id;
    division_id = document.getElementById('division_id4').value;
    district_id = document.getElementById('district_id4').value;
    xmlhttp.open("GET","includes/getThana24.php?tDsId="+district_id+"&tDfId="+division_id,true);
    xmlhttp.send();
}

function getPostOffice4()
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
            document.getElementById('pid4').innerHTML=xmlhttp.responseText;
        }
    }
    var thana_id = document.getElementById('thana_id4').value;
    xmlhttp.open("GET","includes/getPostOffice4.php?ThId="+thana_id,true);
    xmlhttp.send();
}

function getVillage4()
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
            document.getElementById('vid4').innerHTML=xmlhttp.responseText;
        }
    }
    var post_id = document.getElementById('post_id4').value;
    xmlhttp.open("GET","includes/getVillage4.php?PoId="+post_id,true);
    xmlhttp.send();
}
//**************###########****************##########********************###############******************
function getDistrict5()
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
            document.getElementById('did5').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id;
    division_id = document.getElementById('division_id5').value;
    xmlhttp.open("GET","includes/getDistrict25.php?did="+division_id,true);
    xmlhttp.send();
}

function getThana5()
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
            document.getElementById('tid5').innerHTML=xmlhttp.responseText;
        }
    }
    var division_id, district_id;
    division_id = document.getElementById('division_id5').value;
    district_id = document.getElementById('district_id5').value;
    xmlhttp.open("GET","includes/getThana25.php?tDsId="+district_id+"&tDfId="+division_id,true);
    xmlhttp.send();
}

function getPostOffice5()
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
            document.getElementById('pid5').innerHTML=xmlhttp.responseText;
        }
    }
    var thana_id = document.getElementById('thana_id5').value;
    xmlhttp.open("GET","includes/getPostOffice5.php?ThId="+thana_id,true);
    xmlhttp.send();
}

function getVillage5()
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
            document.getElementById('vid5').innerHTML=xmlhttp.responseText;
        }
    }
    var post_id = document.getElementById('post_id5').value;
    xmlhttp.open("GET","includes/getVillage5.php?PoId="+post_id,true);
    xmlhttp.send();
}