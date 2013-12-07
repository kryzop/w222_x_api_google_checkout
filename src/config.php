<?php

# Create Sandbox Merchant and Buyer Accounts
# https://google-developers.appspot.com/checkout/developer/Google_Checkout_Basic_HTML_Sandbox#Create_Sandbox_Accounts

$config = array();

# Integration Settings
# https://sandbox.google.com/checkout/sell/settings?section=Integration
# > email: clarance.brott@gmail.com
$config['merchant_id'] = 'xxxxxxxxxxxxxxxxxxxxxxxxx';
$config['merchant_key'] = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx';

# Posting API Requests to Google
# https://google-developers.appspot.com/checkout/developer/Google_Checkout_HTML_API#urls_for_posting
#
# Submitting Requests to the Sandbox
# https://developers.google.com/checkout/developer/Google_Checkout_Basic_HTML_Sandbox#Submitting_Requests_to_the_Sandbox
$config['endpoint'] = 'https://checkout.google.com'; # live
$config['endpoint'] = 'https://sandbox.google.com/checkout'; # sandbox

require 'config.private.php';
