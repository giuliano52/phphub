<?php
/* Author: GD
 * Created: 20131129
 * Modified: 20131223
 *
 *
 */

require_once('conf.php');
require_once('quiz_emit_inc.php');
require_once('quiz_fnc_inc.php');
error_reporting(E_ALL);


 
// ------------------------- MAIN --------------------

initialize_session() ;
$cmd = isset($_REQUEST['cmd']) ? test_input($_REQUEST['cmd']) : "None";
$starting_question = (int)(isset($_REQUEST['starting_question']) ? test_input($_REQUEST['starting_question']) : 0);

// verifico se è stato selezionato prossimo o precedente e modifico di conseguenza il puntatore alle domande
//$next_starting_question = min($starting_question + $_SESSION['Num_question_per_page'],count($_SESSION['data_quiz'])-$_SESSION['Num_question_per_page']);
$next_starting_question = $starting_question + $_SESSION['Num_question_per_page'];
$previous_starting_question = max($starting_question - $_SESSION['Num_question_per_page'],0);


emit_header();

choose_cvs_entry($_SESSION['congratulation_file']);

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
	if (isset($_REQUEST['Nav']) && $_REQUEST['Nav'] == "Precedente")
		$starting_question = $previous_starting_question;
	elseif (isset($_REQUEST['Nav']) && $_REQUEST['Nav'] == "Prossimo")
		$starting_question = $next_starting_question;
	// verifico che lo starting question stia tra 0 e il numero totale di domande
	if ($starting_question < 0) 
		$starting_question = 0;
	if ($starting_question > $_SESSION['Num_question_total']-1) 
		$starting_question = $_SESSION['Num_question_total']-1;	

	cmd_quiz($_SESSION['Quiz_name'],$starting_question);
}

emit_footer();

if($debug == TRUE) {
	echo "<pre>";print_r($_SESSION); echo "</pre>";

}
 
?>
