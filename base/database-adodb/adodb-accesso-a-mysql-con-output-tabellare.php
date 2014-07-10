<?php
session_start();
$server = "localhost";
$user = "root";
$pwd = "dbpassword";
$db = "dbtest";

include('adodb5/adodb.inc.php');
include_once('adodb5/adodb-pager.inc.php');
$DB = NewADOConnection('mysql');
$DB->Connect($server, $user, $pwd, $db);

$sql = "select * from tabtest";

$pager = new ADODB_Pager($DB,$sql);
$pager->Render($rows_per_page=5);


?>