<?php
// OAuth Examples for Twitter
// by Scott Wilcox <scott@dor.ky> http://dor.ky @dordotky
// http://dor.ky/code/oauth-examples
// https://github.com/dordotky/oauth-twitter-examples
//
// Fire off multiple calls to the Twitter API in parellel.
//	
// First, require the excellent twitter-async library by Jaisen Mathai. You can read
// more about this library at https://github.com/jmathai/twitter-async
require "../library/EpiCurl.php";
require "../library/EpiOAuth.php";
require "../library/EpiTwitter.php";

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

// The array we're going to hold user data in
$users = array();

// An array of user screen names that we're going to pull information for
$screen_names = array("ochocinco","johncusack","andersoncooper","nytimesfood","theflaminglips","kinseyinstitute");

// Place all interaction within a try/catch block
try {
	// Send the request off to get the authenticated users favourited tweets
	$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);

	foreach ($screen_names as $user) {
		$users[] = $twitterObj->get("/users/show.json", array("screen_name" => $user));
	}

	foreach ($users as $user) {
		$data = json_decode($user->responseText);
		echo $data->name." -> ".$data->status->text.PHP_EOL;
	}
} catch (Exception $error) {
	// Something failed, this will output the error message from the API
	echo $error->getMessage()."\n";
}
?>