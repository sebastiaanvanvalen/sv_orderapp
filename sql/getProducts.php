<?php


try {

    /*
     *   stop_status 0 means products will not be loaded
     */
    
    $id = "1";
    $stmtGet = $db->prepare("SELECT stop_status from sv_app_stop WHERE id = :id");
    $stmtGet->bindParam(':id', $id);
    $stmtGet->execute();
    $result  = $stmtGet->setFetchMode(PDO::FETCH_ASSOC);
    $status = $stmtGet->fetch();

    $stopStatus = $status['stop_status'];

    if($stopStatus == '0'){


    $stmt    = $db->prepare("SELECT * FROM sv_app_allproducts WHERE active= :zero");
    $stmt->bindValue(':zero', '0');
    $stmt->execute();
    $result  = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $product = $stmt->fetchAll();

    echo json_encode($product);
    } else {
        echo "220";
    }

} catch (PDOException $e) {
    echo json_encode("221");
    // echo "221" . $e->getMessage() . "<br><br>";
}
