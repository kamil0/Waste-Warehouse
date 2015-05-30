<?php

require 'vendor/autoload.php';

define('BASE_URL', 'http://zcvxzxvhzxijkhvzxjkhvkzxhvkjzxhxczvzxckcvhzxvcjkzxhv.xzcvzxcvzxcv/vzsgsdfgsdfgsdfgtdsfgsdfg');

$paypal = new \PayPal\Rest\ApiContext(
	new \PayPal\Auth\OAuthTokenCredential(
		'jewsinthe',
		'watersupply'
		)
);