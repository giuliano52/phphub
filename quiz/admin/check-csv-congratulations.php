<?php

$csv_name = '../conf/congratulation.csv';

require_once('../include/common_inc.php');
$csv_name_src=csv_to_array($csv_name);

foreach ($csv_name_src as $a_img) {
	$img = $a_img['url'];
	if(substr($img, 0, 3)=="img") {
		$img = "../".$img;
	}
	echo "<img src=\"$img\"><br />\n";
	echo "$img<br />\n";
}

//echo "<pre>";print_r($csv_name_src);echo "</pre>";

?>

