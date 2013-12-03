<?php
/* Author: GD
 * Created: 20131129
 * Modified: 20131129
 *
 *
 */
error_reporting(E_ALL);

 
function csv_to_array($filename='', $delimiter=';')
{
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

function emit_question($data_quiz,$single_quiz_data) {

	echo '<table border="1">';
	echo "<tr><td>\n";
	echo $data_quiz[$single_quiz_data['question_index']]["Nazione"];
	echo "</td>\n<td>";
	foreach ($single_quiz_data['answers'] as $key_answer) {
		
		echo '<input type="radio" name="q_'.$single_quiz_data['question_index'].'" value="'.$data_quiz[$key_answer]["Capitale"].'">';
		echo $data_quiz[$key_answer]["Capitale"];
		echo "<br>\n"; 
		}
	echo "</td></tr></table>";

}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
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
';
}


function emit_quiz_footer() {
echo '
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


function cmd_quiz() {
	emit_quiz_header();
	$data_quiz=csv_to_array('quiz1.csv');
	shuffle($data_quiz);

	for($question_index = 0; $question_index < count($data_quiz); ++$question_index) {
	
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

function emit_result() {
	
	
	$data_quiz =$_SESSION['data_quiz'];
	$num_correct_answer = 0;
	$num_wrong_answer = 0;
	
	echo '<table border="1">';
	for($question_index = 0; $question_index < count($data_quiz); ++$question_index) {
		$answer = test_input($_REQUEST['q_'.$question_index]);
		$correct_answer = $data_quiz[$question_index]['Capitale'];
		echo '<tr>';
		echo '<td>'.$data_quiz[$question_index]['Nazione'].'</td>';

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


// ------------------------- MAIN --------------------

session_start(); 

$_SESSION['Num_options'] = 3;

$cmd = isset($_REQUEST['cmd']) ? test_input($_REQUEST['cmd']) : "None";

// add answer to session 
foreach($_REQUEST as $single_request) {
	print ($_single_request);
}



emit_header();

switch($cmd) {
    case "result":
        emit_result();
	break;
    default:
	cmd_quiz();
}

emit_footer();
 
?>
