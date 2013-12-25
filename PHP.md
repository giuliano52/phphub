PHP
===
#Array
```php
$a=array("1","2","3");
foreach($a as $valore) {
	echo $valore;
	}
```		
#Acceleratore
    aptitude install php-apc

#Funzioni utili
Per provare il PHP

    phpinfo();
Per Passare i parametri con spazi ed altro uso le funzioni

    base64_encode / base64_decode
Per eliminare i tag HTML

    strip_tags 
Per trasformare una stringa con '�' '>' '&' ... in una con i caratteri HTML &egrave; ...

    htmlentities($string)
Come sopra solo che trasforma esclusivamente: < > & " 

    htmlspecialchar($string)
Per verificare se una stringa contiene un valore
```php
ereg("ab",$string)
true se $string contiene ab
```
Mostra tutto il contenuto di un array

    var_dump		
    var_export
    print_r		
Mostra i dettagli di un file
```php
pathinfo
$path_parts = pathinfo('/www/htdocs/index.html');
$path_parts['dirname']	 	-> 	/www/htdocs
$path_parts['basename'] 	-> 	index.html
$path_parts['extension'] 	-> 	html
$path_parts['filename'] 	-> 	index
```
#Files
per analizzare un file:

    $lines = file ("nomefile.txt");
    foreach ($lines as $line_num => $line) {
        echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br>\n";
    }

Elenca tutti i file della directory ed elimina . e ..
```php
$sDir = "/tmp/";
// Open a known directory, and proceed to read its contents
if (is_dir($sDir)) {
	if ($dh = opendir($sDir)) {
		while (($file = readdir($dh)) !== false) {
			if ($file != "." && $file != "..") {
				echo "filename: <b>$file</b> <br />\n";
			} 
		}
		closedir($dh);
	}
}
```

#Sqlite
```php
if ($db = sqlite_open("dati.sqlite", 0666, $sqliteerror)) {
$query = <<<EOD
CREATE TABLE patch (
	computer varchar(255), 
	bulletin varchar(255),
	criticita varchar(30)
	);
EOD;

	sqlite_query($db, $query);
} else {
   die($sqliteerror);
}

$result = sqlite_query($db, "select * FROM patch ");
while ($row = sqlite_fetch_array($result)) {
	// print_r($row);
	$linea = $row['computer'] . "---" . $row['bulletin'] . "---" . $row['criticita']."+++" ;
 	echo "$linea\n";
}
```

#Esecuzione di comandi di sitema con permessi elevati
Se fosse necessario di eseguire comandi con permessi più elevati bisogna lanciare il comando

    sudo visudo 
e poi aggiungere :

    www-data ALL=NOPASSWD: /sbin/iptables, /usr/bin/du
    
Per ad esempio permettere iptable e du

oppure:

    www-data ALL=NOPASSWD: ALL
per tutti i comandi.
Nello script php si puù ora lanciare il comando:

    exec ("sudo iptables -P FORWARD ACCEPT");

#Upload
Bisogna impostare i seguenti limiti nel file php.ini se si vuole fare l'upload di file di grosse dimensioni

    upload_max_filesize 20M
    post_max_size 20M
    max_execution_time 200
    max_input_time 200
    
Attenzione si può anche impostare 1G ma non 2G (va oltre il limite consentito)

index.php
```php
<html>
<body>

<form method="post" action="upload.php" enctype="multipart/form-data">
    <input type="file" name="miofile">
    <input type="submit" value="Upload">
</form>

</body>
</html>
```
upload.php
```php
<html>
<body>
<?PHP
    // RECUPERO I PARAMETRI DA PASSARE ALLA FUNZIONE PREDEFINITA PER L'UPLOAD
    $cartella = '/mnt/sda3/upload/';
    $percorso = $_FILES['miofile']['tmp_name'];
    $nome = $_FILES['miofile']['name'];
    // ESEGUO L'UPLOAD CONTROLLANDO L'ESITO
    if (move_uploaded_file($percorso, $cartella . $nome))
    {
        print "Upload eseguito con successo";
    }
    else
    {
        print "Si sono verificati dei problemi durante l'Upload";
    }
?>
</body>
</html>
```
#Mail
Si può usare il comando mail:

    mail( $destinatario,$oggetto , $messaggio, $intestazioni );

se il mittente è nella forma:

    $intestazioni = "From: $from\nReply-To: $from\nContent-Type: text/html";
la mail diventa di tipo HTML

esempio più completo:
```php
$to = "viralpatel.net@gmail.com";
$subject = "VIRALPATEL.net";
$body = "Body of your message here you can use HTML too. e.g. <br> <b> Bold </b>";
$headers = "From: Peter\r\n";
$headers .= "Reply-To: info@yoursite.com\r\n";
$headers .= "Return-Path: info@yoursite.com\r\n";
$headers .= "X-Mailer: PHP5\n";
$headers .= 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
mail($to,$subject,$body,$headers);
```

Validazione email:
```php
$email = $_POST['email'];
if(preg_match("~([a-zA-Z0-9!#$%&amp;'*+-/=?^_`{|}~])@([a-zA-Z0-9-]).([a-zA-Z0-9]{2,4})~",$email)) {
	echo 'This is a valid email.';
} else{
	echo 'This is an invalid email.';
} 
```
#XML
```php
//this is a sample xml string
$xml_string="<?xml version='1.0'?>
<moleculedb>
    <molecule name='Benzine'>
        <symbol>ben</symbol>
        <code>A</code>
    </molecule>
    <molecule name='Water'>
        <symbol>h2o</symbol>
        <code>K</code>
    </molecule>
</moleculedb>";

//load the xml string using simplexml function
$xml = simplexml_load_string($xml_string);

//loop through the each node of molecule
foreach ($xml->molecule as $record)
{
   //attribute are accessted by
   echo $record['name'], '  ';
   //node are accessted by -> operator
   echo $record->symbol, '  ';
   echo $record->code, '<br />';
}
```

#JSON


Following is the PHP code to create the JSON data format of above example using array of PHP.
```php
$json_data = array ('id'=>1,'name'=>"rolf",'country'=>'russia',"office"=>array("google","oracle"));
echo json_encode($json_data);
```
Following code will parse the JSON data into PHP arrays.
```php
$json_string='{"id":1,"name":"rolf","country":"russia","office":["google","oracle"]} ';
$obj=json_decode($json_string);
//print the parsed data
echo $obj->name; //displays rolf
echo $obj->office[0]; //displays google
```
#Varie
Per vedere tutti i parametri passati con un POST
```php
echo "Values submitted via POST method:<br />\n";
reset ($_POST);
while (list ($key, $val) = each ($_POST)) {
    echo "$key => $val<br />\n";
}
```
le variabili da POST GET:

    $_GET["ID"]
per eliminare I warnings dall'html: in php.ini:

    error_reporting = E_ALL & ~E_notice & ~E_warnings
    service httpd restart

Alternativo IF 
```php
<?php
if ($a > 5) {
   echo "big";
} else {
   echo "small";
}
?>
can be replaced by:
<?php
echo ($a > 5 ? "big" : "small");
?>
```

#Stringhe
```php
$out = <<<EOF
<a href="ordini.php">visualizza rodini</a>
<a href="amm.php">gestione articoli</a>
EOF;
```
