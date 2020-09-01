<?php
// require_once("../config/define.php");
// require_once("../config/db.php");


$data          = json_decode($reqHeaders['order'], true);
$orderItems    = array();

$pickupTime    = filter_var($data[0], FILTER_SANITIZE_SPECIAL_CHARS);
$userFirstName = filter_var($data[1], FILTER_SANITIZE_SPECIAL_CHARS);
$userPrefix    = filter_var($data[2], FILTER_SANITIZE_SPECIAL_CHARS);
$userLastName  = filter_var($data[3], FILTER_SANITIZE_SPECIAL_CHARS);
$userPhone     = filter_var($data[4], FILTER_SANITIZE_NUMBER_INT);
$userEmail     = filter_var($data[5], FILTER_SANITIZE_EMAIL);
$userPhoneEnc  = $cryptograph->encryptValue($userPhone);
$userEmailEnc  = $cryptograph->encryptValue($userEmail);
$userComment   = filter_var($data[6], FILTER_SANITIZE_SPECIAL_CHARS);
$totalPrice    = filter_var($data[7], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$taxLow        = filter_var($data[8], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$taxHigh       = filter_var($data[9], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

// define variables and set to empty values
// $name = $email = $gender = $comment = $website = "";

// foreach checking all $data[]'s
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   $name = test_input($_POST["name"]);

// }

// function test_input($data) {
//   $data = trim($data);
//   $data = stripslashes($data);
//   $data = htmlspecialchars($data);
//   return $data;
// }

try {

    if(empty($userFirstName) || empty($userPhone) || empty($userEmail)){
        throw new PDOException();
    }
    
    $userId = "502";
    $personStmt = $db->prepare("INSERT INTO sv_app_persons (firstname, prefix, lastname, email, phone, created_by, create_time) 
        VALUES (:firstname, :prefix, :lastname, :email, :phone, :userid, SYSDATE()) ");

    $personStmt->bindParam(':firstname', $userFirstName);
    $personStmt->bindParam(':prefix',    $userPrefix);
    $personStmt->bindParam(':lastname',  $userLastName);
    $personStmt->bindParam(':email',     $userEmailEnc);
    $personStmt->bindParam(':phone',     $userPhoneEnc);
    $personStmt->bindParam(':userid',    $userId);
    $personStmt->execute();
} catch (CustomException $e) {
    // echo json_encode("error 230 please contact administrator");
        echo $e->errorMessage();
}

try {

    $personIDStmt = $db->prepare("SELECT person_id 
        FROM sv_app_persons 
        WHERE email = :email AND create_time > SYSDATE() - INTERVAL 10 MINUTE
        ORDER BY person_id 
        DESC LIMIT 1");

    $personIDStmt->bindParam(':email', $userEmailEnc);
    $personIDStmt->execute();
    $personIDStmt->setFetchMode(PDO::FETCH_ASSOC);
    $pid = $personIDStmt->fetchAll();

    $status    = 0;

    $orderStmt = $db->prepare("INSERT INTO sv_app_allorders (person_id, user_comment, pickup_time, total_price, tax_low, tax_high, process_status, created_by, create_time) 
        VALUES (:personId, :user_comment, :pickup_time, :total_price, :tax_low, :tax_high, :orderstatus, :createdby, SYSDATE())");

    $orderStmt->bindParam(':personId',     $pid[0]['person_id']);
    $orderStmt->bindParam(':user_comment', $userComment);
    $orderStmt->bindParam(':pickup_time',  $pickupTime);
    $orderStmt->bindParam(':total_price',  $totalPrice);
    $orderStmt->bindParam(':tax_low',      $taxLow);
    $orderStmt->bindParam(':tax_high',     $taxHigh);
    $orderStmt->bindParam(':orderstatus',  $status);
    $orderStmt->bindParam(':createdby',    $userId);
    $orderStmt->execute();
} catch (PDOException $e) {
    // echo json_encode("error 231 please contact administrator");
    echo 'insert into allorders went wrong:' . "\n" . $e->getMessage() . "\n\n";
}


try {

    $orderIdStmt = $db->prepare("SELECT order_id 
        FROM sv_app_allorders 
        WHERE person_id = :personId AND create_time > SYSDATE() - INTERVAL 10 MINUTE
        ORDER BY order_id DESC LIMIT 1");

    $orderIdStmt->bindParam(':personId', $pid[0]['person_id']);
    $orderIdStmt->execute();
    $orderIdStmt->setFetchMode(PDO::FETCH_ASSOC);
    $oid        = $orderIdStmt->fetchAll();
    $orderId    = $oid[0]['order_id'];
    $orderIdEnc = $cryptograph->encryptValue(strval($orderId));


    for ($x = 10; $x < count($data); $x++) {

        $prdid = filter_var($data[$x]['id'], FILTER_SANITIZE_NUMBER_INT);
        $pquan = filter_var($data[$x]['itemQuantity'], FILTER_SANITIZE_NUMBER_INT);
        $orderRegelStmt = $db->prepare("INSERT INTO sv_app_order_items(order_id, product_id, item_quantity, created_by, create_time) VALUES (:order_id, :product_id, :item_quantity, :created_by, SYSDATE())");
        $orderRegelStmt->bindParam(':order_id',      $orderId);
        $orderRegelStmt->bindParam(':product_id',    $prdid);
        $orderRegelStmt->bindParam(':item_quantity', $pquan);
        $orderRegelStmt->bindParam(':created_by',    $userId);
        $orderRegelStmt->execute();
    }

    // Take orderId for encryption and add it to link for canceloption
    include('../application/communication/mailClientConfirmation.php');


} catch (PDOException $e) {
    // echo json_encode("error 232 please contact administrator");
    echo 'getting product(s) went wrong:' . "\n" . $e->getMessage() . "\n\n";
}
