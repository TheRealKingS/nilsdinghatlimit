<?php
/* 
 * nilsdinghatlimit
 * © 2013 nilsding
 * License: AGPLv3, read the LICENSE file.
 */
session_start();
require_once('oauth/twitteroauth.php');
require_once('config.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<h1>nilsdinghatlimit</h1>
<p>Das hier ist ein Service, den ich verwenden werde, um euch über eure Accounts zu benachrichtigen, dass ich Limit habe.</p>
<p><?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'verified') echo 'Vielen Dank!'; else echo '<a href="signin.php">Sich mit Twitter anmelden.</a>' ?></p>
<hr />
<p style="font-size: small;"><a href="https://github.com/nilsding/nilsdinghatlimit">Sie können diese auch selber hosten! Oder dazu beitragen.</a></p>
</body>
</html>
