<?php

$debug = FALSE;

function initialize_session() {
	session_start(); 
	$_SESSION['Num_options'] = 4;     // number of option in each question
	$_SESSION['Num_question_per_page'] = 2 ;  // 0 means no limits
	$_SESSION['Num_question_total'] = 6 ;  // 0 means all question available
	$_SESSION['min_diffucult_level'] = 0; // min 0
	$_SESSION['max_diffucult_level'] = 1; // max 100
	$_SESSION['default_free_renponse'] = TRUE; // TRUE if the default is free_response FALSE if the default is multiple choise
	$_SESSION['default_randomize_question'] = TRUE; // TRUE if the question are randimzed
	$_SESSION['congratulation_file'] = 'conf/congratulation.csv';
	


	
//	$_SESSION['Quiz_name'] = 'data/quiz_bandiere.csv';
//	$_SESSION['Quiz_name'] = 'data/quiz_capitali.csv';
//	$_SESSION['Quiz_name'] = 'data/quiz_animali.csv';
	$_SESSION['Quiz_name'] = 'data/quiz_somme.csv';
//	$_SESSION['Quiz_name'] = 'data/quiz_prova.csv';


}

?>