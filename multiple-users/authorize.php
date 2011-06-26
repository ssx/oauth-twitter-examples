<?php
// OAuth Examples for Twitter
// by Scott Wilcox <scott@dor.ky> http://dor.ky @dordotky
// http://dor.ky/code/oauth-examples
// https://github.com/dordotky/oauth-twitter-examples
//
// Fetch an authorisation URL from the Twitter API

// Require our configuration file which will provide our consumer tokens,
// our database link and a few other settings
require "configuration.php";

// Place all interaction within a try/catch block
try {
	// Send the request off to get the authenticated users favourited tweets
	$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET);

	echo '<h1>Sign in with Twitter</h1>';
		
	// Set the callback to be the location of this page
	$twitterObj->setCallback(OAUTH_CALLBACK);

	$url = $twitterObj->getAuthorizeUrl();
	if (!empty($url)) {
		echo '<a href="'.$url.'"><img src="http://si0.twimg.com/images/dev/buttons/sign-in-with-twitter-l.png" alt="Sign in with Twitter" /></a>';
	} else {
		echo "<p>Unable to fetch authorization URL.</p>";
	}
} catch (Exception $error) {
	// Something failed, this will output the error message from the API
	echo $error->getMessage()."\n";
}
?>
<hr />
<h3>Other Examples</h3>
<ul>
	<li><a href="authorize.php">Authorize</a></li>
	<li><a href="post_tweet.php">Post Update</a></li>
</ul>