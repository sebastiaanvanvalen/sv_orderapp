<?php

$orderId    = $cryptograph->decryptValue($reqHeaders['idforcancel']);

try{
    $user = "502";
    $newClientStatus = '1';

    $stmt = $db->prepare("UPDATE sv_app_allorders SET client_status = :client_status, changed_by = :changed_by, change_time = SYSDATE() WHERE order_id = :id");
        $stmt->bindParam(':client_status', $newClientStatus);
        $stmt->bindParam(':changed_by', $user);
        $stmt->bindParam(':id', $orderId);
        $stmt->execute();

    $stmtLog = $db->prepare("INSERT INTO sv_app_allorders_log (order_id, client_status, created_by, create_time) VALUES (:order_id, :client_status, :created_by, SYSDATE())");
        $stmtLog->bindParam(':order_id', $orderId );
        $stmtLog->bindParam(':client_status', $newClientStatus);
        $stmtLog->bindParam(':created_by', $user);
        $stmtLog->execute();


} catch (PDOException $e) {
    // echo json_encode("error 235 please contact administrator");
    echo "Canceling order by client went wrong: \n" . $e->getMessage() . "\n\n";
}