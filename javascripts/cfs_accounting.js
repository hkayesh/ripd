var radio_id = "chargeSender";
function getPassword() // for showing the password box
    {
      //  var acc = document.getElementById('mobileNo').value; 
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
                document.getElementById("passwordbox").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/amount_transfer_with_paswrd.php",true);
        xmlhttp.send();
    }

function checkIt(evt) // float value-er jonno***********************
    {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) 
        {
            status = "";
            return true;
        }
        status = "এই ফিল্ডে কেবলমাত্র সংখ্যা লেখা যাবে";
        return false;
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

function checkAmountTrans(checkvalue, charge_amount, charge_type, balance) // check amount value in repeat
    {
        var trans_amount = 0;
        var charge = 0;
        var total = 0;
        var message = document.getElementById("recieverInfo").innerText;
        var amount = document.getElementById('amount1').value;
        var amount1 = document.getElementById('amount1');
        var amount2 = document.getElementById('amount2');
        balance = parseFloat(balance);
        amount = parseFloat(amount);
        if(charge_type == "percent"){
                if(radio_id == "chargeSender"){
                    trans_amount = amount;
                    charge = charge_amount * amount / 100;
                    total = parseFloat(trans_amount) + parseFloat(charge);
            } else if(radio_id == "chargeRec"){
                    total = amount;
                    charge = charge_amount * amount / 100;
                    trans_amount = total - charge;
                }
            }else if(charge_type == "fixed"){
                if(radio_id == "chargeSender"){
                    trans_amount = amount;
                    charge = charge_amount;
                    total = parseFloat(trans_amount) + parseFloat(charge);
                   // total = trans_amount + charge;
            } else if(radio_id == "chargeRec"){
                    total = amount;
                    charge = charge_amount;
                    trans_amount = total - charge;
                }
            }
        
        if(amount1.value.length == 0 || amount2.value.length == 0){
            document.getElementById('errormsg').style.color='red';
            document.getElementById('errormsg').innerHTML = "পরিমানের ঘরটি খালি";
            document.getElementById('trans_amount').innerHTML = 0;
            document.getElementById('trans_charge').innerHTML = 0;
            document.getElementById('total_amount').innerHTML = 0;
        }
        else if(amount != checkvalue) 
        {
            document.getElementById('amount2').focus();
            document.getElementById('errormsg').style.color='red';
            document.getElementById('errormsg').innerHTML = "পরিমান সঠিক হয় নি";
        }  else if(total > balance){
            //alert(total);
            document.getElementById('errormsg').style.color='red';
            document.getElementById('errormsg').innerHTML = "একাউন্টে পর্যাপ্ত টাকা নেই";
            document.getElementById('trans_amount').innerHTML = 0;
            document.getElementById('trans_charge').innerHTML = 0;
            document.getElementById('total_amount').innerHTML = 0;
        }
        else
        {
            document.getElementById('trans_amount').innerHTML = trans_amount;
            document.getElementById('trans_charge').innerHTML = charge;
            document.getElementById('total_amount').innerHTML = total;
            document.getElementById('errormsg').innerHTML="";             
            
            if (message != "দুঃখিত, একাউন্ট নাম্বারটি সঠিক নয়"){
              document.getElementById('submit').disabled= false;  
            }  
            
        }
    }

function checkPass(passvalue) // check password in repeat
    {
        var password = document.getElementById('password1').value;
        if(password != passvalue)
        {
            document.getElementById('password2').focus();
            document.getElementById('passcheck').style.color='red';
            document.getElementById('passcheck').innerHTML = "পাসওয়ার্ড সঠিক হয় নি";
        }
        else
        {
            document.getElementById('passcheck').style.color='green';
            document.getElementById('passcheck').innerHTML="পাসওয়ার্ড মিলেছে";
            document.getElementById('submit').disabled= false;
        }
    }

function  checkCorrectPass() // match password with account
    {
        var pass = document.getElementById('password1').value;
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
                document.getElementById('showError').style.color='red';
                document.getElementById("showError").innerHTML=xmlhttp.responseText;
                var message = document.getElementById("showError").innerText;
                if(message != "")
                {
                    document.getElementById('password1').focus();
                }
            }
        }
        xmlhttp.open("GET","includes/matchPassword.php?pass="+pass,true);
        xmlhttp.send();
    }
  
function validateMobile(mblno)
    {
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
                document.getElementById("mblValidationMsg").innerHTML = xmlhttp.responseText;
                var message = document.getElementById("mblValidationMsg").innerText;
                if (message != "")
                {
                    document.getElementById('mobile').focus();
                }
            }
        }
        xmlhttp.open("GET", "includes/mobileNoValidation.php?mobile=" + mblno, true);
        xmlhttp.send();
    }

function resetForm(id)
    {
    radio_id = id;
    var amount = 0;
    document.getElementById('trans_amount').innerHTML = amount;
    document.getElementById('trans_charge').innerHTML = amount;
    document.getElementById('total_amount').innerHTML = amount;
    document.getElementById('amount').value = 0;
    document.getElementById('amount_rep').value = 0;
    document.getElementById('errorbalance').innerHTML = "";
    document.getElementById('errormsg').innerHTML = "";
    document.getElementById(id).checked = true;
    }
    
function viewCheque()
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
            document.getElementById('viewCheque').innerHTML=xmlhttp.responseText;
        }
        var amount = document.getElementById('amount_rep').value;
        var cheque = document.getElementById('cheque').value;
        document.getElementById('save_cheque').disabled= false;  
        xmlhttp.open("GET","includes/cheque.php?amount="+amount+"&cheque="+cheque,true);
        xmlhttp.send();	
    }        
    
