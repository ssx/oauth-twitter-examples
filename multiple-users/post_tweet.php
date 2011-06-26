<?php
// OAuth Examples for Twitter
// by Scott Wilcox <scott@dor.ky> http://dor.ky @dordotky
// http://dor.ky/code/oauth-examples
// https://github.com/dordotky/oauth-twitter-examples
//
// Post a tweet using the session credentials

// Require our configuration file which will provide our consumer tokens,
// our database link and a few other settings
require "configuration.php";

// Check to see that we've got tokens for this user stored in the session
session_start();
if (!empty($_SESSION["oauth_token"]) && (!empty($_SESSION["oauth_token_secret"]))) {
	echo "<h1>Post Tweet</h1>";
	
	// If the user has POSTed the form, then we can go ahead and try to process it and
	// created a tweet for it. Be very aware, this has no cross site scripting prevention
	// included, that is for you to provide.
	if (!empty($_POST["tweet"])) {
		try {
			// Create a new object to interact with the API
			$twitterObject = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION["oauth_token"], $_SESSION["oauth_token_secret"]);

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
	<?	
} else {
	echo '<p>You need to obtain some OAuth tokens for your account. <a href="authorize.php">Click here to authorize</a>.</p>';
}
?>
<hr />
<h3>Other Examples</h3>
<ul>
	<li><a href="authorize.php">Authorize</a></li>
	<li><a href="post_tweet.php">Post Update</a></li>
</ul>