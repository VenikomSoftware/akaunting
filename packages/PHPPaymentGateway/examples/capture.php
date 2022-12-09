<?php

use PaymentGateway\Client\Client;
use PaymentGateway\Client\Transaction\Capture;
use PaymentGateway\Client\Transaction\Result;

require_once '../initClientAutoload.php';

$client = new Client('username', 'password', 'apiKey', 'sharedSecret');

// define your transaction ID: e.g. 'myId-'.date('Y-m-d').'-'.uniqid()
$merchantTransactionId = 'C-Test-'.date('Y-m-d').'-'.uniqid(); // must be unique

$capture = new Capture();
$capture
 ->setTransactionId($merchantTransactionId)
 ->setAmount((float) $_POST['Amount'])
 ->setCurrency($_POST['Currency'])
 ->setReferenceTransactionId($_POST['refTranId']);

$result = $client->capture($capture);

$gatewayReferenceId = $result->getReferenceId(); //store it in your database

if ($result->getReturnType() == Result::RETURN_TYPE_ERROR) {
    //error handling Sample
    $error = $result->getFirstError();
    $outError = [];
    $outError['message'] = $error->getMessage();
    $outError['code'] = $error->getCode();
    $outError['adapterCode'] = $error->getAdapterCode();
    $outError['adapterMessage'] = $error->getAdapterMessage();
    header('Location: https://{HOST}/PHPPaymentGateway/examples/PaymentNOK.php?'.http_build_query($outError));
    exit;
} elseif ($result->getReturnType() == Result::RETURN_TYPE_REDIRECT) {
    //redirect the user
    header('Location: '.$result->getRedirectUrl());
    exit;
} elseif ($result->getReturnType() == Result::RETURN_TYPE_PENDING) {
    //payment is pending, wait for callback to complete

    //setCartToPending();
} elseif ($result->getReturnType() == Result::RETURN_TYPE_FINISHED) {
    //payment is finished, update your cart/payment transaction

    header('Location: https://{HOST}/PHPPaymentGateway/examples/PaymentOK.php?'.http_build_query($result->toArray()));
    exit;
    //finishCart();
}
