    //Employee Address information for employee_account.php
function getDistrict1()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('did').innerHTML = xmlhttp.responseText;
            }
        }
        var division_id_11;
        division_id_11 = document.getElementById('division_id_1').value;
        xmlhttp.open("GET", "includes/address_getDistrict.php?did=" + division_id_11 + "&no=1", true);
        xmlhttp.send();
    }

    function getThana1()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('tidd').innerHTML = xmlhttp.responseText;
            }
        }
        var district_id;
        district_id = document.getElementById('district_id1').value;

        xmlhttp.open("GET", "includes/address_getThana.php?tid=" + district_id + "&no=1", true);
        xmlhttp.send();
    }

function getPost_offc1()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('pidd').innerHTML = xmlhttp.responseText;
            }
        }
        var thana_id;
        thana_id = document.getElementById('thana_id1').value;

        xmlhttp.open("GET", "includes/address_getPost_offc.php?pid=" + thana_id + "&no=1", true);
        xmlhttp.send();
    }
    function getVillage1()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('vidd').innerHTML = xmlhttp.responseText;
            }
        }
        var post_id;
        post_id = document.getElementById('post_id1').value;

        xmlhttp.open("GET", "includes/address_getVillage.php?vid=" + post_id + "&no=1", true);
        xmlhttp.send();
    }

    function getDistrict2()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('did2').innerHTML = xmlhttp.responseText;
            }
        }
        var division_id_22;
        division_id_22 = document.getElementById('division_id_2').value;
        xmlhttp.open("GET", "includes/address_getDistrict.php?did=" + division_id_22 + "&no=2", true);
        xmlhttp.send();
    }

    function getThana2()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('tidd2').innerHTML = xmlhttp.responseText;
            }
        }
        var district_id;
        district_id = document.getElementById('district_id2').value;

        xmlhttp.open("GET", "includes/address_getThana.php?tid=" + district_id + "&no=2", true);
        xmlhttp.send();
    }
