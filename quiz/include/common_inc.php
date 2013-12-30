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
	$data = htmlspecialchars($data);
	return $data;
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
 

 
 

function array_column_1(array $input, $columnKey, $indexKey = null) {
		// implement the function array_column for php <5.5 
		// Return the values from a single column in the input array 
        $result = array();
   
        if (null === $indexKey) {
            if (null === $columnKey) {
                // trigger_error('What are you doing? Use array_values() instead!', E_USER_NOTICE);
                $result = array_values($input);
            }
            else {
                foreach ($input as $row) {
                    $result[] = $row[$columnKey];
                }
            }
        }
        else {
            if (null === $columnKey) {
                foreach ($input as $row) {
                    $result[$row[$indexKey]] = $row;
                }
            }
            else {
                foreach ($input as $row) {
                    $result[$row[$indexKey]] = $row[$columnKey];
                }
            }
        }
   
        return $result;
}

?>
