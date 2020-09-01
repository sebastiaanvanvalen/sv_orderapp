<?php

$reqHeaders = apache_request_headers();
$orderId = $reqHeaders['id'];
$toSend = array();
$itemsToSend = array();
$orderToSend = array();



try {

    $stmt = $db->prepare("SELECT order_id, person_id, user_comment, pickup_time, total_price, tax_low, tax_high, process_status, client_status
    FROM sv_app_allorders 
    WHERE order_id = :id");
    $stmt->bindParam(":id", $orderId);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $order  = $stmt->fetchAll();

    array_push($orderToSend, $order);
    $pid = $order[0]["person_id"];


    $orderItemsStmt = $db->prepare("SELECT * 
    FROM sv_app_order_items 
    WHERE order_id = :orderID ");
    $orderItemsStmt->bindParam(':orderID', $orderId);
    $orderItemsStmt->execute();
    $orderItemsStmt->setFetchMode(PDO::FETCH_ASSOC);
    $orderItems = $orderItemsStmt->fetchAll();

    $personStmt = $db->prepare("SELECT * FROM sv_app_persons WHERE person_id= :personID");
    $personStmt->bindParam(':personID', $pid);
    $personStmt->execute();
    $personStmt->setFetchMode(PDO::FETCH_ASSOC);
    $person = $personStmt->fetchAll();

    $person[0]['email'] =  $cryptograph->decryptValue($person[0]['email']);
    $person[0]['phone'] =  $cryptograph->decryptValue($person[0]['phone']); 

    array_push($orderToSend, $person);

    foreach ($orderItems as $items) {

        $itemStmt = $db->prepare("SELECT * FROM sv_app_allproducts WHERE product_id = :product_id");
        $itemStmt->bindParam('product_id', $items['product_id']);
        $itemStmt->execute();
        $itemStmt->setFetchMode(PDO::FETCH_ASSOC);
        $item = $itemStmt->fetchAll();

        array_push($item, $items['item_quantity']);
        array_push($itemsToSend, $item);
    }
    array_push($orderToSend, $itemsToSend);
    array_push($toSend, $orderToSend);

    echo json_encode($toSend);
} catch (PDOException $e) {
    echo json_encode("error 241 please contact administrator");
    // echo "uh uh uh, you didn't say the magic word!" . "\n\n" . $e->getMessage();
}
