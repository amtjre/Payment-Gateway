<?php
/**
 * @category    Example11 - Pay-Per-Membership (single crypto currency in payment box)
 * @package     GoUrl Cryptocurrency Payment API 
 * copyright 	(c) 2014 Delta Consultants
 * @crypto      Supported Cryptocoins -	Bitcoin, Litecoin, Dogecoin, Speedcoin, Darkcoin, Vertcoin, Reddcoin, Feathercoin, Vericoin, Potcoin
 * @website     https://gourl.io/bitcoin-payment-gateway-api.html#p6
 * @live_demo   https://gourl.io/lib/examples/pay-per-membership.php
 */ 
	
	require_once( "../cryptobox.class.php" );

	
	/**** CONFIGURATION VARIABLES ****/ 
	
	$userID 		= "-place_your_users_id-";	// place your registered userID or md5(userID) here (user1, user7, ko43DC, etc).
													// your user should have already registered on your website before   
	$userFormat		= "COOKIE";						// this variable ignored when you use $userID 
	$orderID 		= "premium_membership";			// premium membership order
	$amountUSD		= 79;							// price per membership - 79 USD
	$period			= "1 MONTH";					// one month membership; after need to pay again
	$def_language	= "en";				// default Payment Box Language
	$public_key		= "-your public key for coin box-"; // from gourl.io
	$private_key	= "-your private key for coin box-";// from gourl.io

	
	/********************************/


	
	// Optional - Language selection list for payment box (html code)
	$languages_list = display_language_box($def_language);
	
	
	/** PAYMENT BOX **/
	$options = array(
			"public_key"  => $public_key, 	// your public key from gourl.io
			"private_key" => $private_key, 	// your private key from gourl.io
			"orderID"     => $orderID, 		// order id
			"userID"      => $userID, 		// unique identifier for each your user
			"userFormat"  => $userFormat, 	// save userID in COOKIE, IPADDRESS or SESSION
			"amount"   	  => 0,				// price in coins OR in USD below
			"amountUSD"   => $amountUSD,	// we use price in USD
			"period"      => $period, 		// payment valid period
			"language"	  => $def_language  // text on EN - english, FR - french, etc
	);

	// Initialise Payment Class
	$box = new Cryptobox ($options);
	
	// coin name
	$coinName = $box->coin_name(); 
	
	
	// Successful Cryptocoin Payment received
	if ($box->is_paid())
	{
		// one time action
		if (!$box->is_processed())
		{
			// One time action after payment has been made
			// For example, Send EMAIL to user
					
			$message = "Thank you (order #".$orderID.", payment #".$box->payment_id()."). We upgraded your membership to Premium";
	
			// Set Payment Status to Processed
			$box->set_status_processed();
		}
		else $message = "You have a Premium Membership";
	}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html><head>
<title><?= $coinName ?> Pay-Per-Membership Cryptocoin Payment Example</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='Expires' content='-1'>
<meta name='robots' content='all'>
<script src='../cryptobox.min.js' type='text/javascript'></script>
</head>
<body style='font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;margin:0'>
<div align='center'>
<div style='width:100%;height:50px;line-height:50px;background-color:#f1f1f1;border-bottom:1px solid #ddd;color:#49abe9;font-size:18px;'>
	11. GoUrl <b>Pay-Per-Membership</b> Example (<?= $coinName ?> payments). Use it on your website. 
	<div style='float:right;'><a style='font-size:15px;color:#389ad8;margin-right:20px' href='https://github.com/cryptoapi/Payment-Gateway/blob/master/Examples/pay-per-membership.php'>View Source</a><a style='font-size:15px;color:#389ad8;margin-right:20px' href='<?= "//".$_SERVER["HTTP_HOST"].str_replace(".php", "-multi.php", $_SERVER["REQUEST_URI"]); ?>'>Multiple Crypto</a><a style='font-size:15px;color:#389ad8;margin-right:20px' href='https://gourl.io/<?= strtolower($coinName) ?>-payment-gateway-api.html'>Other Examples</a></div>
</div>
<br>
<h1>Example - Upgrade to a Premium Member Account</h1>
<h3>Your User already registred on your website and have free/trial account</h3>

<?php if ($box->is_paid()): ?>

	<!-- User already paid premium membership -->
	<!-- You can use this function - $box->is_paid() on all other your premium webpages, it will return true during all user paid period (1 month) --> 
	<!-- Your Premium Pages Code Here -->

	<br><br><br>
	<?= $message ?>
	<br><br><br>
	
	
<? else: ?>

	 <!-- Awaiting Payment -->
	<img alt='Awaiting Payment - Cryptocoin Pay Per Membership' border='0' src='https://gourl.io/images/example10.png'>
	<br><br><br>	
	<h3>Upgrade Your Membership Now ( $<?= $amountUSD ?> per <?= $period ?> ) - </h3>
	
<? endif; ?> 	

	<div style='font-size:12px;margin:50px 0 5px 370px'>Language: &#160; <?= $languages_list ?></div>
	<?= $box->display_cryptobox(true, 520, 230, "padding:3px 6px;margin:10px;border:10px solid #f7f5f2;") ?>

	
</div><br><br><br><br><br><br>
<div style='position:absolute;left:0;'><a target="_blank" href="http://validator.w3.org/check?uri=<?= "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"><img src="https://gourl.io/images/w3c.png" alt="Valid HTML 4.01 Transitional"></a></div>
</body>
</html>