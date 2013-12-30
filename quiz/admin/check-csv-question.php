<?php

$csv_name = '../data/quiz_animali.csv';


require_once('../include/common_inc.php');
$csv_name_src=csv_to_array($csv_name);

echo "<pre>";print_r($csv_name_src);echo "</pre>";

?>
