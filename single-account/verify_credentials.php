<?php
// OAuth Examples for Twitter
// by Scott Wilcox <scott@dor.ky> http://dor.ky @dordotky
// http://dor.ky/code/oauth-examples
// https://github.com/dordotky/oauth-twitter-examples
//
// This script verifys that the credentials and tokens you have are actually valid. 
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

// Now try to make a call to account/verify_credentials to see if the tokens
// that we have are actually valid. If you get an error, re-check your tokens
// and try again. If everything works, you should see the script dump out a
// JSON user object
try {
	// Create a new object to interact with the API
	$twitterObject = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
		
	// Make a call to the API for verify_credentials API endpoint
	$response = $twitterObject->get('/account/verify_credentials.json');
	
	// Test to see we got a HTTP 200 code returned, we'll var_dump it out at
	// this point, but you could display the users profile image
	if ($response->code == 200) {
		// Display the returned JSON in a pretty fashion along with the users
		// profile image.
		echo "<img src=\"".$response["profile_image_url"]."\" alt=\"".$response["name"]."\" /><br />";		
		echo "<pre>";
		echo var_dump(json_decode($response->responseText));
		echo "</pre>";
	} else {
		echo "Error: HTTP Code ".$response->code." was returned.";
	}	
} catch (Exception $error) {
	// Something failed, this will output the error message from the API
	echo "Error: ".$error->getMessage()."\n";
}
?>