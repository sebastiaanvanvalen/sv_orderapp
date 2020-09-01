<?php

/*
*   stop_status 0 means products will not be loaded
*/


try{

    
$reqHeaders = apache_request_headers();
$user       = $reqHeaders['user'];
$id = '1';

$stmtGet = $db->prepare("SELECT stop_status from sv_app_stop WHERE id = :id");
$stmtGet->bindParam(':id', $id);
$stmtGet->execute();
$result  = $stmtGet->setFetchMode(PDO::FETCH_ASSOC);
$X = $stmtGet->fetch();
$stopStatus = $X['stop_status'];


if ($stopStatus == "1"){
    $newStatus = "0";
    echo "status 0 ";

    $stmt = $db->prepare("UPDATE sv_app_stop SET stop_status = :newStatus  WHERE id = :id");
    $stmt->bindParam(':newStatus', $newStatus);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // $stmtLog = $db->prepare("INSERT INTO sv_app_stop_log (new_status, created_by, create_time) VALUES (:stop_status, :created_by, SYSDATE())");
    // $stmtLog->bindParam(':stop_status', $newStatus );
    // $stmtLog->bindParam(':created_by', $user);
    // $stmtLog->execute();

} 

if ($stopStatus == "0"){
    $newStatus = "1";
    echo "status 1 ";

    $stmt = $db->prepare("UPDATE sv_app_stop SET stop_status = :newStatus  WHERE id = :id");
    $stmt->bindParam(':newStatus', $newStatus);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
           
    // $stmtLog = $db->prepare("INSERT INTO sv_app_stop_log (new_status, created_by, create_time) VALUES (:stop_status, :created_by, SYSDATE())");
    // $stmtLog->bindParam(':stop_status', $newStatus );
    // $stmtLog->bindParam(':created_by', $user);
    // $stmtLog->execute();
    
}


} catch (PDOException $e) {
    echo "STOP function is not working... \n" . $e->getMessage() . "\n\n";
}




?>