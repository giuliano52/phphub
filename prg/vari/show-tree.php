<?php
/*
 * Mostra un albero (in particolare i tag dei libri )
 *              I dati vengono presi da un csv file (datahub/varie/Tag-Libri.csv) e mostrati ad albero
 * Autore: GD
 * Data inizio: 20140616
 * Data modifica: 20140617
 */

require_once(__DIR__ . '/../../lib/csv_gd.class.php');
require_once(__DIR__ . '/../../lib/common.lib.php');

$csv_filename = __DIR__ . '/../../../datahub/varie/Tag-Libri.csv';


$data_tree = new csv_gd($csv_filename);
$data_tree_array = $data_tree->csv_to_array();
array_sort_by_column($data_tree_array, 'TAG_inglese');

//print_pre($data_tree_array);

function emit_TreeView($in_array, $parent) {
    echo '<ul>';
    foreach ($in_array as $row) {
        if ($row['TAG_inglese'] != '') {
            if ($row['Tag_Padre'] == $parent) {
                echo '<li>' . $row['TAG_inglese'] . ' - ' . $row['TAG_Italiano'] . '</li>';
                emit_TreeView($in_array, $row['TAG_inglese']);
            }
        }
    }
    echo '</ul>';
}
?>
<html>
    <head>
        <title>Show TREE</title>
        <meta charset="UTF-8">
        <style>

            body
            {
                font-family: arial, helvetica, sans-serif;
                font-size: 70%;
            }
        </style>


    </head>
    <body>
        (in calibre usare sempre quello inglese) I tag sono presi principalmente da http://it.feedbooks.com

        <?php
        emit_TreeView($data_tree_array, '');
        ?>
    </body>
</html>


