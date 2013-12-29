<?php

$debug = FALSE;

function initialize_session() {
	session_start(); 
	$_SESSION['title'] = "Rispondi alle domande";  // title of the quiz
	$_SESSION['Num_options'] = 4;     // number of option in each question
	$_SESSION['Num_question_per_page'] = 1 ;  // 0 means no limits
	$_SESSION['Num_question_total'] = 6 ;  // 0 means all question available
	$_SESSION['min_diffucult_level'] = 0; // min 0
	$_SESSION['max_diffucult_level'] = 1; // max 100
	$_SESSION['default_response_type'] = "text"; // "options" is for multiple choice
	$_SESSION['default_randomize_question'] = TRUE; // TRUE if the question are randimzed
	$_SESSION['congratulation_file'] = 'conf/congratulation.csv';
	


	
//	$_SESSION['Quiz_name'] = 'data/quiz_bandiere.csv';
//	$_SESSION['Quiz_name'] = 'data/quiz_capitali.csv';
	$_SESSION['Quiz_name'] = 'data/quiz_animali.csv';
//	$_SESSION['Quiz_name'] = 'data/quiz_somme.csv';
//	$_SESSION['Quiz_name'] = 'data/quiz_prova.csv';


}

?>