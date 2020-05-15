<?php
require __DIR__  . '/vendor/autoload.php';

MercadoPago\SDK::setAccessToken("TEST-2868251246865916-050517-7c55f176e9c060137cf2717909a7f4e5-555090144"); // On Sandbox - Conta DS
/*
// Pagamento simples que da certo
$payment = new MercadoPago\Payment();
$payment->transaction_amount = 1000;
$payment->token = "6e3eb61f87f3ade285bb2e75fb3ce7a2";
$payment->description = "Testeasdasdas ";
$payment->installments = 1;
$payment->payment_method_id = "master";
//$payment->payment_type_id = "credit_card";
//$payment->processing_mode = "aggregator";
$payment->payer = array(
    "email" => "savioscaglioni@gmail.com"
);

$payment->save();

var_dump($payment);

echo $payment->status;
*/
// Split de pagamentos
$payment =  new MercadoPago\AdvancedPayments\AdvancedPayment();

$payment->payer = array(
      "type"=>"customer",
      "id"=>"5966618135835865",
      "email" => "savioscaglioni@gmail.com",
      "identification" => array(
         "type"=>"CPF",
         "number"=>"06645737629"
      ),
      "phone" => array(
         "area_code" => "01",
         "number" => "37999220094",
         "extension" => ""
      ),
      "first_name" => "Savio",
      "last_name" => "Rezende Scaglioni"

);
$payment->payments = array( array(
     "payment_type_id" => "credit_card",
      "payment_method_id" => "master",
      "token" => "8010558082a581b3f67c32260b9e19af",
      "transaction_amount" => 1000,
      "installments" => 1,
      "processing_mode" => "aggregator"
));
$payment->disbursements = array( array(
    "amount" => 1000,
    "external_reference" =>  "15",
    "collector_id" =>  567757313,
    "application_fee" =>  50,
    "money_release_days" =>  30
));
$payment->save();

var_dump($payment);

echo $payment->status;

exit;

$preference = new MercadoPago\Preference();

# Building an item

$item = new MercadoPago\Item();
$item->id = "00001";
$item->title = "item";
$item->quantity = 1;
$item->unit_price = 100;

$preference->items = array($item);

// Divisão de compras
$fornecedor = array(
    "amount" => 100,
    //"external_reference" => "ref-collector-1",
    "collector_id" => 2372935211036528,
    "application_fee" => 5,
    "money_release_days"=> 10
);
$preference->disbursements = array($fornecedor);

//  "external_reference": "ref-transaction"

$preference->save(); # Save the preference and send the HTTP Request to create

# Return the HTML code for button

echo "<a href='$preference->sandbox_init_point'> Pagar </a>";


