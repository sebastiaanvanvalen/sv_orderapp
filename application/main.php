<?php
session_start();

require("../config/define.php");
require("../config/db.php");


if(!empty(apache_request_headers())){
    $reqHeaders = apache_request_headers();
};

if(!empty($_POST)){
    $reqHeaders = $_POST;
};

// keep the current order of the lines below!

include("../classes/CustomException.php");
include("../classes/Cryptograph.php");
include("../classes/TokenHandler.php");

$tokenHandler = new TokenHandler();
$tokenHandler->chooseType($reqHeaders['tokenType'], $reqHeaders['Authorization']);
$cryptograph  = new Cryptograph(CRYPTO_KEY);

try {
    switch ($reqHeaders['switchkey']) {
        case "captcha":
            include("../include/captcha.php");
            break;
        case "getproducts":
            include("../sql/getProducts.php");
            break;
        case "placeorder":
            include("../sql/placeOrder.php");
            break;
        case "getorders":
            include("../sql/om.getOrders.php");
            break;
        case "getorderdetails":
            include("../sql/om.getOrderDetails.php");
            break;
        case "updateorder":
            include("../sql/om.updateStatus.php");
            break;
        case "sendmail":
            include("communication/mailClientConfirmation.php");
            break;
        case "checkcancelinterval":
            include("../sql/checkCancelInterval.php");
            break;
        case "cancelorder":
            include("../sql/clientCancel.php");
            break;
        case "getStopStatus":
            include("../sql/getStopStatus.php");
            break;
        case "stop":
            include("../sql/stop.php");
            break;
    }
} catch (PDOException $e) {
    echo "204" . "\n" . $e->getMessage() . "\n\n";
}
