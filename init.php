<?php
/* 
 * nilsdinghatlimit
 * © 2013 nilsding
 * License: AGPLv3, read the LICENSE file.
 */
require_once('config.php');
$sql = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
$q = mysqli_query($sql, "CREATE TABLE IF NOT EXISTS ndl_users (user_id int, access_token text, access_token_secret text)");
?>
