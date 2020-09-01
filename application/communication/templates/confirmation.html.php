<?php 

$emailBodyHtml;
$emailHeaderHtml = 
"
Beste " . $userFirstName . ",

<br/>

Uw bestelling wordt verwerkt en kan worden opgehaald op:

<br/>

<h2>" . $orderDateFin . '   om   ' . $orderTime . "</h2>

<br/>

Annuleren kan tot 30 minuten voor de ophaaltijd:

<br/>

<a href='http://localhost/testing/testsmitenvoogt/public/clientcancelpage.php?id=" . urlencode($orderIdEnc) . "'>Klik hier om te annuleren</a>

<br/><br/>

<h3>Uw bestelling:</h3>
Naam: ".$userFirstName . "<br/>
Telefoon: ".$userPhone. "<br/><br/>
";
$emailBodyHtml = $emailHeaderHtml;

$emailMessageHtml = ($userComment !== '') ? $emailCommentHtml = 'Persoonlijke bericht: ' . $userComment. '<br/><br/>' : $emailCommentText = '<br/><br/>';

$emailBodyHtml .= $emailMessageHtml;

for($y = 10; $y < count($data); $y++) {

$emailBodyHtml .= $data[$y]['itemQuantity'] .' x '. $data[$y]['name'].'  '. $data[$y]['quantity'].'  '.$data[$y]['unit'] . "
<br/>";

}

$emailEndHtml = "<br/>
 Totaal: € " . money_format("%.2n", $totalPrice) . "<br/>
<br/>

We gaan voor u aan de slag!
<br/>
<br/>
Café Smit&Voogt<br/>
Plantage Parklaan 10<br/>
1018 ST  Amsterdam<br/>
020-6254721<br/>
cafesmitenvoogt@gmail.com";

$emailBodyHtml .= $emailEndHtml;


