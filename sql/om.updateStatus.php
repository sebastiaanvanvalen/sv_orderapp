<?php

$reqHeaders   = apache_request_headers();
$id           = $reqHeaders['orderId'];
$statusMethod = $reqHeaders['toStatus'];
$user         = $reqHeaders['user'];
$newStatus;


try {
    $stmta = $db->prepare("SELECT order_id, process_status, client_status FROM sv_app_allorders WHERE order_id = :id");
    $stmta->bindParam('id', $id);
    $stmta->execute();
    $result = $stmta->setFetchMode(PDO::FETCH_ASSOC);
    $order = $stmta->fetch();
    var_dump($order) . "\n";

    $order_id      = $order['order_id'];
    $processStatus = $order["process_status"];
    $clientStatus  = $order["client_status"];

    if ($statusMethod == 'a') {
        $newProcessStatus = ($processStatus == '0') ? '1' : '0';
        $newClientStatus = $clientStatus;
    }
    
    if ($statusMethod == 'b') {
        switch ($processStatus) {
            case '0':
                $newProcessStatus = '2';
                break;
            case '1':
                $newProcessStatus = '3';
                break;
            case '2':
                $newProcessStatus = '0';
                break;
            case '3':
                $newProcessStatus = '1';
                break;
        }
        $newClientStatus = $clientStatus;
    }


    if ($statusMethod == 'c') {
        $newClientStatus = ($clientStatus == '0') ? '1' : '0';
        $newProcessStatus = $processStatus;
    }


    $stmt = $db->prepare("UPDATE sv_app_allorders SET process_status = :newStatus  WHERE order_id = :id");
    $stmt->bindParam('newStatus', $newProcessStatus);
    $stmt->bindParam('id', $id);
    $stmt->execute();

    $stmtLog = $db->prepare("INSERT INTO sv_app_allorders_log (order_id, process_status, client_status, created_by) VALUES (:order_id, :process_status, :client_status, :created_by)");
        $stmtLog->bindParam(':order_id', $order_id );
        $stmtLog->bindParam(':process_status', $newProcessStatus);
        $stmtLog->bindParam(':client_status', $newClientStatus);
        $stmtLog->bindParam(':created_by', $user);
        $stmtLog->execute();

        echo "success";



} catch (PDOException $e) {
    echo 'update sv_all_orders went wrong:' . "\n" . $e->getMessage() . "\n\n";
}
