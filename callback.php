<?php
/* 
 * nilsdinghatlimit
 * © 2013 nilsding
 * License: AGPLv3, read the LICENSE file.
 */

session_start();
require_once('oauth/twitteroauth.php');
require_once('config.php');

if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
	$_SESSION['oauth_status'] = 'oldtoken';
	header('Location: ./clearsessions.php');
}

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);


$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
$_SESSION['access_token'] = $access_token;
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);

if (200 == $connection->http_code) {
	$_SESSION['status'] = 'verified';	
	
	/* To ensure that no user is duplicated in the database */
	/* And some MySQL optimizing							*/
	/* Edited by therealkings								*/
	
	$mysqli = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
	
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}

	$result = $mysqli->query("SELECT user_id from ndl_users WHERE `user_id` = '".$access_token['user_id']."'");
		if($result->num_rows > 0)
			{
				$sqls = "UPDATE SET `access_token` = '".$access_token['oauth_token']."', `access_token_secret` = '".$access_token['oauth_token_secret']."' WHERE `user_id` = '".$access_token['user_id']."'";
			}
		else
			{
				$sqls =  "INSERT INTO ndl_users (user_id, access_token, access_token_secret) VALUES (" . $access_token['user_id']. ", '" . $access_token['oauth_token'] . "', '" . $access_token['oauth_token_secret'] . "');";
			}
	
	$q = $mysqli->query($sqls);
	/* End edit 											*/
	
	header('Location: ./index.php');
} else {
	header('Location: ./clearsessions.php');
}
