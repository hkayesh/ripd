<?php
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include 'includes/ConnectDB.inc';
include 'includes/header.php';
?>
<style type="text/css"> @import "css/bush.css";</style>
<link href="css/print.css" rel="stylesheet" type="text/css" media="print"/>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div id="noprint" style="padding-left: 110px;"><a href="cheque_making_for_in.php"><b>ফিরে যান</b></a></div>
        <div>           
           <table  class="formstyle" style="width: 98%;">          
                    <tr><th colspan="2" style="text-align: center;">ক্যাশ আউট</th></tr>
                    <tr>
                        <td>
                            <div id="cheque" style="width: 99%; height: 280px; padding: 0 2px;font-size: 14px;font-weight: bold;border: blue solid 2px; margin: 0 auto;background-image: url(images/cheque.gif);background-repeat: no-repeat;background-size:100% 100%;">
                                <div id="head" style="width: 100%; height: 18%;">
                                    <div id="company" style="width: 60%; height: 100%; float: left; background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 100%;"></div>
                                    <div id="dt" style="width: 40%;height: 100%;float: left;">Date: <?php echo date("d-m-Y");?></br>
                                    Cheque No: <input type="text" readonly="" size="13" value="3433-3434-3433-8786"/></div>
                                </div>
                                <div id="middle1" style="width: 100%;height: 10%;padding-top: 10px;">
                                    <div id="userinfo" style="width: 60%;height: 100%;float: left;"><span>Thana/ P.O./ Village: </span></div>
                                    <div id="customerID" style="width: 40%;height: 100%;float: left;text-align: left;">Customer ID:</div>
                                </div>
                                <div id="middle2" style="width: 100%; height: 15%; ">
                                    <div id="payto" style="width: 60%;height: 100%;float: left;">Pay To: <input type="text" readonly="" style="width: 80%;"/></div>
                                    <div id="taka" style="width: 40%;height: 100%;float: left;text-align: left;">TK <input type="text" readonly="" size="15" style="height:30px;"/>/=BDT</div>
                                </div>
                                <div id="inWords" style="height:15%; width: 100%;text-align: left;">Sum Of Total in Words: <textarea readonly="" style="width: 70%;float: right;"></textarea></div>
                                <div id="bottom" style="width:100%; height: 20%;padding-top: 4px;">
                                    <div id="acINFO" style="width: 50%;height: 100%;float: left;">
                                        <div id="nam" style="height: 50%;width: 100%;">A/C Name: <span style="font-weight: normal;">sumsun nahar jesy</span></div>
                                        <div id="no" style="height: 50%;width: 100%;">A/C No. &nbsp;&nbsp;: <span style="font-weight: normal;">3434-3343-3434-3224</span></div>
                                    </div>
                                    <div id="sign" style="width: 50%;height:10% ;float: left;text-align:right;padding-top: 50px;"><hr style="width:100%; height: 2px; background-color: black;"/>Please sign above the line&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                </div>
                             </div>
                        </td>
                    </tr>
           </table>
        </div>
    </div>
</div>
    <?php
    include 'includes/footer.php';
    ?>