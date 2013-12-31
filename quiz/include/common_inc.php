<?php

function csv_to_array($filename='', $delimiter=';'){
	// convert a csv file to an array

    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if (empty($row)) continue;
            if(!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
}



function test_input($data) {
	// clean input 
	$data = trim($data);
	$data = stripslashes($data);
	$data1 = htmlentities($data);
	return $data1;
}

function choose_cvs_entry($csv_file) {
	/* Return a random element from a csv_file */
	$csv_array = csv_to_array($csv_file);
	
	$id = array_rand($csv_array);
	
	//print ($id ."-".count($csv_array));
	return $csv_array[$id]['url'];
}

function choose_file($dir) {
	// chose a random file from a directory
	$a_dir = array();
	if ($handle = opendir($dir)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $a_dir[] = $entry;
        }
    }
    closedir($handle);
	}
	return $a_dir[array_rand($a_dir)];
}
 

?>
