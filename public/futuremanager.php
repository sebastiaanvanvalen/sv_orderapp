<?php
session_start();

require("../classes/adminToken.php");
$newToken = new adminToken();
$csrf_token  = $newToken->create(); ?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon-32.png" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">

    <link rel="stylesheet" href="styles/futureorders.style.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&display=swap" rel="stylesheet">
    <title>Smit & Voogt Future Orders</title>
</head>

<body>

    <div class="menu">
        <button class="btn btn-primary menu-btn current">Naar: huidige Orders</button>
        <button class="btn btn-primary menu-btn canceled">Naar: geannuleerde Orders</button>
        <button class="btn btn-success menu-btn future">TOEKOMSTIGE ORDERS</button>
    </div>


    <div class="main-container">
        <div class="future-orders cont"></div>
    </div>

    <div class="order-modal">
        <div class="order-wrapper"></div>
        <button class="btn-secondary hide-btn">Klik weg</button>
    </div>

    <div class="stop">
        <div class="stop-text">STOP</div>
    </div>

    <div class="stop-modal">
        LET OP!<br>
        HET BESTELPROCES IS ONDERBROKEN<br>
        OP DIT MOMENT KUNNEN GASTEN NIET BESTELLEN<br>
        VIA DE WEBSITE!<br>
    </div>
    
    <footer class="footer">SvV &copy; 2020</footer>
    
    <input type="hidden" class="csrf_token" id="csrf_token" name="csrf_token" value="<?php echo $csrf_token ?>">

    <script src="scripts/om.stop.js" type="module"></script>
    <script src="scripts/om.nav.js" type="module"></script>
    <script src="scripts/getFutureOrders.js"></script>
</body>


</html>