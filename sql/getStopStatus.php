<?php


try{
$id = '1';

$stmtGet = $db->prepare("SELECT stop_status from sv_app_stop WHERE id = :id");
$stmtGet->bindParam(':id', $id);
$stmtGet->execute();
$result  = $stmtGet->setFetchMode(PDO::FETCH_ASSOC);
$X = $stmtGet->fetch();
$stopStatus = $X['stop_status'];


if ($stopStatus == "1"){
    echo "status1";
} else {
    echo "status0";
}


} catch (PDOException $e) {
    echo "getting stop status went wrong... \n" . $e->getMessage() . "\n\n";
}




?>