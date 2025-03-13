<?php
require_once('lib/init.php');
\Payplug\Payplug::setSecretKey('sk_test_d634650d8237a0ef6929a769754f775b');
include '../connexion.php';

$email = 'john.watson@example.net';
$amount = 1;
$cust_id = '42710';
$customer_id='toto';

$payment = \Payplug\Payment::create(array(
  'amount'           => $amount * 100,
  'currency'         => 'EUR',
  'billing'  => array(
    'title'        => 'mr',
    'first_name'   => 'John',
    'last_name'    => 'Watson',
    'email'        => $email,
    'address1'     => '221B Baker Street',
    'postcode'     => 'NW16XE',
    'city'         => 'London',
    'country'      => 'GB',
    'language'     => 'en'
  ),
  'shipping'  => array(
    'title'         => 'mr',
    'first_name'    => 'John',
    'last_name'     => 'Watson',
    'email'         => $email,
    'address1'      => '221B Baker Street',
    'postcode'      => 'NW16XE',
    'city'          => 'London',
    'country'       => 'GB',
    'language'      => 'en',
    'delivery_type' => 'BILLING'
  ),
  'hosted_payment'   => array(
    'return_url'     => 'https://example.net/return?id='.$cust_id,
    'cancel_url'     => 'https://example.net/cancel?id='.$cust_id
  ),
  'notification_url' => $domaine.'payplugNew/ipn.php',
  'metadata'         => array(
    'customer_id'    => $customer_id
  )
));

$payment_url = $payment->hosted_payment->payment_url;
$payment_id = $payment->id;
header('Location:' . $payment_url);
?>