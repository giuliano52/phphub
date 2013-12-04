<?php
/* Author: GD
 * Created: 20131129
 * Modified: 20131129
 *
 *
 */
 


function emit_question($data_quiz,$single_quiz_data) {

	echo "<tr><td>\n";
	echo $data_quiz[$single_quiz_data['question_index']]["question"];
	echo "</td>\n<td>";
	foreach ($single_quiz_data['answers'] as $key_answer) {
		
		echo '<input type="radio" name="q_'.$single_quiz_data['question_index'].'" value="'.$data_quiz[$key_answer]["correct_answer"].'">';
		echo $data_quiz[$key_answer]["correct_answer"];
		echo "<br>\n"; 
		}
	echo "</td></tr>";

}

function emit_header() {
echo '<html>
<body>
';
}

function emit_quiz_header() {
echo '
<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="get">
<input type="hidden" name="cmd" value="result"> 
<table border="1">
';
}

function emit_quiz_footer() {
echo '
</table>
<input type="submit" value="Submit">
</form>
';
}

function emit_footer() {
echo '
--- Fine---
</body>
</html>
';
}

function emit_result() {
	
	
	$data_quiz =$_SESSION['data_quiz'];
	$num_correct_answer = 0;
	$num_wrong_answer = 0;
	
	echo '<table border="1">';
	for($question_index = 0; $question_index < count($data_quiz); ++$question_index) {
		$answer = test_input($_REQUEST['q_'.$question_index]);
		$correct_answer = $data_quiz[$question_index]["correct_answer"];
		echo '<tr>';
		echo '<td>'.$data_quiz[$question_index]["question"].'</td>';

		if ($correct_answer == $answer) {
			// Correct answer
			echo '<td style="background-color:green;">';
			echo $answer;
			echo "</td>\n";
			$num_correct_answer ++;
			}
		else {
			// wrong answer
			echo '<td style="background-color:red;">';
			echo 'hai risposto :'.$answer.'<br />';
			echo 'Ma la risposta giusta era:'.$correct_answer.'<br />';
			echo "</td>\n";
			$num_wrong_answer ++;
			
		}
		
		echo '</tr>';
	}
	echo "</table>\n";
	
	echo 'hai risposto giusto '.$num_correct_answer.' su '.($num_correct_answer+$num_wrong_answer).' domande';
	
	echo '<br /><A href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">BACK</A>';
}



 
?>
