<?php
/* Author: GD
 * Created: 20131129
 * Modified: 20131129
 *
 *
 */
 


function emit_question($single_quiz_data,$question_index) {

	echo "<tr><td>\n";
	echo $question_index;
	echo "</td>\n";
	echo "<td>\n";
	echo $single_quiz_data["question"];
	echo "</td>\n<td>";
	foreach ($single_quiz_data['possible_answer'] as $possible_answer) {
		
		echo '<input type="radio" name="q_'.$question_index.'" value="'.$possible_answer.'">';
		echo $possible_answer;
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
<input type="hidden" name="cmd" value="store_answers"> 
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

echo '<br /><A href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">START</A>';
echo '<br /><A href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?cmd=results">Result</A>';
echo '<br /><A href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?cmd=reset_quiz">RESET</A>';
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

	// calculate the number of question 
	if ($_SESSION['Num_question_total'] > 0) 
		$num_question = min(count($data_quiz),$_SESSION['Num_question_total']) ;
	else 
		$num_question = count($data_quiz);

	echo '<table border="1">';
	for($question_index = 0; $question_index < $num_question; ++$question_index) {
		$answer  = $data_quiz[$question_index]["answered_question"];
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
	
	echo 'hai risposto giusto '.$num_correct_answer.' su '.$num_question.' domande';
	



}


 
?>
