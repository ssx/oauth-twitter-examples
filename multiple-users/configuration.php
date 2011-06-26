<?php
// OAuth Examples for Twitter
// by Scott Wilcox <scott@dor.ky> http://dor.ky @dordotky
// http://dor.ky/code/oauth-examples
// https://github.com/dordotky/oauth-twitter-examples
//
// Send the user off to Twitter to begin the OAuth process
// First, require the excellent twitter-async library by Jaisen Mathai. You can read
// more about this library at https://github.com/jmathai/twitter-async
require "../twitter-async/EpiCurl.php";
require "../twitter-async/EpiOAuth.php";
require "../twitter-async/EpiTwitter.php";

// You need to replace the values in this file with those found in your application 
// settings. Sign in to the Twitter developer site at https://dev.twitter.com/apps and
// make a note of "Consumer Key" and "Consumer Secret" being careful not to include
// any extra spaces or text.
define("CONSUMER_KEY","K8kq7COAxSZkgbwcsdyWDQ");
define("CONSUMER_SECRET","TQpyYbJrSHUHQHWKOIWKvMQ6um8CsgPgQAUVZ8RI");

// The location of the 'callback.php' which will handle users when they returned back
// from Twitter with a token or denied message
define("OAUTH_CALLBACK","http://oauth-examples.local/multiple-users/callback.php");

// We'll store our user records in a MySQL table, so connect to our database here, you
// can find the structure in the 'database.sql' file
mysql_connect("localhost","oauth_examples","oauth_examples");
mysql_select_db("twitter");
?>