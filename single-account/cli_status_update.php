#!/usr/bin/php
<?php
// OAuth Examples for Twitter
// by Scott Wilcox <scott@dor.ky> http://dor.ky @dordotky
// http://dor.ky/code/oauth-examples
// https://github.com/dordotky/oauth-twitter-examples
//
// This script can be ran via CLI, usage:
// ./cli_status_update.php "this is my test update text!"
//	
// First, require the excellent twitter-async library by Jaisen Mathai. You can read
// more about this library at https://github.com/jmathai/twitter-async
require "../twitter-async/EpiCurl.php";
require "../twitter-async/EpiOAuth.php";
require "../twitter-async/EpiTwitter.php";

// You need to replace the values in this file with those found in your application 
// settings. Sign in to the Twitter developer site at https://dev.twitter.com/apps and
// make a note of "Consumer Key" and "Consumer Secret" being careful not to include
// any extra spaces or text.
//
// Now click the 'My Access Token' link on the right hand menu and collect the
// "Access Token (oauth_token)" and "Access Token Secret (oauth_token_secret)"
// tokens. You're now reading to use on of the other scripts in this repository.
define("CONSUMER_KEY","K8kq7COAxSZkgbwcsdyWDQ");
define("CONSUMER_SECRET","TQpyYbJrSHUHQHWKOIWKvMQ6um8CsgPgQAUVZ8RI");
define("OAUTH_TOKEN","194052389-K5sxAwEH5bjNiOlsmU7wtB7HqWIFdhGA9vGM79kO");
define("OAUTH_TOKEN_SECRET","XVPkIns0m4darfPxqoWWVho3UxCieAOdoZ5VhLZhuN4");

// If there was a command line argument passed, we can use that as
// the status update text, else print an error out
if ($_SERVER["argv"][1]) {
	// Format text as utf8 and chomp at 140 chars
	$text = utf8_encode(substr($_SERVER["argv"][1],0,140));

	// Place all interaction within a try/catch block
	try {	
		$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
		$x = $twitterObj->post_statusesUpdate(array('status' => $text));
		if ($x->id) {
			echo "Tweet Posted: ".$x->id."\n";
		} else {
			echo "Error Posting Tweet\n";	
		}	
	} catch (Exception $error) {
		// Something failed, this will output the error message from the API
		echo $error->getMessage()."\n";
	}	
} else {
	echo "Usage: ./cli_status_update.php \"My status update goes here\"\n";
}
?>