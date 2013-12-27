<?php
/* Author: GD
 * Created: 20131129
 * Modified: 20131227
 *
 *
 */
 
function emit_question($single_quiz_data,$question_index) {
	$answer = isset($single_quiz_data[answered_question]) ? $single_quiz_data[answered_question] : "";
	echo "<tr><td>\n";
	echo $question_index;
	echo "</td>\n";
	echo "<td>\n";
	echo $single_quiz_data["question"];
	echo "</td>\n<td>";
	
	foreach ($single_quiz_data['possible_answer'] as $possible_answer) {
		$checked = ($answer == $possible_answer) ? " checked " : "";
		echo '<input type="radio" name="q_'.$question_index.'" value="'.$possible_answer.'" '.$checked.'>';
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

function emit_quiz_footer($starting_question,$all_answered) {
	echo '</table>';
	echo '<input type="hidden" name="starting_question" value="'.$starting_question.'"> ';

	if ($all_answered == TRUE) {
		echo "Hai risposto a tutte le domande: Guarda i ";
		echo '<A href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?cmd=results">Risultati</A>';
	}
	else {
		echo "\n";
		echo '<input type="submit" value="Precedente" Name="Nav">';
		echo '<input type="submit" value="Prossimo" Name="Nav">';
		}
	echo "</form>\n";
	
}

function emit_footer() {
echo '<br /><br /><br />';
echo '<br /><A href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?cmd=reset_quiz">RICOMINCIA</A>';
echo '</body></html>
';
}

function emit_result() {
	$data_quiz =$_SESSION['data_quiz'];
	$num_correct_answer = 0;
	$num_wrong_answer = 0;

	$num_question = count($data_quiz);

	for($question_index = 0; $question_index < $num_question; ++$question_index) {
		$answer  = $data_quiz[$question_index]["answered_question"];
		$correct_answer = $data_quiz[$question_index]["correct_answer"];
		if ($correct_answer == $answer) {
			$num_correct_answer ++;
		}
		else {
			$num_wrong_answer ++;
		}
	}
	echo '<table border="1">';
	echo '<tr><td>';
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

			}
		else {
			// wrong answer
			echo '<td style="background-color:red;">';
			echo 'hai risposto :'.$answer.'<br />';
			echo 'Ma la risposta giusta era:'.$correct_answer.'<br />';
			echo "</td>\n";
		}
		echo '</tr>';
	}
	echo "</table>\n";
	echo "</td><td>";
	echo 'hai risposto giusto '.$num_correct_answer.' su '.$num_question.' domande';
	if($num_correct_answer == $num_question) {
		// $img = 'img/congratulation/'.choose_file("img/congratulation/");
		$img = choose_cvs_entry($_SESSION['congratulation_file']);
		echo '<br /><img src="'.$img.'">';
	}
	echo "</td></tr>";
	echo "</table>";
}


 
?>
