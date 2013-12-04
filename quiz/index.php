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
$_SESSION['Num_question_total'] = 2 ;  // 0 means no limits
//$_SESSION['Quiz_name'] = 'quiz_bandiere.csv';
$_SESSION['Quiz_name'] = 'quiz_capitali.csv';

$cmd = isset($_REQUEST['cmd']) ? test_input($_REQUEST['cmd']) : "None";

// add answer to session 
foreach($_REQUEST as $single_request) {
	print ($_single_request);
}



emit_header();

switch($cmd) {
    case "result":
        emit_result();
		session_destroy();
	break;

	
    default:
	cmd_quiz($_SESSION['Quiz_name']);
}

emit_footer();
 
?>