function getPost_offc2()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('pidd2').innerHTML = xmlhttp.responseText;
            }
        }
        var thana_id;
        thana_id = document.getElementById('thana_id2').value;

        xmlhttp.open("GET", "includes/address_getPost_offc.php?pid=" + thana_id + "&no=2", true);
        xmlhttp.send();
    }
   
    function getVillage2()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('vidd2').innerHTML = xmlhttp.responseText;
            }
        }
        var post_id;
        post_id = document.getElementById('post_id2').value;

        xmlhttp.open("GET", "includes/address_getVillage.php?vid=" + post_id + "&no=2", true);
        xmlhttp.send();
    }
    //Nominee Address information for employee_account.php
    function getDistrict3()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('did3').innerHTML = xmlhttp.responseText;
            }
        }
        var division_id_33;
        division_id_33 = document.getElementById('division_id_3').value;
        xmlhttp.open("GET", "includes/address_getDistrict.php?did=" + division_id_33 + "&no=3", true);
        xmlhttp.send();
    }
      function getThana3()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('tidd3').innerHTML = xmlhttp.responseText;
            }
        }
        var district_id;
        district_id = document.getElementById('district_id3').value;

        xmlhttp.open("GET", "includes/address_getThana.php?tid=" + district_id + "&no=3", true);
        xmlhttp.send();
    }
    function getPost_offc3()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('pidd3').innerHTML = xmlhttp.responseText;
            }
        }
        var thana_id;
        thana_id = document.getElementById('thana_id3').value;

        xmlhttp.open("GET", "includes/address_getPost_offc.php?pid=" + thana_id + "&no=3", true);
        xmlhttp.send();
    }
   
    function getVillage3()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('vidd3').innerHTML = xmlhttp.responseText;
            }
        }
        var post_id;
        post_id = document.getElementById('post_id3').value;

        xmlhttp.open("GET", "includes/address_getVillage.php?vid=" + post_id + "&no=3", true);
        xmlhttp.send();
    }
     function getDistrict4()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('did4').innerHTML = xmlhttp.responseText;
            }
        }
        var division_id_44;
        division_id_44 = document.getElementById('division_id_4').value;
        xmlhttp.open("GET", "includes/address_getDistrict.php?did=" + division_id_44 + "&no=4", true);
        xmlhttp.send();
    }
    
     function getThana4()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('tidd4').innerHTML = xmlhttp.responseText;
            }
        }
        var district_id;
        district_id = document.getElementById('district_id4').value;

        xmlhttp.open("GET", "includes/address_getThana.php?tid=" + district_id + "&no=4", true);
        xmlhttp.send();
    }
     function getPost_offc4()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('pidd4').innerHTML = xmlhttp.responseText;
            }
        }
        var thana_id;
        thana_id = document.getElementById('thana_id4').value;

        xmlhttp.open("GET", "includes/address_getPost_offc.php?pid=" + thana_id + "&no=4", true);
        xmlhttp.send();
    }
   
    function getVillage4()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('vidd4').innerHTML = xmlhttp.responseText;
            }
        }
        var post_id;
        post_id = document.getElementById('post_id4').value;

        xmlhttp.open("GET", "includes/address_getVillage.php?vid=" + post_id + "&no=4", true);
        xmlhttp.send();
    }   
     function getDistrict5()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('did5').innerHTML = xmlhttp.responseText;
            }
        }
        var division_id_55;
        division_id_55 = document.getElementById('division_id_5').value;
        xmlhttp.open("GET", "includes/address_getDistrict.php?did=" + division_id_55 + "&no=5", true);
        xmlhttp.send();
    }
    
     function getThana5()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('tidd5').innerHTML = xmlhttp.responseText;
            }
        }
        var district_id;
        district_id = document.getElementById('district_id5').value;

        xmlhttp.open("GET", "includes/address_getThana.php?tid=" + district_id + "&no=5", true);
        xmlhttp.send();
    }
    function getPost_offc5()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('pidd5').innerHTML = xmlhttp.responseText;
            }
        }
        var thana_id;
        thana_id = document.getElementById('thana_id5').value;

        xmlhttp.open("GET", "includes/address_getPost_offc.php?pid=" + thana_id + "&no=5", true);
        xmlhttp.send();
    }
   
    function getVillage5()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('vidd5').innerHTML = xmlhttp.responseText;
            }
        }
        var post_id;
        post_id = document.getElementById('post_id5').value;

        xmlhttp.open("GET", "includes/address_getVillage.php?vid=" + post_id + "&no=5", true);
        xmlhttp.send();
    }
     function getDistrict6()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('did6').innerHTML = xmlhttp.responseText;
            }
        }
        var division_id_66;
        division_id_66 = document.getElementById('division_id_6').value;
        xmlhttp.open("GET", "includes/address_getDistrict.php?did=" + division_id_66 + "&no=6", true);
        xmlhttp.send();
    }
    
     function getThana6()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('tidd6').innerHTML = xmlhttp.responseText;
            }
        }
        var district_id;
        district_id = document.getElementById('district_id6').value;

        xmlhttp.open("GET", "includes/address_getThana.php?tid=" + district_id + "&no=6", true);
        xmlhttp.send();
    }
  function getPost_offc6()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('pidd6').innerHTML = xmlhttp.responseText;
            }
        }
        var thana_id;
        thana_id = document.getElementById('thana_id6').value;

        xmlhttp.open("GET", "includes/address_getPost_offc.php?pid=" + thana_id + "&no=6", true);
        xmlhttp.send();
    }
   
    function getVillage6()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('vidd6').innerHTML = xmlhttp.responseText;
            }
        }
        var post_id;
        post_id = document.getElementById('post_id6').value;

        xmlhttp.open("GET", "includes/address_getVillage.php?vid=" + post_id + "&no=6", true);
        xmlhttp.send();
    }