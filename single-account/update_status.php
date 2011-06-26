<?php
// OAuth Examples for Twitter
// by Scott Wilcox <scott@dor.ky> http://dor.ky @dordotky
// http://dor.ky/code/oauth-examples
// https://github.com/dordotky/oauth-twitter-examples
//
// This script will post a tweet to Twitter and then return the ID of the new tweet.
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
// If the user has POSTed the form, then we can go ahead and try to process it and
// created a tweet for it. Be very aware, this has no cross site scripting prevention
// included, that is for you to provide.
if ($_POST["tweet"]) {
	try {
		// Create a new object to interact with the API
		$twitterObject = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
		
		// Make a call to the API for verify_credentials API endpoint, notice the
		// change to POST for this request.
		$response = $twitterObject->post('/statuses/update.json',array("status" => utf8_encode($_POST["tweet"])));
		
		// Test to see we got a HTTP 200 code returned, we'll var_dump it out at
		// this point, but you could display the users profile image
		if ($response->code == 200) {
			// Display the returned JSON in a pretty fashion along with the users
			// profile image. If this completes successfully then you've effectively
			// created your first Twitter client.
			echo "<p>New tweet was created: ".$response["id_str"]."</p>";
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
}
// Display an HTML form for your tweet input
?>
<hr />
<form method="post" action="?">
	<textarea name="tweet"></textarea><br />
	<input type="submit" value="Post Tweet" />
</form>