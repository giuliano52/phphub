#!/usr/bin/php
<?php
$filename = $argv[1];

$txt_file = file($filename);

$out = array();
$index = -1;
$line_number = 1;

foreach ($txt_file as $linea) {
    $linea = trim($linea);
    if (substr($linea, 0, 20) == '###Educazione Civica') {
        $index++;
        $out[$index]['wrong_answer'] = '';

        $question = trim(substr($linea, 20));
        if (empty($question)) {
            echo "$line_number +++ Vuota\n";
        } else {
            $out[$index]['question'] = $question;
        }
    }
    elseif (substr($linea, -2)=="S".chr(236)) {
        $out[$index]['correct_answer'] = substr($linea,0, -2);
    }
    elseif (substr($linea, -2)=="No") {
        $out[$index]['wrong_answer'] = trim($out[$index]['wrong_answer'] .'|'. substr($linea,0, -2));
    }
    else {
        
            echo "$line_number --- $linea\n";
    }
            
    $line_number++;
}
//print_r($out);
