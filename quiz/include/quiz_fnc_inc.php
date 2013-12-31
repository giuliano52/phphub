<?php
/* Author: GD
 * Created: 20131129
 * Modified: 20131129
 *
 *
 */



function cmd_inizialize_quiz($quiz_name) {

	$data_quiz_src=csv_to_array($quiz_name);

	if ($_SESSION['default_randomize_question'] == TRUE) 
		shuffle($data_quiz_src);

	// find all possible answer for the test
	$all_possible_answer = array();
	foreach ($data_quiz_src as $single_quiz) {
		$all_correct_answer = explode('|', $single_quiz["correct_answer"]);
		$all_possible_answer[] = $all_correct_answer [0];
	}
	

	$data_quiz = array();
	// calculate the number of question 
	
	if ($_SESSION['Max_question_total'] > 0) {
		$num_question = min(count($data_quiz_src),$_SESSION['Max_question_total']) ;
		}
	else  {
		$num_question = count($data_quiz_src);
		}
	$_SESSION['Num_question_total'] = $num_question;
	
	
	// insert data from csv to $data_quiz
	$question_id = 0;



	foreach ($data_quiz_src as $single_quiz) {
		$difficult_level = isset($single_quiz['difficult_level']) ? $single_quiz['difficult_level'] : 0 ;
		if (($difficult_level >= $_SESSION['min_diffucult_level']) && ($difficult_level <= $_SESSION['max_diffucult_level'])) {
			
			// Add item to $data_quiz
			$data_quiz[$question_id] = $single_quiz;
			
			// find all correct answer 
			$data_quiz[$question_id]['all_correct_answer'] = explode('|', $single_quiz["correct_answer"]);
			
			shuffle($all_possible_answer);
			
			// add the first correct answer to $possible_answer
			$possible_answer = array($data_quiz[$question_id]['all_correct_answer'][0]);
			
			//  add wrong answer to $possible_answer from input data
			if (isset($data_quiz[$question_id]["wrong_answer"])) {
				$possible_wrong_answer = explode('|', $data_quiz[$question_id]["wrong_answer"]);
				$possible_answer = array_merge($possible_answer,$possible_wrong_answer);
			}
			
			//  add random wrong answer to $possible_answer
			$possible_answer = array_merge($possible_answer,$all_possible_answer);
			
			// eliminate duplicates
			$possible_answer = array_unique($possible_answer);
			
			//remove eventually emtpy element
			$possible_answer = array_filter($possible_answer);
			
			//get only the correct number of elements:
			$possible_answer = array_slice($possible_answer,0,$_SESSION['Num_options']) ;
			
			// shuffle all data:
			shuffle($possible_answer);
			
			// Store all in the $data_quiz 
			$data_quiz[$question_id]["possible_answer"]= $possible_answer;
			
			
			$question_id ++;
		}
	}
		
	$_SESSION['data_quiz'] = array_slice($data_quiz,0,$_SESSION['Num_question_total']);
	//echo "<pre>";print_r($_SESSION);echo "</pre>";

	// return $data_quiz;
}

function cmd_quiz($quiz_name,$starting_question=0) {
	
	// check id data_quiz is already in the session 
	isset($_SESSION['data_quiz']) ? $_SESSION['data_quiz'] : cmd_inizialize_quiz($quiz_name);
	
	$data_quiz = $_SESSION['data_quiz'];
	//check if all question have an answer
	$all_answered = TRUE;
	for($id_question = 0; $id_question < count($data_quiz) ; $id_question++) {
		if(!isset($data_quiz[$id_question]["answered_question"])) 
			$all_answered = FALSE;
	}
		
	emit_quiz_header();
	
	if ($_SESSION['Num_question_per_page'] > 0) 
		$num_question = min(count($data_quiz),$_SESSION['Num_question_per_page']) ;
	else 
		$num_question = count($data_quiz);
	
	$tab_index = 1;
	for($question_index = $starting_question; $question_index < $num_question+$starting_question; ++$question_index) {
		emit_question($data_quiz[$question_index],$question_index,$tab_index);
		$tab_index ++;
	}
	emit_quiz_footer($starting_question,$all_answered);
}


function cmd_store_answers() {
	foreach($_REQUEST as $key=>$val) {
		if(substr($key,0,2)=="q_") {
			$id = (int)substr($key,2) ;
			$_SESSION['data_quiz'][$id]["answered_question"] = test_input($val);
		}
		
	}
	
}

function cmd_reset_quiz() {
	session_destroy();
	// print "session distroyed";
}


function quiz_check_answer() {
	$num_correct_answer = 0;

	foreach ($_SESSION['data_quiz'] as $key => $data_single_quiz) {
		$all_right_question = array();
		foreach ($data_single_quiz['all_correct_answer'] as $single_correct_answer) {
			$all_right_question[] = trim(strtoupper($single_correct_answer));
		}
		$answered_question = trim(strtoupper($data_single_quiz["answered_question"]));
		if (in_array($answered_question , $all_right_question)) {
			$_SESSION['data_quiz'][$key]['answer_is_correct'] = TRUE;
			$num_correct_answer++;
			}
		else
			$_SESSION['data_quiz'][$key]['answer_is_correct'] = FALSE;
	}
	$_SESSION['num_correct_answer']= $num_correct_answer;
	
}
 
?>
