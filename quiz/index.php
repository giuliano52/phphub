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
 
// ------------------------- MAIN --------------------
session_start(); 


$_SESSION['Num_options'] = 3;
$_SESSION['Num_question_per_page'] = 0 ;  // 0 means no limits
$_SESSION['Num_question_total'] = 5 ;  // 0 means no limits
$_SESSION['Quiz_name'] = 'quiz_bandiere.csv';
//$_SESSION['Quiz_name'] = 'quiz_capitali.csv';

$cmd = isset($_REQUEST['cmd']) ? test_input($_REQUEST['cmd']) : "None";
$starting_question = isset($_REQUEST['starting_question']) ? test_input($_REQUEST['starting_question']) : 0;


emit_header();

switch($cmd) {
    case "reset_quiz";
	cmd_reset_quiz();
	break;
    case "results":
        emit_result();
	break;
    case "store_answers":
        cmd_store_answers();
    default:
	cmd_quiz($_SESSION['Quiz_name'],0);
}

emit_footer();
 
?>
