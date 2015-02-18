function getXmlHttpRequestObject() {
	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	} else if(window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		alert("Your Browser Sucks!");
	}
}

//Our XmlHttpRequest object to get the auto suggest
var searchReq = getXmlHttpRequestObject();

//Called from keyup on the search textbox.
//Starts the AJAX request.
function bleble(type) {
var xmlhttp;
   var str = document.getElementById('amots').value;
   
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
                if(str.length ==0)
                {
                   document.getElementById('layer2').style.display = "none";
               }
                else
                    {document.getElementById('layer2').style.display = "inline"; }
                document.getElementById('layer2').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "searchsuggest2.php?searchs="+str+"&selltype="+type, true);
        xmlhttp.send();	
        	
}

function searchProductAll(where) // productlist-er search box
{
   var xmlhttp;
   var str_key = document.getElementById('allsearch').value;
   
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
                if(str_key.length ==0)
                {
                   document.getElementById('searchResult').style.display = "none";
               }
                else
                    {document.getElementById('searchResult').style.display = "inline"; }
                document.getElementById('searchResult').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","searchsuggest2.php?searchKey="+str_key+"&where="+where,true);
        xmlhttp.send();
    
}

//Called when the AJAX response is returned.
function handleSearchSuggest() {
	if (searchReq.readyState == 4) {
	        var ss = document.getElementById('layer2');
		var str1 = document.getElementById('amots');
		var str =searchReq.responseText.split("\n");
		if(str.length==1)
		    document.getElementById('layer2').style.visibility = "hidden";
		else
		    document.getElementById('layer2').style.display = "inline";
		ss.innerHTML = '';
		for(i=0; i < str.length - 1; i++) {
			//Build our element string.  This is cleaner using the DOM, but
			//IE doesn't support dynamically added attributes.
			var suggest = '<div onmouseover="javascript:suggestOver(this);" ';
			suggest += 'onmouseout="javascript:suggestOut(this);" ';
			suggest += 'onclick="javascript:setSearch(this.innerHTML);" ';
			suggest += 'class="small">' + str[i] + '</div>';
			ss.innerHTML += suggest;
		}
	}
}

//Mouse over function
function suggestOver(div_value) {
	div_value.className = 'suggest_link_over';
}
//Mouse out function
function suggestOut(div_value) {
	div_value.className = 'suggest_link';
}
//Click function
function setSearch(value) {
	document.getElementById('amots').value = value;
	document.getElementById('layer2').innerHTML = '';
	document.getElementById('layer2').style.visibility = "hidden";
	}