<?php

require 'config.php';

# Introduction to Google Checkout
# https://google-developers.appspot.com/checkout/developer/Google_Checkout_HTML_API#introduction
# > Merchants can choose between two types of Google Checkout
# > implementation options:
# >
# >	XML APIs enable merchants to access all Google Checkout
# >	features. XML implementations are recommended for merchants
# >	who need to be able to digitally sign orders before sending
# >	them to Google. XML implementations are also recommended for
# >	merchants who want to offer coupons or discounts and for
# >	merchants who plan to integrate Google Checkout with their
# >	internal order processing and billing systems.
# >
# >	HTML APIs enable merchants to send information to Google
# >	Checkout and receive information from Google Checkout using
# >	name/value pairs in HTML forms rather than XML. Merchants can
# >	also use the HTML API to submit name=value pairs via a
# >	server-to-server HTTP POST request. HTML implementations are
# >	particularly recommended for small merchants who do not want
# >	to generate XML. Merchants can not digitally sign orders in
# >	HTML implementations, so merchants who use this implementation
# >	and do not submit server-to-server requests should plan to
# >	review orders manually.

# Testing with curl
# https://google-developers.appspot.com/checkout/developer/Google_Checkout_XML_API#testing_with_curl

# <!-- Sell physical goods without tax and shipping -->
# <?xml version="1.0" encoding="UTF-8"? >
# <hello xmlns="http://checkout.google.com/schema/2" />

$param = '<?xml version="1.0" encoding="UTF-8"?><hello xmlns="http://checkout.google.com/schema/2" />';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $config['endpoint'].'/api/checkout/v2/request/Merchant/'.$config['merchant_id']);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
curl_setopt($curl, CURLOPT_USERPWD, $config['merchant_id'].':'.$config['merchant_key']);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
$errno = curl_errno($curl);
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($errno == 0 && $code == 200) {
	# ...
}

header('Content-Type: text/plain; charset=utf-8');

echo '$errno', PHP_EOL;
var_dump($errno);
echo PHP_EOL;

echo '$code', PHP_EOL;
var_dump($code);
echo PHP_EOL;

echo '$response', PHP_EOL;
var_dump($response);
echo PHP_EOL;

# $errno
# int(0)
# 
# $code
# int(200)
# 
# $response
# string(148) "<?xml version="1.0" encoding="UTF-8"? >
# <bye xmlns="http://checkout.google.com/schema/2" serial-number="bee91cc3-dd17-4b0e-ade6-74c2f53db366" />
# 
# "
