  <?php
  
//   $emailHeaderText = "
//   Geachte Gast,

//   Uw bestelling wordt verwerkt en kan worden opgehaald op:

//   '.$pickupTime.'

//   Annuleren kan tot 30 minutenvoor de ophaaltijd via de onderstaande link
//   '. $cancelUrl . 'Klik hier om te annuleren

//   ";
//   $emailBodyText = $emailHeaderText;

//   $emailBestellingText = "
//   Uw bestelling:
//   Naam: ".$userFirstName." ". 

//   ($userPrefix !== '') ? $userPrefix . ' ' : ''

//   . $userLastName ."
//   Email: ".$userEmail. "
//   Telefoon: ".$userPhone. "
//   ";
//   $emailBodyText .= $emailBestellingText;

//   ($userComment !== '') ? $emailCommentText = 'Persoonlijke bericht: ' .$userComment. '

//     ' : $emailCommentText = '';

//   $emailBodyText .= $emailCommentText;

// for ($y = 10; $y < count($data); $y++) {

// $receiptItemsText = $data[$y]['itemQuantity'] .' x '. $data[$y]['name'].' '. $data[$y]['quantity'].' '.$data[$y]['unit'] . "\n";

//   $emailBodyText .= $receiptItemsText;
// }

//   $endTotalText = "
//   Totaal: € " . $totalPrice . " 
  
//   We gaan voor u aan de slag!";


//   $emailBodyText .= $endTotalText;