<?php
/* Author: GD
 * Created: 20131129
 * Modified: 20131129
 *
 *
 */

function csv_to_array($filename='', $delimiter=';'){
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
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function cmd_inizialize_quiz($quiz_name) {

	$data_quiz_src=csv_to_array($quiz_name);
	shuffle($data_quiz_src);
	$all_possible_answer = array_column_1($data_quiz_src,"correct_answer");
	$data_quiz = array();
	
	// calculate the number of question 
	if ($_SESSION['Num_question_total'] > 0) 
		$num_question = min(count($data_quiz_src),$_SESSION['Num_question_total']) ;
	else 
		$num_question = count($data_quiz_src);
	$_SESSION['Num_question_total'] = $num_question;
	
	for($question_id = 0 ; $question_id < $num_question; $question_id++) {
		$data_quiz[$question_id] = $data_quiz_src[$question_id];
		shuffle($all_possible_answer);
		$data_quiz[$question_id]["possible_answer"]=array_slice($all_possible_answer,0,$_SESSION['Num_options']) ;
		if (!in_array($data_quiz[$question_id]["correct_answer"],$data_quiz[$question_id]["possible_answer"])) {
			$data_quiz[$question_id]["possible_answer"][0]=$data_quiz[$question_id]["correct_answer"];
			shuffle($data_quiz[$question_id]["possible_answer"]);
		}
	}
	
	$_SESSION['data_quiz'] = $data_quiz;
	// echo "<pre>";print_r($data_quiz);echo "</pre>";
	
	return $data_quiz;
}

function cmd_quiz($quiz_name,$starting_question=0) {
	
	// check id data_quiz is already in the session 
	$data_quiz = isset($_SESSION['data_quiz']) ? $_SESSION['data_quiz'] : cmd_inizialize_quiz($quiz_name);
	
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
	

	for($question_index = $starting_question; $question_index < $num_question+$starting_question; ++$question_index) {
		emit_question($data_quiz[$question_index],$question_index);
	}

	emit_quiz_footer($starting_question,$all_answered);
}




function array_column_1(array $input, $columnKey, $indexKey = null) {
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
	echo "session distroyed";
}
 
?>
