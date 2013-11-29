<?php
/* Author: GD
 * Created: 20131129
 * Modified: 20131129
 *
 *
 */

 $num_option = 3;
 
 function csv_to_array($filename='', $delimiter=';')
{
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



$data_quiz=csv_to_array('quiz1.csv');
foreach ($data_quiz as $single_quiz) {
	$question = $single_quiz["Nazione"];
	
	print $question;
	
}

 
?>
