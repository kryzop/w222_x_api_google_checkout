<?php

# Sending Order Information to Google Checkout
# https://google-developers.appspot.com/checkout/developer/Google_Checkout_HTML_API#create_checkout_cart
# > Option A: Configure your form to submit directly to Google Checkout

require 'config.php';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<title>Google Checkout: Client to Server</title>
</head>
<body>

<?php if (false): ?>
<?php # ?>
<?php # Validating API Requests ?>
<?php # https://developers.google.com/checkout/developer/Google_Checkout_HTML_API#validating_api_requests ?>
<?php # This is not working with browse since Google returns ?>
<?php # HTTP/1.1 400 Bad Request ?>
<?php # ?>
<?php # > HTTP/1.1 400 Bad Request ?>
<?php # > Content-Type: application/x-www-form-urlencoded; charset=US-ASCII ?>
<?php # > Transfer-Encoding: chunked ?>
<?php # > Date: Sat, 18 May 2013 14:37:46 GMT ?>
<?php # > Expires: Sat, 18 May 2013 14:37:46 GMT ?>
<?php # > Cache-Control: private, max-age=0 ?>
<?php # > X-Content-Type-Options: nosniff ?>
<?php # > X-Frame-Options: SAMEORIGIN ?>
<?php # > X-XSS-Protection: 1; mode=block ?>
<?php # > Set-Cookie: S=payments_api=-gte5qlW7_LA-XlCRPx6aA; Expires=Sat, 18-May-2013 15:07:46 GMT; Path=/; Secure; HttpOnly ?>
<?php # > Server: GSE ?>
<?php # >  ?>
<?php # > _type=error&error-message=Carts+must+contain+at+least+one+item.&serial-number=f5ac5f77-d75e-4d7f-bc7b-dfd83abbe97a ?>
<form action="<?php echo $config['endpoint'] ?>/api/checkout/v2/checkoutForm/Merchant/<?php echo $config['merchant_id'] ?>/diagnose" method="POST">
<?php else: ?>
<?php # Posting API Requests to Google ?>
<?php # https://developers.google.com/checkout/developer/Google_Checkout_HTML_API#urls_for_posting ?>
<form action="<?php echo $config['endpoint'] ?>/api/checkout/v2/checkoutForm/Merchant/<?php echo $config['merchant_id'] ?>" method="POST">
<?php endif ?>

	<?php # HTML API Short Attribute Names ?>
	<?php # https://developers.google.com/checkout/developer/Google_Checkout_Basic_HTML_How_Checkout_Works#short_names ?>
	<input type="hidden" name="item_name_1" value="ITEM_NAME">
	<input type="hidden" name="item_description_1" value="ITEM_DESCRIPTION">
	<input type="hidden" name="item_quantity_1" value="1">
	<input type="hidden" name="item_price_1" value="10.00">
	<input type="hidden" name="item_currency_1" value="USD">
	<input type="hidden" name="item_merchant_id_1" value="INVOICE_123">

	<?php # Shopping Cart Input Fields ?>
	<?php # https://developers.google.com/checkout/developer/Google_Checkout_Basic_HTML_How_Checkout_Works#Cart_Input_Fields ?>
	<input type="hidden" name="edit_url" value="http://home/debug/index.php?action=edit">
	<input type="hidden" name="continue_url" value="http://home/debug/index.php?action=continue">

	<?php # mark an item as *digital* (no shipping required) ?>

	<?php # HTML API Parameter Reference ?>
	<?php # https://developers.google.com/checkout/developer/Google_Checkout_HTML_API_Parameter_Reference ?>
	<input type="hidden" name="shopping-cart.items.item-1.digital-content.display-disposition" value="OPTIMISTIC">
	<input type="hidden" name="shopping-cart.items.item-1.digital-content.description" value="Maecenas pretium, turpis non blandit pretium, nunc mauris fringilla mauris, ut tristique nibh nisi non erat. Suspendisse potenti. Quisque sodales mauris quis sapien sodales eu viverra lorem dignissim. Nunc tincidunt congue dapibus. Curabitur accumsan lacinia magna sed convallis. Maecenas eu ornare magna. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In feugiat porta tortor non iaculis. Fusce pretium euismod justo, eget accumsan lectus fermentum eu. Integer id sapien diam. Vestibulum tristique dictum mi nec posuere. Phasellus nec erat sit amet nunc viverra laoreet. In id orci erat, non consequat ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur rhoncus tempor massa quis aliquam. Etiam nibh erat, sodales a malesuada eu, mattis quis mauris.">

	<?php # Google Checkout Buttons ?>
	<?php # https://google-developers.appspot.com/checkout/developer/Google_Checkout_HTML_API#google_checkout_buttons ?>
	<?php # ?>
	<?php # Google Checkout Button URL Generator ?>
	<?php # https://google-developers.appspot.com/checkout/developer/checkout_button_url_generator ?>
	<input type="image" src="<?php echo $config['endpoint'] ?>/buttons/checkout.gif?merchant_id=<?php echo $config['merchant_id'] ?>&w=180&h=46&style=white&variant=text&loc=en_US" width="180" height="46">

</form>

</body>
</html>
