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
	$sql = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
	$sqls =  "INSERT INTO ndl_users (user_id, access_token, access_token_secret) VALUES (" . $access_token['user_id']. ", '" . $access_token['oauth_token'] . "', '" . $access_token['oauth_token_secret'] . "');";
	$q = mysqli_query($sql, $sqls);
	header('Location: ./index.php');
} else {
	header('Location: ./clearsessions.php');
}
