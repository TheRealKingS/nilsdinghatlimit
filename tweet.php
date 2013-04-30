<?php 
/* 
 * nilsdinghatlimit
 * © 2013 nilsding
 * License: AGPLv3, read the LICENSE file.
 */
require_once ('oauth/twitteroauth.php');
require_once ('config.php');
$web = !empty($_SERVER['HTTP_HOST']);
global $web;

if ($web) {
	if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
		list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(":", base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
	}
	if (empty($_SERVER['PHP_AUTH_USER'])) {
		header((substr(php_sapi_name(), 0, 6) == "apache" ? "HTTP/1.0 " : "Status: ") . "401 Unauthorized");
		header('WWW-Authenticate: Basic realm="Hier passieren MegaHAAAAX1337."');
		die("<h1>401 - Unauthorized</h1>");
	} else {
		if (!(strtolower($_SERVER['PHP_AUTH_USER']) == strtolower(TWEET_USERNAME) && $_SERVER['PHP_AUTH_PW'] == TWEET_PASSWORD)) {
			header((substr(php_sapi_name(), 0, 6) == "apache" ? "HTTP/1.0 " : "Status: ") . "401 Unauthorized");
			header('WWW-Authenticate: Basic realm="Hier passieren MegaHAAAAX1337."');
			die("<h1>401 - Unauthorized</h1>");
		}
	}
}


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<h1>Tweet!</h1>
<form method="POST">
<input type="text" name="tweet"> <input type="submit">
</form>
<br />
<div style="background: #000; color: #b2b2b2; width: 640px; height: 400px; overflow-y: scroll; font-family: monospace; border-width: 1px; border-color: #aaa; border-style: solid;">
<span style="color: #54ff54; font-weight: bold;">nilsding@laptop-pc </span><span style="color: #5454ff; font-weight: bold;">~ $ </span>php tweet.php 
<?php
if (isset($_POST['tweet'])) {
	echo " &quot;" . htmlspecialchars(addslashes($_POST['tweet'])) . "&quot;<br />";
	$sql = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
	$q = mysqli_query($sql, "SELECT * FROM ndl_users;");
	while ($r = mysqli_fetch_assoc($q)) {
		echo "Tweete mit Account " . $r['user_id'] . "<br />";
		$t = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $r['access_token'], $r['access_token_secret']);
		$t->post('statuses/update', array('status' => $_POST['tweet']));
	}
} else {
	echo '<br />Schreibe einen Tweet!<br />';
}
?>
<span style="color: #54ff54; font-weight: bold;">nilsding@laptop-pc </span><span style="color: #5454ff; font-weight: bold;">~ $ </span>
</div>

<?php if ($CONFIG_VIEW_USERS) { ?>
<!-- Added user view  by therealkings -->
<div id="user">
<h2>Wer wird benachrichtigt?</h2>
<table>
<?php
$sql = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
$q = mysqli_query($sql, "SELECT user_id FROM ndl_users;");

while($r = mysqli_fetch_assoc($q)) {
	$json = file_get_contents("http://api.twitter.com/1/users/lookup.json?user_id=".$r['user_id'], true);
	$data = json_decode($json);
	$username = $data[0]->screen_name;
	$name = $data[0]->name;
	echo "<tr>";
	echo "<td>\r\n<a href=\"https://twitter.com/".$username."\" target=\"_blank\"><img src=\"https://api.twitter.com/1/users/profile_image/".$username."?size=normal\" alt=\"@".$username."\" title=\"@".$username."\"></a>\r\n</td>\r\n";
	echo "<td>@".$username." (".$name.")</td>";
	echo "</tr>";
}
?>
</table>
</div>
<?php } ?>
</body>
</html>
