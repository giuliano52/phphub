<?php
/* Author: GD
 * Created: 20131129
 * Modified: 20131129
 *
 *
 */
error_reporting(E_ALL);

$NUM_OPTIONS = 3;
 
 
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
		
		echo '<input type="radio" name="q_id'.$single_quiz_data['question_index'].'" value="'.$key_answer.'">';
		echo $data_quiz[$key_answer]["Capitale"];
		echo "<br>\n"; 
		}
	echo "</td></tr></table>";

}

function emit_header() {
echo '<html>
<body>
<form action="result.php" method="get">
';
}

function emit_footer() {
echo '
<input type="submit" value="Submit">
</form>
</body>
</html>
';
}


// ------------------------- MAIN --------------------


emit_header();

$data_quiz=csv_to_array('quiz1.csv');
shuffle($data_quiz);



for($question_index = 0; $question_index < count($data_quiz); ++$question_index) {
	
	$single_quiz_data['question_index']=$question_index;
	$single_quiz_data['answers'] = array_rand($data_quiz, $NUM_OPTIONS);
	
	shuffle($single_quiz_data['answers']);	
	if (!in_array($question_index, $single_quiz_data['answers'])) {
		$single_quiz_data['answers'][0]=$question_index;
		shuffle($single_quiz_data['answers']);
		}
		
	
	emit_question($data_quiz,$single_quiz_data);

}

emit_footer();
 
?>
