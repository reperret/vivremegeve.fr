<?php
$input = file_get_contents('php://input');
include '../connexion.php';
require_once('lib/init.php');
\Payplug\Payplug::setSecretKey('sk_test_d634650d8237a0ef6929a769754f775b');

try {
  $resource = \Payplug\Notification::treat($input);
  if ($resource instanceof \Payplug\Resource\Payment
    && $resource->is_paid) {
    $payment_id = $resource->id;
    $payment_state = $resource->is_paid;
    $payment_date = $resource->hosted_payment->paid_at;
    $payment_amount = $resource->amount;
    $payment_data = $resource->metadata[customer_id];
      
    
    $reqInsert = $dbh->prepare("INSERT INTO test (test) VALUES (?)");
    $reqInsert->bindParam(1, $test);
    $test=$payment_id." ".$payment_state." ".$payment_date." ".$payment_amount." ".$payment_data;
    $reqInsert->execute();
      
      
  }
}
catch (\Payplug\Exception\PayplugException $exception) {
  echo htmlentities($exception);
}
?>