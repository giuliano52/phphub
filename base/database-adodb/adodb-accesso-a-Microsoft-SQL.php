<?php

// Esempio di accesso via odbc ad un server MS SQL
// v 20090130
// GD


include('adodb5/adodb.inc.php');

$db =& ADONewConnection('odbc_mssql');

$dsn = "Driver={SQL Server};Server=192.168.1.1;Database=DB_NAME;";

         $db->Connect($dsn,'webuser','passweb');

$rs = $db->Execute("select * from tblwebaccount");
while (!$rs->EOF) {
    print_r($rs->fields);
    $rs->MoveNext();
}


?>