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
	$data_quiz=csv_to_array($quiz_name);
	shuffle($data_quiz);
	$all_possible_answer = array_column_1($data_quiz,"correct_answer");
	
	for($question_id = 0 ; $question_id < count($data_quiz); $question_id++) {
		shuffle($all_possible_answer);
		$data_quiz[$question_id]["possible_answer"]=array_slice($all_possible_answer,0,$_SESSION['Num_options']) ;
		if (!in_array($data_quiz[$question_id]["correct_answer"],$data_quiz[$question_id]["possible_answer"])) {
			$data_quiz[$question_id]["possible_answer"][0]=$data_quiz[$question_id]["correct_answer"];
			shuffle($data_quiz[$question_id]["possible_answer"]);
		}
	}
	$_SESSION['data_quiz'] = $data_quiz;
	return $data_quiz;
}

function cmd_quiz($quiz_name,$starting_question=0) {
	
	$data_quiz = isset($_SESSION['data_quiz']) ? $_SESSION['data_quiz'] : cmd_inizialize_quiz($quiz_name);
	emit_quiz_header();
	
	

	
	// calculate the number of question 
	if ($_SESSION['Num_question_total'] > 0) 
		$num_question = min(count($data_quiz),$_SESSION['Num_question_total']) ;
	else 
		$num_question = count($data_quiz);
		
	
	for($question_index = $starting_question; $question_index < $num_question; ++$question_index) {
	
		$single_quiz_data['question_index']=$question_index;
		$single_quiz_data['answers'] = array_rand($data_quiz, $_SESSION['Num_options'] );
	
		shuffle($single_quiz_data['answers']);	
		if (!in_array($question_index, $single_quiz_data['answers'])) {
			$single_quiz_data['answers'][0]=$question_index;
			shuffle($single_quiz_data['answers']);
		}
		

	emit_question($data_quiz,$single_quiz_data);
	$_SESSION['data_quiz'] = $data_quiz;
	$_SESSION['single_quiz_data'] = $single_quiz_data;
	}
	emit_quiz_footer();

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

 
?>