function chargeAmount(charge, chargeType, amount)
    {
    var chargeResult = 0;
    if(chargeType == "fixed") chargeResult = charge;
    else if(chargeType == "percent") chargeResult = amount*charge/100;
    return chargeResult;
    }           
    
function repeatAmount(checkvalue, error_place, input_place) // check amount value in repeat 
    {
    var amount = document.getElementById('amount').value;
    var amount_rep = document.getElementById('amount_rep').value;
    if(amount_rep.length == 0)
        {
        document.getElementById('errormsg').style.color='red';
        document.getElementById('errormsg').innerHTML = "পরিমানের ঘরটি খালি";
        document.getElementById('view').disabled= true;  
        }
    else if(amount != checkvalue) 
        {
        document.getElementById('errormsg').style.color='red';
        document.getElementById('errormsg').innerHTML = "পরিমান সঠিক হয় নি";
        document.getElementById('view').disabled= true;  
        }
    else 
        {
        document.getElementById('errormsg').innerHTML="";
        if(error_place != "blank" && input_place != "blank")
            {
            var message = document.getElementById(error_place).innerHTML;
            var inputBox = document.getElementById(input_place).value;
            if(error_place == "mblValidationMsg" && inputBox != "" && message == "")
                    document.getElementById('view').disabled= false; 
            else if(error_place == "recieverInfo" && inputBox != "" && message != "দুঃখিত, একাউন্ট নাম্বারটি সঠিক নয়")
                    document.getElementById('view').disabled= false;  
            else document.getElementById('view').disabled= true;  
            }
        else document.getElementById('view').disabled= false;  
        }
    }
    
function chequeAmount(checkvalue, balance) // PERSONAL CHEQUE MAKING
    {
    var amount = document.getElementById('amount').value;
    var amount_rep = document.getElementById('amount_rep').value;
    checkvalue = Number(checkvalue);
    balance = Number(balance);
    if(amount.length == 0)
        {
        document.getElementById('errorbalance').style.color='red';
        document.getElementById('errorbalance').innerHTML = "পরিমানের ঘরটি খালি";
        document.getElementById('amount').focus();
        document.getElementById('view').disabled= true;  
        }
    else if(checkvalue > balance)
        {
        document.getElementById('errorbalance').style.color='red';
        document.getElementById('errorbalance').innerHTML = "একাউন্টে পর্যাপ্ত টাকা নেই";
        document.getElementById('amount').focus();
        document.getElementById('view').disabled= true;  
        }
    else if(amount_rep != checkvalue && amount_rep.length != 0) 
        {
        document.getElementById('errormsg').style.color='red';
        document.getElementById('errormsg').innerHTML = "পরিমান সঠিক হয় নি";
        document.getElementById('view').disabled= true;  
        }
    else
        {
        document.getElementById('errorbalance').innerHTML = "";
        }
    }
    
function sendTransAmount(checkvalue, charge_amount, charge_type, balance) // SEND & TRANSFER AMOUNT
    {
    var trans_amount = 0;
    var charge = 0;
    var total = 0;
    var amount = document.getElementById('amount').value;
    var amount_rep = document.getElementById('amount_rep').value;
    checkvalue = parseFloat(checkvalue);
    charge_amount = parseFloat(charge_amount);
    balance = parseFloat(balance);       
    charge = chargeAmount(charge_amount, charge_type, checkvalue);
    if(radio_id == "chargeSender")
        {
        trans_amount = checkvalue;
        total = trans_amount + charge;
        }
    else if(radio_id == "chargeRec")
        {
        total = checkvalue;
        trans_amount = total - charge;
        }
    // check the balance exceeds or not
    if(amount.length == 0)
        {
        document.getElementById('errorbalance').style.color='red';
        document.getElementById('errorbalance').innerHTML = "পরিমানের ঘরটি খালি";
        document.getElementById('amount').focus();
        document.getElementById('view').disabled= true;  
        }
    else if(total > balance)
        {
        document.getElementById('errorbalance').style.color='red';
        document.getElementById('errorbalance').innerHTML = "একাউন্টে পর্যাপ্ত টাকা নেই";
        document.getElementById('amount').focus();
        document.getElementById('view').disabled= true;  
        document.getElementById('trans_amount').innerHTML = 0;
        document.getElementById('trans_charge').innerHTML = 0;
        document.getElementById('total_amount').innerHTML = 0;
        }
    else if(amount_rep != checkvalue && amount_rep != 0) 
        {
        document.getElementById('errormsg').style.color='red';
        document.getElementById('errormsg').innerHTML = "পরিমান সঠিক হয় নি";
        document.getElementById('view').disabled= true;  
        document.getElementById('trans_amount').innerHTML = 0;
        document.getElementById('trans_charge').innerHTML = 0;
        document.getElementById('total_amount').innerHTML = 0;
        }
    else
        {
        document.getElementById('errorbalance').innerHTML = "";
        //document.getElementById('errormsg').innerHTML = "";
        document.getElementById('trans_amount').innerHTML = trans_amount;
        document.getElementById('trans_charge').innerHTML = charge;
        document.getElementById('total_amount').innerHTML = total;
        document.getElementById('trans_amount_val').value = trans_amount;
        document.getElementById('trans_charge_val').value = charge;
        document.getElementById('total_amount_val').value = total;
        }
    }