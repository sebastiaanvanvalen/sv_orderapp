<?php 
session_start();

require("../classes/adminToken.php");
$newToken    = new adminToken();
$csrf_token  = $newToken->create();
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon-32.png" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">

    <link rel="stylesheet" href="styles/canceledorders.style.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&display=swap" rel="stylesheet">
    <title>Smit & Voogt Geannuleerde Bonnen</title>
</head>

<body>

<div class="menu">
        <button class="btn btn-primary menu-btn current">naar: huidige orders</button>
        <button class="btn btn-success menu-btn canceled">GEANNULEERDE ORDERS</button>
        <button class="btn btn-primary menu-btn future">Naar: toekomste orders</button>
    </div>


<h2>canceled orders</h2>
    <div class="main-container">

        <div class="canceled-orders cont">
            <div class="canceled-orders-wrapper">

                <div class="client-canceled-wrapper">
                    <h2>door Gast geannuleerd</h2>
                    <div class="client-canceled">
                    </div>
                </div>
                <div class="cafe-canceled-wrapper">
                    <h2>door S&V geannuleerd</h2>
                    <div class="cafe-canceled">
                    </div>
                </div>

            </div>

        </div>
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

        <script src="scripts/om.nav.js" type="module"></script>
        <script src="scripts/om.stop.js"></script>
        <script src="scripts/getCanceledOrders.js" type="module"></script>
</body>


</html>