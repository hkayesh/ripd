<?php
//include 'ConnectDB.inc';
if($_GET['selltype']=='1')
{
    $G_type= $_GET['type'];
    switch($G_type)
    {
        case 1:
            echo "<table width='100%' cellspacing='0' cellpadding='0' style='border: #000000 inset 1px; font-size:20px;'><tr>";
            echo "<td width='40%'>কাস্টমার অ্যাকাউন্ট নং: <input id='accountNo' name='accountNo'  onblur='showCustName(this.value)' maxlength='15' /></td>";
            echo "<td>কাস্টমারের নামঃ <input type= 'text' id='acName' name='acName' readonly /></td>";
            echo "<td>পিন নং<a onclick='pinGenerate()' style='margin: 1% 5% 5% 5%;display: block;width: 30px;height: 30px;float: left;background-image: url(images/pingenerator.png);background-repeat: no-repeat;background-size:100% 100%;text-align:center;cursor:pointer;text-decoration:none;'></a>
                        <input type= 'text' id='pinNo' name='pinNo' readonly/></td>";
            echo "</tr></table>";
        break;
        case 2:
            echo "<table width='100%' cellspacing='0' cellpadding='0' style='border: #000000 inset 1px; font-size:20px;'><tr>";
            echo "<td>কাস্টমারের নামঃ <input id='custName' name='custName' /><em style='font-size: 10px;color:#03C;'>* অবশ্য পূরণীয়</em></td>";
            echo "<td>কাস্টমারের মোবাইল নং :<input id='custMbl' name='custMbl' onkeypress='return numbersonly(event)' /><em style='font-size: 10px;color:#03C;'>* অবশ্য পূরণীয়</em></td>";
            echo "<td>কাস্টমারের পেশাঃ <input id='custOccupation' name='custOccupation' /></td>";
            echo "</tr><tr><td colspan ='4'>&nbsp;&nbsp;</td></tr>";
            echo "<tr><td colspan='4'>কাস্টমারের ঠিকানাঃ <input id='custAdrss' name='custAdrss' style='width:600px;'/></td></tr>";    
            echo "</table>";
        break;
    case 3:
            echo "<table width='100%' cellspacing='0' cellpadding='0' style='border: #000000 inset 1px; font-size:20px;'><tr>";
            echo "<td width='50%'>কর্মচারী অ্যাকাউন্ট নং: <input id='empAccNo' name='empAccNo' onblur='showEmpName(this.value)' maxlength='15' /></td>";
            echo "<td>কর্মচারীর নামঃ <input type='text' id='empName' name='empName' readonly /></td>";
            echo "</tr></table>";
        break;  
    }
}
elseif($_GET['selltype']=='2')
{
    $G_type= $_GET['type'];
    switch($G_type)
    {
      case 1:
            echo "<table width='100%' cellspacing='0' cellpadding='0' style='border: #000000 inset 1px; font-size:20px;'><tr>";
            echo "<td>কাস্টমারের নামঃ <input id='custName' name='custName' /><em style='font-size: 10px;color:#03C;'>* অবশ্য পূরণীয়</em></td>";
            echo "<td>কাস্টমারের মোবাইল নং :<input id='custMbl' name='custMbl' onkeypress='return numbersonly(event)' /><em style='font-size: 10px;color:#03C;'>* অবশ্য পূরণীয়</em></td>";
            echo "<td>কাস্টমারের পেশাঃ <input id='custOccupation' name='custOccupation' /></td>";
            echo "</tr><tr><td colspan ='4'>&nbsp;&nbsp;</td></tr>";
            echo "<tr><td colspan='4'>কাস্টমারের ঠিকানাঃ <input id='custAdrss' name='custAdrss' style='width:600px;'/></td></tr>";    
            echo "</table>";
        break;
    case 2:
            echo "<table width='100%' cellspacing='0' cellpadding='0' style='border: #000000 inset 1px; font-size:20px;'><tr>";
            echo "<td width='50%'>সেলস স্টোর অ্যাকাউন্ট নং: <input id='accountNo' name='accountNo' onblur='showStoreName(this.value)' maxlength='15' /></td>";
            echo "<td>সেলস স্টোরের নামঃ <input type='text' id='storeName' name='storeName' readonly /></td>";
            echo "</tr></table>";
        break;
    case 3:
            echo "<table width='100%' cellspacing='0' cellpadding='0' style='border: #000000 inset 1px; font-size:20px;'><tr>";
            echo "<td width='50%'>অফিস অ্যাকাউন্ট নং: <input id='empAccNo' name='empAccNo' onblur='showOffName(this.value)' maxlength='15'/></td>";
            echo "<td>অফিসের নামঃ <input type='text' id='offName' name='offName' readonly /></td>";
            echo "</tr></table>";
        break;  
    }
}


?>