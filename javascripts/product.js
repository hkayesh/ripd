
    function getproduct_type()
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
                document.getElementById('pcid').innerHTML = xmlhttp.responseText;
            }
        }
        var product_id_1;
        product_id_1 = document.getElementById('product_id').value;
        xmlhttp.open("GET", "includes/get_productType.php?pcid=" + product_id_1, true);
        xmlhttp.send();
    }
function getproduct_brand()
    {
     var productCatcode = document.getElementById('product_id').value;
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
                document.getElementById('pttid').innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "includes/get_productType.php?ptid="+productCatcode, true);
        xmlhttp.send();
    } 
    function getproduct_class()
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
                document.getElementById('pttid2').innerHTML = xmlhttp.responseText;
            }
        }
        var product_type_id_1;
        product_type_id_1 = document.getElementById('product_type').value;
        xmlhttp.open("GET", "includes/get_productType.php?ptid2="+product_type_id_1, true);
        xmlhttp.send();
    }