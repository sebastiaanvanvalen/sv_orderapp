<?php



$reqHeaders  = apache_request_headers();
$requestType = $reqHeaders["requesttype"];

if (isset($_POST)) {

    try {


        if ($requestType === "currentorders"){
            $stmt = $db->prepare("SELECT order_id, person_id, pickup_time, process_status, client_status 
            FROM sv_app_allorders 
            WHERE client_status= '0'
            AND process_status IN ('0', '1') 
            AND DATE(pickup_time) = CURDATE() 
            ORDER BY pickup_time DESC");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $orders = $stmt->fetchAll();

        }

        if ($requestType === "futureorders"){
            $stmt = $db->prepare("SELECT order_id, person_id, pickup_time , process_status, client_status 
            FROM sv_app_allorders 
            WHERE client_status= '0'
            AND process_status= '0'
            AND DATE(pickup_time) > CURDATE() 
            ORDER BY pickup_time DESC");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $orders = $stmt->fetchAll();

        }

        if ($requestType === "canceledorders"){
            $stmt = $db->prepare("SELECT order_id, person_id, pickup_time , process_status, client_status 
            FROM sv_app_allorders 
            WHERE client_status= '1'
            OR process_status IN ('2', '3') 
            AND DATE(pickup_time) >= CURDATE() 
            ORDER BY pickup_time DESC");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $orders = $stmt->fetchAll();
        }

        $toSend = array();
        
        foreach ($orders as $order) {
            $pid = $order["person_id"];
            $oid = $order["order_id"];
            $orderToSend = array();
            $itemsToSend = array();

            $personStmt = $db->prepare("SELECT firstname, prefix, lastname FROM sv_app_persons WHERE person_id= :personID");
            $personStmt->bindParam(':personID', $pid);
            $personStmt->execute();
            $personStmt->setFetchMode(PDO::FETCH_ASSOC);
            $person = $personStmt->fetchAll();

            array_push($orderToSend, $order);
            array_push($orderToSend, $person);
            array_push($toSend, $orderToSend);
        }


        echo json_encode($toSend);
        

    } catch (PDOException $e) {
        echo json_encode("error 240 please contact administrator");
        // echo "uh uh uh, you didn't say the magic word!" . "\n\n" . $e->getMessage();
    }
}
