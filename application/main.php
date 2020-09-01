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

include("../classes/");
include("../classes/");
include("../classes/");

$tokenHandler = new TokenHandler();
$tokenHandler->chooseType($reqHeaders['tokenType'], $reqHeaders['Authorization']);
$cryptograph  = new Cryptograph(CRYPTO_KEY);

try {
    switch ($reqHeaders['switchkey']) {
        case "":
            include("../include/captcha.php");
            break;
        case "":
            include("../sql/getProducts.php");
            break;
        case "":
            include("../sql/placeOrder.php");
            break;
        case "":
            include("../sql/om.getOrders.php");
            break;
        case "":
            include("../sql/om.getOrderDetails.php");
            break;
        case "":
            include("../sql/om.updateStatus.php");
            break;
        case "":
            include("communication/mailClientConfirmation.php");
            break;
        case "":
            include("../sql/checkCancelInterval.php");
            break;
        case "":
            include("../sql/clientCancel.php");
            break;
        case "":
            include("../sql/getStopStatus.php");
            break;
        case "":
            include("../sql/stop.php");
            break;
    }
} catch (PDOException $e) {
    echo "204" . "\n" . $e->getMessage() . "\n\n";
}
