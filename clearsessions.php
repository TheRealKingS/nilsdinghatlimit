<?php
/* 
 * nilsdinghatlimit
 * © 2013 nilsding
 * License: AGPLv3, read the LICENSE file.
 */

session_start();
session_destroy();

header('Location: ./signin.php');
