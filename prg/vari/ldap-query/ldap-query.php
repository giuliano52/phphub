<?php
/*
 * Effettua delle query ldap e mostra i riusultati 
 *
 * Autore: GD
 * Data inizio: 20140716
 * Data modifica: 20140716
 *
 * usage:
 * php ldap-query.php   configurazione.ini input-file.txt
 * per configurazione.ini vedi esempio ldap-conf.ini
 */

 
 
#require_once(__DIR__ . '/../../lib/csv_gd.class.php');
#require_once(__DIR__ . '/../../lib/common.lib.php');


$conf = parse_ini_file($argv[1]);

$data = file_get_contents($argv[2]);   
$input_list  = explode(PHP_EOL, $data);  

//print_r($conf);
//print_r($input_list);

$comando = 'ldapsearch -x -h '.$conf['server'].' -D "'.$conf['bind_user'].'" -LLL -o ldif-wrap=no -b "'.$conf['bind'].'" -w "'.$conf['bind_passwd'].'" "'.$conf['ldap_filter'].'" '.$conf['ldap_fields'].' >> out.txt';

foreach ($input_list as $element)  {

	
	$comando_elemento = str_replace("####1####", $element, $comando);
	
	
	exec ('echo "################################'.$element.'##########################################" >>out.txt');
	echo "$comando_elemento\n\n";
	exec ($comando_elemento);
	



}




