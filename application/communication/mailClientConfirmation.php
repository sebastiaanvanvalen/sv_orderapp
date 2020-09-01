<?php

require_once("../config/define.php");
require_once("../config/db.php");

// $cancelUrl = "smitenvoogt.int2.nl/clientcancelpage.php?id=$encryptedOrderId";
setlocale(LC_ALL, 'nl_NL'); // to config map & has server int2 dutch languagepack?
setlocale(LC_MONETARY,"nl_NL");

$orderTime    = date_format(date_create($pickupTime), "H:i") . "\n"; // gives hours + minutes
$orderDate    = date_format(date_create($pickupTime), "l-d-F") . "\n"; //  gives day+daynr+month
$orderDate    = strftime($orderDate);
$orderDateFin = strftime('%A, %d %b', $orderDate = time());
include("templates/confirmation.html.php");
include("templates/confirmation.txt.php");

try{

require dirname(dirname(dirname(__FILE__))) . '/vendor/autoload.php';

// Create the Transport
$transport = new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl');
$transport->setUsername('baxxieweb@gmail.com');
$transport->setPassword('ejkpwhgcvhrguyom');

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('bestelling bij Smit&Voogt, afhalen op: ' . $orderDateFin . " om " . $orderTime))
  ->setFrom(['appsmitenvoogt@gmail.com' => 'Café Smit & Voogt'])
  ->setTo([$userEmail => $userFirstName])
  ->setBcc('baxxieweb@gmail.com')
  ->setBody($emailBodyHtml, 'text/html')
  // ->addPart($emailBodyHtml, 'text/html')
;
// Send the message

$result = $mailer->send($message);

}catch(PDOException $e){
  echo json_encode("error 233 please contact administrator");
  // echo $e->message . "\n\n";
}