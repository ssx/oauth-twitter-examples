<?php
// OAuth Examples for Twitter
// by Scott Wilcox <scott@dor.ky> http://dor.ky @dordotky
// http://dor.ky/code/oauth-examples
// https://github.com/dordotky/oauth-twitter-examples
//
// This example will add a user given via a HTTP post to a list.
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
define("NAME_USER","oauthexamples");
define("NAME_LIST","oauth-add-me-to-list");

// Place all interaction within a try/catch block
try {
	// Create a new object
	$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
	
	// Either show the current list members if nothing was posted,
	// or process the posted request
	if (!empty($_POST["screen_name"])) {
		// Add this user to our list, first get their user ID
		$members = $twitterObj->get("/users/show.json?screen_name=".$_POST["screen_name"]);
		$reply = json_decode($members->responseText);
		if ($reply) {
			$id = $reply->id;
			$members = $twitterObj->post("/".NAME_USER."/".NAME_LIST."/members.json",array("id" => $id));
			$reply = json_decode($members->responseText);
			if ($reply) {
				echo "User $id added to list<br />";		
			} else {
				// Do more error checking here
				echo "Failed adding ID $id to list<br />";
			}
		} else {
			echo "Given screen name is invalid.<br />";
		}
	}
	
	// Form to add via text box
	echo "<h3>Add Someone?</h3>";
	echo "<form method=\"post\" action=\"/add-me-to-list/\">";
	echo "<input type=\"text\" name=\"screen_name\" /> <input type=\"submit\" value=\"Add Me to List\" />";
	echo "</form><br />";
	
	// We're going to show the members of our list now
	echo "<h3>People in our Wonderful List</h3>";
	$members = $twitterObj->get("/".NAME_USER."/".NAME_LIST."/members.json");
	$users = json_decode($members->responseText);
	
	// Print out these users
	foreach ($users->users as $user) {
		echo "<div style=\"float: left; width: 80px;\"><img src=\"".$user->profile_image_url."\" /><br />".$user->screen_name."</div>";
	}
} catch (Exception $error) {
	// Something failed, this will output the error message from the API
	echo $error->getMessage()."\n";
}	
?>