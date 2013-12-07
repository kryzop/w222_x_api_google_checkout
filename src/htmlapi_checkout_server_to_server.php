<?php

# Sending Order Information to Google Checkout
# https://google-developers.appspot.com/checkout/developer/Google_Checkout_HTML_API#create_checkout_cart
# > Option B: Submit a Server-to-Server Checkout API Request

require 'config.php';

$order = require 'order.php';

# setup
$param = array();
# _type
# https://developers.google.com/checkout/developer/Google_Checkout_HTML_API_Parameter_Reference#tag_HTMLRequestTypeParameter
$param['_type'] = 'checkout-shopping-cart';

# order, billing, shipping, and tax
$param = google_checkout_add_order($param, $order);
if (isset($order['billing'])) {
	$param = google_checkout_add_billing($param, $order);
}
if (isset($order['shipping'])) {
	$param = google_checkout_add_shipping($param, $order);
}
if (isset($order['tax'])) {
	$param = google_checkout_add_tax($param, $order);
}

function google_checkout_add_order($param, $order)
{
	# HTML API Parameter Reference
	# https://developers.google.com/checkout/developer/Google_Checkout_HTML_API_Parameter_Reference

	# <item>
	# https://developers.google.com/checkout/developer/Google_Checkout_XML_API_Tag_Reference#tag_item
	$param['shopping-cart.items.item-1.merchant-item-id'] = $order['id'];
	$param['shopping-cart.items.item-1.item-name'] = $order['title'];
	$param['shopping-cart.items.item-1.item-description'] = $order['description'];
	$param['shopping-cart.items.item-1.quantity'] = 1;
	$param['shopping-cart.items.item-1.unit-price'] = $order['amount'];
	$param['shopping-cart.items.item-1.unit-price.currency'] = $order['currency'];

	# Mark an item as *digital* (no shipping required)

	# <digital-content>
	# https://developers.google.com/checkout/developer/Google_Checkout_XML_API_Tag_Reference#tag_digital-content
	$param['shopping-cart.items.item-1.digital-content.display-disposition'] = 'OPTIMISTIC';
	$param['shopping-cart.items.item-1.digital-content.description'] = 'Maecenas pretium, turpis non blandit pretium, nunc mauris fringilla mauris, ut tristique nibh nisi non erat. Suspendisse potenti. Quisque sodales mauris quis sapien sodales eu viverra lorem dignissim. Nunc tincidunt congue dapibus. Curabitur accumsan lacinia magna sed convallis. Maecenas eu ornare magna. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In feugiat porta tortor non iaculis. Fusce pretium euismod justo, eget accumsan lectus fermentum eu. Integer id sapien diam. Vestibulum tristique dictum mi nec posuere. Phasellus nec erat sit amet nunc viverra laoreet. In id orci erat, non consequat ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur rhoncus tempor massa quis aliquam. Etiam nibh erat, sodales a malesuada eu, mattis quis mauris.';
	return $param;
}

function google_checkout_add_billing($param, $order)
{
/*
	# <billing-address>
	# https://developers.google.com/checkout/developer/Google_Checkout_XML_API_Tag_Reference#tag_billing-address

		'first_name' => 'Janet',
		'last_name' => 'Cruz',
		'country_code' => 'US',
		'state_code' => 'IL',
		'province' => '',
		'city' => 'Oak Brook',
		'zip_code' => '60523',
		'address' => '2796 Steele Street',
		'address2' => '1st Flat',
		'company' => '',
		'phone' => '630-634-1799',
		'email' => 'vladimir.barbarosh@gmail.com',

	$param['address1']
	$param['address2']

	contact-name
	country-code
	region
	city
	postal-code
	address1
	address2
	company-name
	phone
	fax
	email
*/
	return $param;
}

