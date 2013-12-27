<?php

function initialize_session() {
	session_start(); 

	$_SESSION['Num_options'] = 4;     // number of option in each question
	$_SESSION['Num_question_per_page'] = 1 ;  // 0 means no limits
	$_SESSION['Num_question_total'] = 6 ;  // 0 means all question available
	$_SESSION['min_diffucult_level'] = 0; // min 0
	$_SESSION['max_diffucult_level'] = 100; // max 100
	$_SESSION['congratulation_file'] = 'conf/congratulation.csv';


	
//	$_SESSION['Quiz_name'] = 'data/quiz_bandiere.csv';
//	$_SESSION['Quiz_name'] = 'data/quiz_capitali.csv';
	$_SESSION['Quiz_name'] = 'data/quiz_animali.csv';
}

?>