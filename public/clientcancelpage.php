<?php
require("../config/define.php");
require("../config/db.php");
include("../classes/ClientCancelToken.php");
include("../classes/Cryptograph.php");
$cryptograph = new Cryptograph(CRYPTO_KEY);
$newToken    = new ClientCancelToken();
$csrf_token  = $newToken->create();

$idFromUrl   = $cryptograph->decryptValue($_GET['id']);

try{
    $stmt   = $db->prepare("SELECT pickup_time, process_status, client_status FROM sv_app_allorders WHERE order_id = :id");
    $stmt->bindParam(':id', $idFromUrl);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $order  = $stmt->fetch();

    $pickupTime     = $order['pickup_time'];
    $processStatus  = $order['process_status'];
    $clientStatus   = $order['client_status'];
    $pickupDate     = date_create($pickupTime);
    date_sub($pickupDate,date_interval_create_from_date_string("30 min"));

    $date2 = new DateTime();

    if ($processStatus === "2" || $processStatus === "3" || $clientStatus === "1"){
        $mess = "2";
    }

    if ($pickupDate < $date2){
        $mess = "1";
    }

} catch (PDOException $e) {
    echo "error 234 please contact administrator";
    // echo "checking current-time against pickup-time failed... \n" . $e->getMessage() . "\n\n";
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon-32.png" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <link rel="stylesheet" href="styles/clientCancelPage.style.css">

    <title>Bestelling Annuleren</title>
</head>

<body>
    <input type="hidden" class="mess" value="<?php echo $mess ?>">
    <input type="hidden" class="order-id" value="<?php echo $idFromUrl ?>">
    <input type="hidden" class="order-id-enc" value="<?php echo $_GET['id'] ?>">
    <input type="hidden" class="csrf_token" id="csrf_token" name="csrf_token" value="<?php echo $csrf_token ?>">
    <h2>-- Smit & Voogt --</h2><br>



    <h3 class="landing-text">Weet u zeker dat u uw bestelling wilt annuleren?</h3>
    <div class="button-wrapper">
        <button class="annuleren">JA</button>

    </div>


    <div class="message-wrapper">

        <div class="cancel-succeed">
            <div class="image-wrapper">
                <img src="../public/images/senv.png" alt="cafe">
            </div>
            <h1>Uw bestelling is succesvol geannuleerd</h1>
            <p>We hopen u snel weer te zien</p>
            <div class="image-wrapper2">
                <img src="../public/images/favicon-32.png" alt="SV">
            </div>
        </div>

        <div class="cancel-confirm">
            <div class="image-wrapper">
                <img src="../public/images/senv.png" alt="cafe">
            </div>
            <h1>Uw bestelling is reeds geannuleerd!</h1>
            <div class="image-wrapper2">
                <img src="../public/images/favicon-32.png" alt="SV">
            </div>
        </div>

        <div class="cancel-fail">
            <div class="image-wrapper">
                <img src="../public/images/senv.png" alt="cafe">
            </div>
            <h1>U kunt op dit moment niet meer annuleren!</h1>
            <p>De afhaaltijd van uw bestelling ligt minder dag 30 minuten<br>
                in de toekomst. Uw bestelling wordt momenteel klaargemaakt en kan<br>
                daarom niet meer worden geannuleerd.</p>
            <div class="image-wrapper2">
                <img src="../public/images/favicon-32.png" alt="SV">
            </div>
        </div>
    </div>


</body>


<script src="scripts/clientCancelPage.js"></script>


</html>