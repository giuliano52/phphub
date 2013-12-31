<?php
/* Author: GD
 * Created: 20131129
 * Modified: 20131227
 *
 *
 */
 
function emit_question($single_quiz_data,$question_index,$tab_index=1) {
	$answer = isset($single_quiz_data['answered_question']) ? $single_quiz_data['answered_question'] : "";
	echo "<tr><td>\n";
	echo emit_question_status($question_index);
	echo "</td>\n";
	echo "<td>\n";
	echo $single_quiz_data["question"];
	echo "</td>\n";
	echo "<td class=\"possible_answer\">\n";
	$response_type  = isset($single_quiz_data['response_type']) ? $single_quiz_data['response_type'] : $_SESSION['default_response_type'];
	if ($response_type == "options") {
		// Multiple Options 
		foreach ($single_quiz_data['possible_answer'] as $possible_answer) {
			$checked = ($answer == $possible_answer) ? " checked " : "";
			echo "\t";
			echo '<input type="radio" name="q_'.$question_index.'" value="'.$possible_answer.'" '.$checked.'>';
			echo $possible_answer;
			echo "<br>\n"; 
		}
	
	}
	else {
		$possible_answer = isset($single_quiz_data['answered_question']) ? $single_quiz_data['answered_question'] : "";
		$opt = "tabindex=$tab_index ";
		if ($tab_index==1)
			$opt .= "autofocus";
		echo "<input type=\"text\" name=\"q_$question_index\" value=\"$possible_answer\" $opt >";
	}
	
	echo "</td></tr>\n";
}

function emit_question_status($question_index) {
	// mostra le domande a cui si è risposto e quelle che mancano
	$content = "<table>\n";
	
	foreach  ($_SESSION['data_quiz'] as $id=>$single_question) {
		if ($id == $question_index) {
			$extra_stle = "outline: thin solid black;";
		}
		else {
			$extra_stle = "";
		}
		$content .= "<tr style=\"$extra_stle\" class=\"question_status\">\n";
		$content .= "\t<td><a href=\"?starting_question=$id\">".($id+1)."</a></td>";
		$content .= "<td><a href=\"?starting_question=$id\">";
		if (isset($single_question['answered_question'])) {
			$content .= '<img src="img/Circle-question-green.svg" height="30" />';	
		}
		else {
		
			$content .= '<img src="img/Circle-question-yellow.svg" height="30" />';	
		}
		
		$content .= "</a></td><tr>\n";
	}
	
	$content .= "</table>\n";
	return $content;

}

function emit_header() {
echo '<html>
<link rel="stylesheet" type="text/css" href="quiz.css">
<body>
';
echo "<h1>".$_SESSION['title']."</h1>";
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
		echo "<br /><br />\n";
		echo "Hai risposto a tutte le domande: Guarda i ";
		echo '<b><a href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?cmd=results">RISULTATI</a></b>';
	}
	else {
		echo "\n";
	//	echo '<input type="submit" value="Precedente" Name="Nav">';
		echo '<input type="submit" value="Prossimo" Name="Nav">';
		}
	echo "</form>\n";
	
}

function emit_footer() {
echo '<br /><br />';
echo '<br /><A href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?cmd=reset_quiz">RICOMINCIA</A>';
echo "\n</body>\n</html>";
}

function emit_result() {

	quiz_check_answer();
	
	$data_quiz =$_SESSION['data_quiz'];

	$num_question = count($data_quiz);


	echo '<table border="1">';
	echo '<tr ><td>';
	echo '<table border="1">';
	for($question_index = 0; $question_index < $num_question; ++$question_index) {
		$answer  = $data_quiz[$question_index]["answered_question"];
		$correct_answer = $data_quiz[$question_index]["all_correct_answer"][0];
		echo '<tr>';
		echo '<td>'.$data_quiz[$question_index]["question"].'</td>';

		if ($data_quiz[$question_index]['answer_is_correct']) {
			// Correct answer
			echo '<td style="background-color:green;">';
			echo $answer;
			echo "</td>\n";

			}
		else {
			// wrong answer
			echo '<td style="background-color:red;">';
			echo "Hai risposto : <b>$answer</b><br />";
			echo "Ma la risposta giusta era: <b>$correct_answer</b><br />";
			echo "</td>\n";
		}
		echo '</tr>';
	}
	echo "</table>\n";
	echo "</td><td style=\"vertical-align:top;\">";
	echo 'hai risposto giusto '.$_SESSION['num_correct_answer'].' su '.$num_question.' domande';
	if($_SESSION['num_correct_answer'] == $num_question) {
		// $img = 'img/congratulation/'.choose_file("img/congratulation/");
		$img = choose_cvs_entry($_SESSION['congratulation_file']);
		echo "<br /><img src=\"$img\">\n";
		//echo "<br />$img\n";
	}
	echo "</td></tr>";
	echo "</table>";
}


 
?>
