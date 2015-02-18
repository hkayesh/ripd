<?php
include 'ConnectDB.inc';
if($_GET['selltype']=='1')
{
    $G_type= $_GET['type'];
    switch($G_type)
    {
        case 1:
            echo "<label style='margin-left:20px;'><b>টাকা গ্রহন&nbsp;&nbsp;:</b>
	  <input name='cash' id='cash' type='text' onkeypress='return checkIt(event)' onkeyup='minus()' /> টাকা</label>
	<label style='margin-left: 63px;'><b>টাকা ফেরত : </b>
	  <input name='change' id='change' type='text' readonly/><input type='hidden' id='checkField' value='0' /> টাকা</label>
                  <label style='margin-left: 63px;'><b>প্রকৃত ফেরত : </b>
                    <input name='actualChange' id='floorvalue' type='radio' checked /><span id='floor'></span> &nbsp;&nbsp;
                    <input name='actualChange' id='ceilingvalue' type='radio' /><span id='ceiling'></span> 
                    </label>";
        break;
        case 2:
            echo "<label style='margin-left:200px;'><b>অ্যাকাউন্ট নং&nbsp;&nbsp;:</b>
	  <input name='accountNo' id='accountNo' type='text' maxlength='15' onblur = checkAccountBalance(this.value) /></label>
	<label style='margin-left: 63px;'><b>টাকার পরিমাণ : </b>
	  <input name='amount' id='amount' onkeypress='return checkIt(event)' style='text-align:right;'  type='text' readonly/> টাকা
                    <input type='hidden' id='checkField' value='0' /></label>";
       break;
   case 3:
            echo "<label style='margin-left:20%;'><b>অ্যাকাউন্ট নং&nbsp;&nbsp;:</b>
                        <input name='accountNo' id='accountNo' type='text' maxlength='15' /></label>
                        <label style='margin-left: 5%;'><b>অ্যাকাউন্ট হতে : </b>
                        <input name='amount' id='amount' onkeypress='return checkIt(event)' onkeyup='calculateCash(this.value)' type='text'/> টাকা</label></br>
                        <label style='margin-left: 40%;'><b>ক্যাশ : </b>
                        <input name='cashTopay' id='cashTopay'  type='text' readonly /> টাকা</label></br>
                       <label style='margin-left:2%;'><b>ক্যাশ গ্রহন&nbsp;&nbsp;:</b>
                           <input name='cash2' id='cash2' type='text' onkeypress='return checkIt(event)' onkeyup='minus2()' /> টাকা</label>
                         <label style='margin-left: 3%;'><b>ক্যাশ ফেরত : </b>
                           <input name='change2' id='change2' type='text' readonly/> টাকা <input type='hidden' id='checkField' value='0' /></label>
                         <label style='margin-left: 63px;'><b>প্রকৃত ফেরত : </b>
                            <input name='actualChange' id='floorvalue' type='radio' checked /><span id='floor'></span> &nbsp;&nbsp;
                            <input name='actualChange' id='ceilingvalue' type='radio' /><span id='ceiling'></span> 
                        </label>";
       break;
    }
}
elseif($_GET['selltype']=='2')
{
    $G_type= $_GET['type'];
    switch($G_type)
    {
      case 1:
            echo "<label style='margin-left:20px;'><b>টাকা গ্রহন&nbsp;&nbsp;:</b>
                        <input name='cash' id='cash' type='text' onkeypress='return checkIt(event)' onkeyup='minus()' /> টাকা</label>
                        <label style='margin-left: 63px;'><b>টাকা ফেরত : </b>
                        <input name='change' id='change' type='text' readonly/> টাকা <input type='hidden' id='checkField' value='0' /></label>
                        <label style='margin-left: 63px;'><b>প্রকৃত ফেরত : </b>
                    <input name='actualChange' id='floorvalue' type='radio' checked /><span id='floor'></span> &nbsp;&nbsp;
                    <input name='actualChange' id='ceilingvalue' type='radio' /><span id='ceiling'></span> 
                    </label>";
        break;
        case 2:
            echo "<label style='margin-left:200px;'><b>অ্যাকাউন্ট নং&nbsp;&nbsp;:</b>
                        <input name='accountNo' id='accountNo' type='text' /></label>
                        <label style='margin-left: 63px;'><b>টাকার পরিমাণ : </b>
                        <input name='amount' id='amount' type='text' onkeypress='return checkIt(event)'  /> টাকা <input type='hidden' id='checkField' value='0' /></label>";
       break;
    }
}
?>