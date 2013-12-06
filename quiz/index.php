<?php
/* Author: GD
 * Created: 20131129
 * Modified: 20131129
 *
 *
 */
require_once('quiz_emit_inc.php');
require_once('quiz_fnc_inc.php');
error_reporting(E_ALL);


function initialize_session() {
	session_start(); 

	$_SESSION['Num_options'] = 5;
	$_SESSION['Num_question_per_page'] = 1 ;  // 0 means no limits
	$_SESSION['Num_question_total'] = 3 ;  // 0 means no limits
	$_SESSION['min_diffucult_level'] = 0; // min 0
	$_SESSION['max_diffucult_level'] = 100; // max 100
	$_SESSION['Quiz_name'] = 'quiz_bandiere.csv';
	$_SESSION['Quiz_name'] = 'quiz_capitali.csv';

}
 
// ------------------------- MAIN --------------------

initialize_session() ;
$cmd = isset($_REQUEST['cmd']) ? test_input($_REQUEST['cmd']) : "None";
$starting_question = (int)(isset($_REQUEST['starting_question']) ? test_input($_REQUEST['starting_question']) : 0);

// verifico se è stato selezionato prossimo o precedente e modifico di conseguenza il puntatore alle domande
//$next_starting_question = min($starting_question + $_SESSION['Num_question_per_page'],count($_SESSION['data_quiz'])-$_SESSION['Num_question_per_page']);
$next_starting_question = $starting_question + $_SESSION['Num_question_per_page'];
$previous_starting_question = max($starting_question - $_SESSION['Num_question_per_page'],0);

if (isset($_REQUEST['Nav']) && $_REQUEST['Nav'] == "Precedente")
	$starting_question = $previous_starting_question;
elseif (isset($_REQUEST['Nav']) && $_REQUEST['Nav'] == "Prossimo")
	$starting_question = $next_starting_question;

emit_header();

switch($cmd) {
    case "reset_quiz";
		cmd_reset_quiz();
		initialize_session() ;
		cmd_quiz($_SESSION['Quiz_name'],$starting_question);
	break;
    case "results":
        emit_result();
	break;
    case "store_answers":
        cmd_store_answers();
    default:
		cmd_quiz($_SESSION['Quiz_name'],$starting_question);
}

emit_footer();
 
?>
