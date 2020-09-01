<?php 
session_start();

require("../classes/clientToken.php");
$newToken    = new ClientToken();
$csrf_token  = $newToken->create();


?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon-32.png" />
    
    <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
    <link rel="stylesheet" href="styles/index.style.css">
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo SITE_KEY; ?>"></script>
    
    <title>Café Smit&amp;Voogt direct Bestellen</title>
</head>

<body>

    <nav class="nav">

        <img src="images/senv.png" alt="senvlongago" class="image">

        <div class="nav-header">
            <div class="change-calendar">bestellen voor:</div>
            <div class="choices">
                <div class="vandaag choice chosen">vandaag</div>
                <div class="toekomst choice">toekomstig</div>

            </div>
            <div class="choice-warning">Als u de datum voor<br>
            het afhalen wilt veranderen<br>
        moeten uw reeds geselecteerde<br>
    producten opnieuw worden<br>
ingevoerd</div>
        </div>

        <div class="menu show">
            <p>MENU</p>
        </div>
        <div class="dropdown">
            <div class="bestellen menu-sub">
                <p>bestellen</p>
            </div>
            <div class="bestellen-content menu-sub-sub">Lunch kan dagelijks tussen 11:00uur en 16:00uur worden afgehaald<br>
            Alle andere producten kunnen tussen 11:00uur en 21:30 worden opgehaald.<br> Bestellen kan tot 30 minuten van tevoren en betalen kan zodra je de bestelling bij ons ophaalt.
                </div>
            <div class="ophalen menu-sub">
                <p>ophalen</p>
            </div>
            <div class="ophalen-content menu-sub-sub">Komt u uw bestelling ophalen:<br>
            In cafe Smit&Voogt zullen plekken aangegeven staan, waar je kan wachten. Bij de deur is de mogelijkheid<br> je handen te reinigen, we vragen iedereen steeds 1,5 meter afstand te bewaren.<br> We zullen er alles aan doen om de bestelde spullen perfect op tijd af te hebben, maar<br> een kleine wachttijd tot maximaal 5 minuten na de besteltijd zal bij drukte soms onvermijdelijk zijn. Tenslotte willen we jullie met<br> klem verzoeken, bij het buiten opeten en drinken van onze producten, deze na gebruik netjes in de prullenbak te gooien.<br>Ook bestaat de mogelijkheid het afval weer terug te brengen bij ons, dan ruimen wij het op. </div>
            <div class="contact menu-sub">
                <p>contact</p>
            </div>
            <div class="contact-content menu-sub-sub">
                <br>
                café Smit & Voogt<br>
                Plantage Parklaan 10<br>
                1018 ST Amsterdam<br><br>
                020 - 6254721<br>
                cafesmitenvoogt@gmail.com
            </div>
        </div>
    </nav>

    <div class="landingtext cat-header">U kunt tot 21:00 uur bij ons bestellen. De lunchkeuken sluit om 16:00 uur!
    </div>

    <div class="maincontent-wrapper">
    <div class="maincontent">
        <div class="lunch-header cat-header">
            <div class="lunch-cat cat">Lunch<br>
                Lunch kan alleen vóór 15:30 besteld en uiterlijk 16:00 opgehaald worden.
                <span class="lunch-text"></span>
            </div>
        </div>
        <!-- jquery-generated content -->

        <div class="warme-dranken-header cat-header">
            <div class="warme-dranken-cat cat">Warme Dranken</div>
        </div>
        <!-- jquery-generated content -->

        <div class="koude-dranken-header cat-header">
            <div class="koude-dranken-cat cat">Koude Dranken</div>
        </div>
        <!-- jquery-generated content -->

        <div class="borrel-header cat-header">
            <div class="borrel-cat cat">Borrel</div>
        </div>
        <!-- jquery-generated content -->

        <div class="bier-header cat-header">
            <div class="bier-cat cat">Bier</div>
        </div>
        <!-- jquery-generated content -->

        <div class="wijn-header cat-header">
            <div class="wijn-cat cat">Wijn</div>
        </div>
        <!-- jquery-generated content -->

        <div class="gebak-header cat-header">
            <div class="gebak-cat cat">Gebak</div>
        </div>
        <!-- jquery-generated content -->

    </div>
    </div>

    <div class="ordertotalcontainer">
        <img src="images/shoppingbasket3.jpg" alt="shoppingbasket">
        <div class="numofitems" id="numofitems">0 items</div>
        <div class="totalprice" id="totalprice">€ 0,00</div>
        <button class="btn btn-success orderbtn g-recaptcha" name="g-recaptcha-response" data-sitekey="<?php echo SITE_KEY; ?>" data-callback='onSubmit' id="orderbtn g-recaptcha-response">Bestel!</button>
    </div>

    <div class="lunch-modal modal">
        <div class="exit">
            <p>X</p>
        </div>
        <p>Let op. Dit product is dagelijks te bestellen tot 15:30 en op te halen tot uiterlijk 16:00uur. <br>Als u dit product toevoegt aan uw bestelling, moet u uw gehele bestelling uiterlijk vóór 16:00uur ophalen</p>
    </div>

    <div class="ordered-modal modal">
        <p>Uw order is geplaatst!<br>
            We gaan voor u aan de slag. U krijgt spoedig<br>
            een bevestiging per mail!<br>
            tot straks!<br><br>
            groet van S&V</p>
    </div>

    <div class="privacy-modal modal">
        Wij gebruiken uw gegevens uitsluitend om bestellingen<br>
        goed te verwerken.<br>
        Uw emailadres gebruiken we om u een bevestiging te sturen<br>
        met hierin een link zodat u de bestelling kunt cancelen<br>
        Uw telefoonnummer gebruiken we om u te bellen in geval<br>
        een bestelling aan onze kant mis gaat. <br>
        Uw opgegeven naam gebruiken we ter verificatie tijdens het<br>
        afhalen.<br>
        We gebruiken de google reCAPTCHA service om onze website<br>
        te beveiligen tegen bots. De voorwaarden van Google vindt u op<br>
        <a href="https://www.https://policies.google.com/terms?hl=nl">Google reCAPTCHA v3</a>
        <br>
        <button class="btn btn-warning close-privacy-modal">Sluit</button>
    </div>

    <div class="no-products-modal modal">
        <h2>Helaas kunnen we op dit moment geen orders opnemen. Excuus voor het ongemak. Er wordt gewerkt aan een oplossing. Probeer het later nog eens.</h2>
    </div>

    <div class="check">
        <img src="images/senv.png" alt="#" class="image">
        <p class="check-text">- rekening -</p>
        <div class="check-items-container">

        </div>
        <div class="total-price-container">
            <div class="total-price">
                <div class="tax">
                    <div class="tax-high"></div>
                    <div class="tax-low"></div>
                </div>
                <div class="price"></div>
            </div>
        </div>

        <div class="form-container">

            <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


                <div class="time-wrapper">
                    <div class="text">Uw ophaaltijd:</div>
                    <div class="time-details">
                        <label>
                            <input placeholder="Selecteer moment...*" class="date">
                        </label>
                    </div>
                </div>


                <div class="name-wrapper">
                    <input type="text" name="firstname" class="firstname form-control" max="20" placeholder="voornaam*" required>
                    <input type="text" name="prefix" class="prefix form-control" max="10" placeholder="tussenv">
                    <input type="text" name="lastname" class="lastname form-control" max="20" placeholder="achternaam">
                </div>

                <div class="detail-wrapper">
                    <input type="tel" name="phone" class="phone form-control" max="20" placeholder="telefoon*" require>
                    <input type="email" name="email" class="email form-control" placeholder="email*" required>
                </div>

                <textarea name="comment" name="text" class="text-area form-control" cols="30" rows="2" max="50" placeholder="Opmerkingen / Toelichting"></textarea>
                <div class="privacy">wat doen we met uw gegevens?</div>
                <div class="form-submit">
                    <button class="btn btn-info btn-sm go-back">terug</button>
                    <input type="submit" name="submit" value="Plaats Bestelling" class="btn btn-success btn-sm submit-btn">
                </div>

            </form>

        </div>
        <br>
        <div class="closing-text">Fijne dag!<br>
            - S&V -</div>

    </div>

    <input type="hidden" class="csrf_token" id="csrf_token" name="csrf_token" value="<?php echo $csrf_token ?>">
    
    <footer class="footer">SvV &copy; 2020</footer>

    <script src="scripts/nav.js" type="module"></script>
    <script src="scripts/getProducts.js" type="module"></script>

    <!-- captcha script -->
    <!-- <script>
        function onSubmit() {
            let csrf_token = $(".csrf_token").val();
            grecaptcha.ready(function() {
                grecaptcha.execute('<?php // echo SITE_KEY; ?>', {
                    action: 'submit',

                }).then(function(token) {
                    $.ajax({
                            type: 'GET',
                            url: '../application/include/captcha.php',
                            headers: {
                                'Authorization': 'Bearer ' + csrf_token,
                                'switchkey': 'captcha',
                                'key': token
                            },
                        })
                        .done(function(data) {
                            // console.log(data);
                        })
                        .fail(function() {
                            alert("captcha failed");
                        })
                })
            })
        }
    </script> -->

</body>



</html>

