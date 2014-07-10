<?php
/*
 * Author GD
 * Data: 20140617
 * Modified: 20140617
 */


function print_pre($obj) {
    /*
     * Print all the content of a variable with pre 
     */
    echo "<pre>";
    print_r($obj);
    echo "</pre>";
}

function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    // ordina un array multidimensionale tramite una colonna. 
   
    $sort_col = array();
    foreach ($arr as $key => $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}
