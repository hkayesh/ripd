<?php
include_once 'ConnectDB.inc';
/*  Performs login checks and $_SESSION initialisation */
/* $Id: UserLogin.php 4847 2012-01-29 03:10:08Z daintree $ */

session_start();

define('UL_OK', 0);  /* User verified, session initialised */
define('UL_NOTVALID', 1); /* Could not retrieve user details using given userName and Password on login , Try Again */
define('UL_BLOCKED', 2); /* Account locked, too many failed logins */
define('UL_Temporarily_Closed', 3); /* Account is Temporarily Closed */
define('UL_SHOWLOGIN', 4);
define('UL_Permanently_Closed', 5); //Account is Permanently Closed
define('UL_Is_BLOCKED', 6);
define('UL_SHOWLOGIN_Both_Empty', 7);
define('UL_SHOWLOGIN_UserName_Empty', 8);
define('UL_SHOWLOGIN_Pass_Empty', 9);
define('UL_Already_BLOCKED', 10);

/* UserLogin
 *  Function to validate user name,  perform validity checks and initialise
 *  $_SESSION data.
 *  Returns:
 * 	See define() statements above.
 */

function userLogin($Name, $Password) {

    if (!isset($_SESSION['UserAttemptsCounter'][$Name])) {
        $_SESSION['UserAttemptsCounter'][$Name] = 1;
    } else {
        $_SESSION['UserAttemptsCounter'][$Name]++;
    }

    $sqlUserChecking = mysql_query("SELECT * FROM cfs_user WHERE user_name='$Name' AND password='$Password'");
    $rowNumberUserChecking = mysql_num_rows($sqlUserChecking);
    if ($rowNumberUserChecking > 0) {
        $myrow = mysql_fetch_array($sqlUserChecking);
        $dbBlockedStatus = $myrow['blocked'];
        $dbCfsAccountStatus = $myrow['cfs_account_status'];

        if ($dbCfsAccountStatus == 'active') {
            if ($dbBlockedStatus == 0) {
                $_SESSION['UserID'] = $myrow['user_name'];
                $_SESSION['userIDUser'] = $myrow['idUser'];
                $_SESSION['acc_holder_name'] = $myrow['account_name'];
                $_SESSION['personalAccNo'] = $myrow['account_number'];

                //......................... find out assingend office'owner','customer','employee','programmer','presenter','trainer','patent'
                $logedInUserId = $myrow['idUser'];
                $logedInUserType = $myrow['user_type'];
                $_SESSION['userType'] = $logedInUserType;
                if ($logedInUserType == 'employee' || $logedInUserType == 'presenter' || $logedInUserType == 'programmer' || $logedInUserType == 'trainer') {
                    $queryemp_ons = mysql_query("SELECT * FROM employee, ons_relation WHERE cfs_user_idUser = '$logedInUserId' AND emp_ons_id=idons_relation");
                    $emp_onsrow = mysql_fetch_assoc($queryemp_ons);
                    $office_type = $emp_onsrow['catagory'];
                    $office_or_sales_store_id = $emp_onsrow['add_ons_id'];
                    switch ($office_type) {
                        case 'office' :
                            $offquery = mysql_query("SELECT * FROM office WHERE idOffice= '$office_or_sales_store_id';");
                            $offrow = mysql_fetch_assoc($offquery);
                            $db_offname = $offrow['office_name'];
                            $db_office_acc_no = $offrow['account_number'];                            
                    
                            $_SESSION['loggedInOfficeName'] = $db_offname;
                            $_SESSION['loggedInOfficeID'] = $office_or_sales_store_id;
                            $_SESSION['loggedInOfficeType'] = $office_type;
                            $_SESSION['loggedInOfficeAccNo'] = $db_office_acc_no;
                            
                            $_SESSION['page_banner'] = 'background-image: url(images/banners/ripd_banner.png)';
                            break;

                        case 's_store' :
                            $salesquery = mysql_query("SELECT * FROM sales_store WHERE idSales_store=$office_or_sales_store_id");
                            $salesrow = mysql_fetch_assoc($salesquery);
                            $db_sstore_offname = $salesrow['salesStore_name'];
                            $db_sstore_acc_no = $salesrow['account_number'];
                            $db_sstore_banner = $salesrow['sstore_banner'];
                    
                            $_SESSION['loggedInOfficeName'] = $db_sstore_offname;
                            $_SESSION['loggedInOfficeID'] = $office_or_sales_store_id;
                            $_SESSION['loggedInOfficeType'] = $office_type;
                            $_SESSION['loggedInOfficeAccNo'] = $db_sstore_acc_no;
                            $_SESSION['page_banner_link'] = $db_sstore_banner;
                            if($db_sstore_banner!=''){
                                $_SESSION['page_banner'] = 'background-image: url('.$db_sstore_banner.')';
                            }  else {
                                $_SESSION['page_banner'] = 'background-image: url(images/banners/ripd_banner.png)';
                            }
                            break;
                    }
                } elseif ($logedInUserType == 'owner') {
                    $queryprop = mysql_query("SELECT * FROM proprietor_account WHERE cfs_user_idUser = '$logedInUserId'");
                    $proprow = mysql_fetch_assoc($queryprop);
                    $propPowerStoreName = $proprow['powerStore_name'];
                    $propPowerStoreOfficeId = $proprow['Office_idOffice'];
                    $propPowerStoreOfficeAccNo = $proprow['powerStore_accountNumber'];
                    
                    $_SESSION['loggedInOfficeName'] = $propPowerStoreName;
                    $_SESSION['loggedInOfficeID'] = $propPowerStoreOfficeId;
                    $_SESSION['loggedInOfficeType'] = 'office';
                    $_SESSION['loggedInOfficeAccNo'] = $propPowerStoreOfficeAccNo;
                    
                } elseif ($logedInUserType == 'patent') {
                    $_SESSION['loggedInOfficeName'] = 'পেটেন্ট';
                }elseif ($logedInUserType=='customer') {
                    $_SESSION['loggedInOfficeName'] = 'customerOffice';
                }
                

                //...........................................

                $roleBasedAccess_id = $myrow['security_roles_idsecurityrole'];
                $sql_roleBasedPages = mysql_query("SELECT idsecuritypage FROM view_role_based_page WHERE idsecurityrole = $roleBasedAccess_id");
                $roleBasedPageArray = array();
                $loop = 0;
                while ($rowPages = mysql_fetch_array($sql_roleBasedPages)) {
                    $roleBasedPageArray[$loop] = $rowPages['idsecuritypage'];
                    $loop++;
                }

                //..........................$_SESSION['roleBasedPageArray'] = $roleBasedPageArray;

                $extraAccessPageArray = explode(",", $myrow['extra_access']);
                $withdrawalAccessPageArray = explode(",", $myrow['withdrawl_access']);
                $mergedArrayList = array_merge($roleBasedPageArray, $extraAccessPageArray);
                $overallAccessPageArray = array_diff($mergedArrayList, $withdrawalAccessPageArray);

                /*
                $_SESSION['extraAccessPageArray'] = $extraAccessPageArray;
                $_SESSION['withdrawalAccessPageArray'] = $withdrawalAccessPageArray;
                $_SESSION['mergedAccessArray'] = $mergedArrayList;
                $_SESSION['overalAccessArray'] = $overallAccessPageArray;
                 */

                //---------------------- Make the Session Security Arrays------------------------------------
                $moduleArrayList = array();
                $subModuleArrayList = array();
                $pagesArrayList = array();
                $modSubModPagesArray = array();
                $loopValue = 0;
                $querySelectViewPages = mysql_query("SELECT * FROM view_module_submodule_page WHERE idsecuritypage IN (" . implode(',', $overallAccessPageArray) . ")");
                while ($resultSelectViewPages = mysql_fetch_array($querySelectViewPages)) {
                    $moduleId = $resultSelectViewPages['idsecuritymod'];
                    $modulePageName = $resultSelectViewPages['module_page_name'];
                    $moduleViewName = $resultSelectViewPages['module_name'];
                    $moduleArrayList[$modulePageName] = $moduleViewName;

                    $subModId = $resultSelectViewPages['idsecuritysubmod'];
                    $subModName = $resultSelectViewPages['submod_name'];
                    $subModuleArrayList[$subModId] = $subModName;

                    $pageId = $resultSelectViewPages['idsecuritypage'];
                    $pageName = $resultSelectViewPages['page_name'];
                    $pageViewName = $resultSelectViewPages['page_view_name'];

                    $pagesArrayList[$loopValue] = $modulePageName;
                    $loopValue++;
                    $pagesArrayList[$loopValue] = $pageName;
                    $loopValue++;

                    $modSubModPagesArray[$modulePageName][$subModId][$pageName] = $pageViewName;
                }
                $_SESSION['moduleArray'] = $moduleArrayList;
                $_SESSION['subModuleArray'] = $subModuleArrayList;
                $_SESSION['pagesArray'] = $pagesArrayList;
                $_SESSION['modSubModPageArray'] = $modSubModPagesArray;

                $_SESSION['UserAttemptsCounter'][$Name] = 0;

                //-------------------------------If Everything is OK---------------------
                return UL_OK;
            } else {
                return UL_BLOCKED;
            }
        } elseif ($dbCfsAccountStatus == 'temporarily_closed') {
            return UL_Temporarily_Closed;
        } elseif ($dbCfsAccountStatus == 'permanently_closed') {
            return UL_Permanently_Closed;
        }
    } else {
        // Incorrect password and 5 times login attempts, show failed login screen
        if ($_SESSION['UserAttemptsCounter'][$Name] >= 6) {
            /* User blocked from future accesses until sysadmin releases */
            $sqlUserBlockedStatus = mysql_query("SELECT blocked FROM cfs_user WHERE user_name= '$Name'");
            $resultUserBlockStatus = mysql_fetch_array($sqlUserBlockedStatus);
            $userBlockStatus = $resultUserBlockStatus['blocked'];
            if ($userBlockStatus == 0) {
                $sqlBlock = mysql_query("UPDATE cfs_user SET blocked='1' WHERE user_name= '$Name'");
                if (mysql_affected_rows() == 1) {
                    return UL_Is_BLOCKED;
                } else {
                    return UL_NOTVALID;
                }
            } else {
                return UL_Already_BLOCKED;
            }
        } else {
            //Could not retrieve user details using given userName and Password on login , Try Again
            return UL_NOTVALID;
        }
    }
}

?>