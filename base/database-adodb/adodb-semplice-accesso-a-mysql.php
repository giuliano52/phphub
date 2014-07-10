<?php

$server = "localhost";
$user = "root";
$pwd = "dbpassword";
$db = "dbtest";

include('adodb5/adodb.inc.php');
$DB = NewADOConnection('mysql');
$DB->Connect($server, $user, $pwd, $db);

$rs = $DB->Execute("select * from tabtest");
while ($array = $rs->FetchRow()) {
    print_r($array);
	echo "<br />";
}


?>