function google_checkout_add_shipping($param, $order)
{
	$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-1.name'] = $order['shipping']['title'];
	$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-1.price'] = $order['shipping']['amount'];

	unset($param['shopping-cart.items.item-1.digital-content.display-disposition']);
	unset($param['shopping-cart.items.item-1.digital-content.description']);

$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-1.name'] = 'UPS Next Day Air';
$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-1.price'] = 20.00;
$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-1.price.currency'] = 'USD';

$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-2.name'] = 'UPS Ground';
$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-2.price'] = 15.00;
$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-2.price.currency'] = 'USD';

$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.pickup-1.name'] = 'Pickup';
$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.pickup-1.price'] = 5.00;
$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.pickup-1.price.currency'] = 'USD';

$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-3.name'] = 'Delivery';
$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-3.price'] = 0.00;
$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-3.currency'] = 'USD';
$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-3.shipping-restrictions.allowed-areas.us-zip-area-1.zip-pattern'] = 10021;
$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-3.shipping-restrictions.allowed-areas.us-zip-area-2.zip-pattern'] = 10022;
$param['checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-3.shipping-restrictions.allowed-areas.allow-us-po-box'] = 'false';


	return $param;
}

function google_checkout_add_tax($param, $order)
{
	return $param;
}

# endpoint
$param['checkout-flow-support.merchant-checkout-flow-support.edit-cart-url'] = 'http://home/debug/index.php?action=edit';
$param['checkout-flow-support.merchant-checkout-flow-support.continue-shopping-url'] = 'http://home/debug/index.php?action=continue';

# $param = array();
# 
# # _type
# # https://developers.google.com/checkout/developer/Google_Checkout_HTML_API_Parameter_Reference#tag_HTMLRequestTypeParameter
# $param['_type'] = 'checkout-shopping-cart';
# 
# # XXX It seems that short attribute names are not supported by
# # XXX *server to server* method
# # XXX
# # XXX # # HTML API Short Attribute Names
# # XXX # # https://developers.google.com/checkout/developer/Google_Checkout_Basic_HTML_How_Checkout_Works#short_names
# # XXX # $param['item_name_1'] = 'ITEM_NAME';
# # XXX # $param['item_description_1'] = 'ITEM_DESCRIPTION';
# # XXX # $param['item_quantity_1'] = '1';
# # XXX # $param['item_price_1'] = '10.00';
# # XXX # $param['item_currency_1'] = 'USD';
# # XXX # $param['item_merchant_id_1'] = 'INVOICE_123';
# # XXX #
# # XXX # # Shopping Cart Input Fields
# # XXX # # https://developers.google.com/checkout/developer/Google_Checkout_Basic_HTML_How_Checkout_Works#Cart_Input_Fields
# # XXX # $param['edit_url'] = 'http://home/debug/index.php?action=edit';
# # XXX # $param['continue_url'] = 'http://home/debug/index.php?action=continue';
# 
# # Order
# $param['shopping-cart.items.item-1.item-name'] = $order_title;
# $param['shopping-cart.items.item-1.item-description'] = $order_description;
# $param['shopping-cart.items.item-1.quantity'] = '1';
# $param['shopping-cart.items.item-1.unit-price'] = $order_amount;
# $param['shopping-cart.items.item-1.unit-price.currency'] = $order_currency;
# $param['shopping-cart.items.item-1.merchant-item-id'] = $order_id;
# 
# 
# # Mark an item as *digital* (no shipping required)
# $param['shopping-cart.items.item-1.digital-content.display-disposition'] = 'OPTIMISTIC';
# $param['shopping-cart.items.item-1.digital-content.description'] = 'Maecenas pretium, turpis non blandit pretium, nunc mauris fringilla mauris, ut tristique nibh nisi non erat. Suspendisse potenti. Quisque sodales mauris quis sapien sodales eu viverra lorem dignissim. Nunc tincidunt congue dapibus. Curabitur accumsan lacinia magna sed convallis. Maecenas eu ornare magna. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In feugiat porta tortor non iaculis. Fusce pretium euismod justo, eget accumsan lectus fermentum eu. Integer id sapien diam. Vestibulum tristique dictum mi nec posuere. Phasellus nec erat sit amet nunc viverra laoreet. In id orci erat, non consequat ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur rhoncus tempor massa quis aliquam. Etiam nibh erat, sodales a malesuada eu, mattis quis mauris.';

$curl = curl_init();

