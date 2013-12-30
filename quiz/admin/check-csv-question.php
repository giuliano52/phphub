<?php

$quiz_name = '../data/quiz_animali.csv';


require_once('../include/common_inc.php');
$data_quiz_src=csv_to_array($quiz_name);

echo "<pre>";print_r($data_quiz_src);echo "</pre>";

?>
