<?php

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

require 'res/start.php';

if (!isset($_GET['success'], $_GET['paymentId'], $_GET['PayerID'])) {
	die('Error 1: Please retry your request.');
}

if ((bool)$_GET['success'] === false) {
	die('Error 2: Payment failed. Please retry your request.');
}

$PaymentID = $_GET['paymentId'];
$PayerID = $_GET['PayerID'];

try {
	$payment = Payment::get($PaymentID, $paypal);
	$execute = new PaymentExecution();
	$execute->setPayerId($PayerID);
	$result = $payment->execute($execute, $paypal);
} catch (Exception $ex) {
	$emsg = json_decode($ex->getData());
	die('Error 3: '. $emsg->message);

}

header('Location: ' . BASE_URL . '/thanks.html');
