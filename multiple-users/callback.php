<?php
// OAuth Examples for Twitter
// by Scott Wilcox <scott@dor.ky> http://dor.ky @dordotky
// http://dor.ky/code/oauth-examples
// https://github.com/dordotky/oauth-twitter-examples
//
// Handle the returning user from Twitter and store the given OAuth tokens

// Require our configuration file which will provide our consumer tokens,
// our database link and a few other settings
require "configuration.php";

// Start our session, we'll store our user data in here
session_start();

// Place all interaction within a try/catch block
try {
	// Send the request off to get the authenticated users favourited tweets
	$twitterObject = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET);
	
	if (!empty($_GET["oauth_token"])) {
		$twitterObject->setToken($_GET['oauth_token']);
		$token = $twitterObject->getAccessToken();
		$twitterObject->setToken($token->oauth_token, $token->oauth_token_secret);
		
		// Make a call to the Twitter API to fetch basic details about the
		// user that we now have tokens for		
		$userData = $twitterObject->get_accountVerify_credentials();
		$user = $userData->response;
		
		// If we have a user object returned, we can continue and see if we have
		// seen this user before
		if ($user) {
			// Now that we've got working tokens, we need to check whether or not we
			// have got a user record in our database for this user, if not then we
			// add a new record for them now
			$uid = 0; list ($uid) = mysql_fetch_array(mysql_query("SELECT id FROM users WHERE user_id = '".$user["id_str"]."' LIMIT 1"));
			echo mysql_error();
			if ($uid > 0) {
				// We've already got a user record, lets update it
mysql_query("UPDATE `users` SET `name` = '".mysql_real_escape_string($user["name"])."',`screen_name` = '".mysql_real_escape_string($user["screen_name"])."',`image_url` = '".mysql_real_escape_string($user["profile_image_url"])."',`oauth_token_access` = '".$token->oauth_token."', `oauth_token_secret` = '".$token->oauth_token_secret."' WHERE `id` = $uid LIMIT 1");
				if (mysql_affected_rows() == 1) {
					echo "<p>User record updated successfully.</p>";				
				} else {
					if (mysql_error()) {
						echo "<p>Unable to update database, MySQL said: ".mysql_error()."</p>";
					} else {
						echo "<p>User record already up to date.</p>";
					}
				}
			} else {
				// We need to create a new user record
				mysql_query("INSERT INTO `users` (`user_id`, `name`, `screen_name`, `image_url`, `oauth_token_access`, `oauth_token_secret`) VALUES ('".$user["id_str"]."', '".mysql_real_escape_string($user["name"])."', '".mysql_real_escape_string($user["screen_name"])."', '".mysql_real_escape_string($user["profile_image_url"])."', '".$token->oauth_token."', '".$token->oauth_token_secret."')");
				if ($uid = mysql_insert_id()) {
					echo "<p>New user added successfully, ID: $uid</p>";
				} else {
					echo "<p>Error adding new user record, MySQL said: ".mysql_error()."</p>";
				}
			}
			
			// Set up our session for this user
			$_SESSION["uid"] = $uid; // This is our internal user id in the database
			$_SESSION["user_id"] = $user["id_str"];
			$_SESSION["oauth_token"] = $token->oauth_token;
			$_SESSION["oauth_token_secret"] = $token->oauth_token_secret;			
		} else {
			echo "<p>Unable to fetch user data.</p>";
		}
		echo "<h1>Hello ".$user["name"]."</h1>";
		echo '<img src="'.$user["profile_image_url"].'" alt="Profile Image" /> Your username is @'.$user["screen_name"].'.<br />';
	} elseif (!empty($_GET["denied"])) {
		// The user clicked 'No thanks' at the permission prompt
		echo "<p>User denied the application permission.</p>";
	} else {
		// Prompt the user to sign in with twitter so that we can get a set of access
		// tokens to makes calls on their behalf
		echo '<p>You need to visit the <a href="authorize.php">authorize page</a> to begin sign in.</p>';
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