if (false) {
	# Validating API Requests
	# https://developers.google.com/checkout/developer/Google_Checkout_HTML_API#validating_api_requests
	curl_setopt($curl, CURLOPT_URL, $config['endpoint'].'/api/checkout/v2/requestForm/Merchant/'.$config['merchant_id'].'/diagnose');
}
else {
	# Sending API Requests with HTTP Basic Authentication
	# https://google-developers.appspot.com/checkout/developer/Google_Checkout_HTML_API#https_auth_scheme
	curl_setopt($curl, CURLOPT_URL, $config['endpoint'].'/api/checkout/v2/requestForm/Merchant/'.$config['merchant_id']);
}
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($param));
# Sending API Requests with HTTP Basic Authentication
# https://google-developers.appspot.com/checkout/developer/Google_Checkout_HTML_API#https_auth_scheme
curl_setopt($curl, CURLOPT_USERPWD, $config['merchant_id'].':'.$config['merchant_key']);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
$errno = curl_errno($curl);
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($errno == 0 && $code == 200) {
	parse_str($response, $a);
	$a = array_map('urldecode', $a);
	switch ($a['_type']) {
	case 'checkout-redirect':
		header('Location: '.$a['redirect-url']);
		exit;
	case 'form-diagnosis':
		break;
	}
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
# int(503)
#
# $response
# string(949) "<!DOCTYPE html>
# <html lang=en>
#   <meta charset=utf-8>
#   <meta name=viewport content="initial-scale=1, minimum-scale=1, width=device-width">
#   <title>Error 503 (Server Error)!!1</title>
#   <style>
#     *{margin:0;padding:0}html,code{font:15px/22px arial,sans-serif}html{background:#fff;color:#222;padding:15px}body{margin:7% auto 0;max-width:390px;min-height:180px;padding:30px 0 15px}* > body{background:url(//www.google.com/images/errors/robot.png) 100% 5px no-repeat;padding-right:205px}p{margin:11px 0 22px;overflow:hidden}ins{color:#777;text-decoration:none}a img{border:0}@media screen and (max-width:772px){body{background:none;margin-top:0;max-width:none;padding-right:0}}
#   </style>
#   <a href=//www.google.com/><img src=//www.google.com/images/errors/logo_sm.gif alt=Google></a>
#   <p><b>503.</b> <ins>That’s an error.</ins>
#   <p>The service you requested is not available at this time.<p>Service error -27.  <ins>That’s all we know.</ins>
# "

# $errno
# int(0)
#
# $code
# int(400)
#
# $response
# string(157) "_type=error&error-message=Error+parsing+XML%3B+message+from+parser+is%3A+Invalid+value+for+_type%3A+null&serial-number=0801da04-3776-4cfe-8f72-4efd32c6e970
# "
#	_type=error
#	error-message=Error parsing XML; message from parser is: Invalid value for _type: null
#	serial-number=0801da04-3776-4cfe-8f72-4efd32c6e970

# $errno
# int(0)
#
# $code
# int(200)
#
# $response
# string(198) "_type=checkout-redirect&redirect-url=https%3A%2F%2Fsandbox.google.com%2Fcheckout%2Fview%2Fbuy%3Fo%3Dshoppingcart%26shoppingcart%3D928866108620215&serial-number=aa4ab978-2c88-447a-b8b0-75cb704c681a
# "
#	_type=checkout-redirect
#	redirect-url=https://sandbox.google.com/checkout/view/buy?o=shoppingcart&shoppingcart=928866108620215
#	serial-number=aa4ab978-2c88-447a-b8b0-75cb704c681a

# $errno
# int(0)
#
# $code
# int(200)
#
# $response
# string(1920) "_type=form-diagnosis&request.checkout-shopping-cart.checkout-flow-support.merchant-checkout-flow-support.continue-shopping-url=http%3A%2F%2Fhome%2Fdebug%2Findex.php%3Faction%3Dcontinue&request.checkout-shopping-cart.checkout-flow-support.merchant-checkout-flow-support.edit-cart-url=http%3A%2F%2Fhome%2Fdebug%2Findex.php%3Faction%3Dedit&request.checkout-shopping-cart.shopping-cart.items.item-1.digital-content.display-disposition=OPTIMISTIC&request.checkout-shopping-cart.shopping-cart.items.item-1.digital-content.description=Maecenas+pretium%2C+turpis+non+blandit+pretium%2C+nunc+mauris+fringilla+mauris%2C+ut+tristique+nibh+nisi+non+erat.+Suspendisse+potenti.+Quisque+sodales+mauris+quis+sapien+sodales+eu+viverra+lorem+dignissim.+Nunc+tincidunt+congue+dapibus.+Curabitur+accumsan+lacinia+magna+sed+convallis.+Maecenas+eu+ornare+magna.+Class+aptent+taciti+sociosqu+ad+litora+torquent+per+conubia+nostra%2C+per+inceptos+himenaeos.+In+feugiat+porta+tortor+non+iaculis.+Fusce+pretium+euismod+justo%2C+eget+accumsan+lectus+fermentum+eu.+Integer+id+sapien+diam.+Vestibulum+tristique+dictum+mi+nec+posuere.+Phasellus+nec+erat+sit+amet+nunc+viverra+laoreet.+In+id+orci+erat%2C+non+consequat+ipsum.+Lorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.+Curabitur+rhoncus+tempor+massa+quis+aliquam.+Etiam+nibh+erat%2C+sodales+a+malesuada+eu%2C+mattis+quis+mauris.&request.checkout-shopping-cart.shopping-cart.items.item-1.item-description=ITEM_DESCRIPTION&request.checkout-shopping-cart.shopping-cart.items.item-1.quantity=1&request.checkout-shopping-cart.shopping-cart.items.item-1.unit-price=10.0&request.checkout-shopping-cart.shopping-cart.items.item-1.unit-price.currency=USD&request.checkout-shopping-cart.shopping-cart.items.item-1.item-name=ITEM_NAME&request.checkout-shopping-cart.shopping-cart.items=request.checkout-shopping-cart.shopping-cart.items.item-1&serial-number=a7aee42d-0235-44bc-ab6b-4e87ae08878e
# "
#	_type=form-diagnosis
#	request.checkout-shopping-cart.checkout-flow-support.merchant-checkout-flow-support.continue-shopping-url=http://home/debug/index.php?action=continue
#	request.checkout-shopping-cart.checkout-flow-support.merchant-checkout-flow-support.edit-cart-url=http://home/debug/index.php?action=edit
#	request.checkout-shopping-cart.shopping-cart.items.item-1.digital-content.display-disposition=OPTIMISTIC
#	request.checkout-shopping-cart.shopping-cart.items.item-1.digital-content.description=Maecenas pretium, turpis non blandit pretium, nunc mauris fringilla mauris, ut tristique nibh nisi non erat. Suspendisse potenti. Quisque sodales mauris quis sapien sodales eu viverra lorem dignissim. Nunc tincidunt congue dapibus. Curabitur accumsan lacinia magna sed convallis. Maecenas eu ornare magna. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In feugiat porta tortor non iaculis. Fusce pretium euismod justo, eget accumsan lectus fermentum eu. Integer id sapien diam. Vestibulum tristique dictum mi nec posuere. Phasellus nec erat sit amet nunc viverra laoreet. In id orci erat, non consequat ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur rhoncus tempor massa quis aliquam. Etiam nibh erat, sodales a malesuada eu, mattis quis mauris.
#	request.checkout-shopping-cart.shopping-cart.items.item-1.item-description=ITEM_DESCRIPTION
#	request.checkout-shopping-cart.shopping-cart.items.item-1.quantity=1
#	request.checkout-shopping-cart.shopping-cart.items.item-1.unit-price=10.0
#	request.checkout-shopping-cart.shopping-cart.items.item-1.unit-price.currency=USD
#	request.checkout-shopping-cart.shopping-cart.items.item-1.item-name=ITEM_NAME
#	request.checkout-shopping-cart.shopping-cart.items=request.checkout-shopping-cart.shopping-cart.items.item-1
#	serial-number=a7aee42d-0235-44bc-ab6b-4e87ae08878e
