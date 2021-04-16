<?php

if (!isset($index_loaded)) {
    die('Direct access to this file is forbidden');
}
/*
 * this file contains misc utility functions
 */

/**
 * Displays any array 1 dimension direct to screen.
 */
function arrayDisplay($arrayName)
{
    echo'<style> td,th{
        border:1px solid black;}</style>';
    echo'<table >';
    echo'<tr>';
    echo'<th>Key </th>';
    echo'<th>Value</th>'.'<br>';
    echo'</tr>';
    foreach ($arrayName as $key => $value) {
        echo'<tr>';
        echo"<td>$key</td>";
        echo"<td>$value</td>";
        echo'</tr>';
    }
    echo'</table>';
}

function array_HTML_Products($arrayName)
{
    $r = '';

    $r .= '<table >';
    $r .= '<tr>';
    $r .= '<th>id </th>';
    $r .= '<th>name</th>';
    $r .= '<th>description</th>';
    $r .= '<th>price</th>';
    $r .= '<th>pic</th>';
    $r .= '<th>stock</th>';
    $r .= '</tr>';
    foreach ($arrayName as $key => $value) {
        $r .= '<tr>';
        $r .= '<td>'.$value['id'].'</td>';
        $r .= '<td>'.$value['name'].'</td>';
        $r .= '<td>'.$value['description'].'</td>';
        $r .= '<td>'.$value['price'].'</td>';
        $r .= '<td>'.$value['pic'].'</td>';
        $r .= '<td>'.$value['qty_in_stock'].'</td>';
        $r .= '</tr>';
    }
    $r .= '</table>';

    return $r;
}

function array_to_HTML_table($array_name)
{
    //alternative for border
    $r = '';
    $r .= '<style> td,th{border:1px solid black;}</style>';
    $r .= '<table border=1>';
    $r .= '<tr>';
    $r .= '<th>index/key</th>';
    $r .= '<th>value</th>';
    $r .= '<tr>';

    foreach ($array_name as $key => $value) {
        $r .= '<tr>';
        $r .= '<td>';
        $r .= "$key <br>";
        $r .= '</td>';
        $r .= '<td>'.$value.'<br>'.'</td>';
        $r .= '</tr>';
    }
    $r .= '</table>';

    return $r;
}

function crash($code, $message)
{
    http_response_code($code);

    //here email to IT admin
    // mail(ADMIN_EMAIL,COMPANY_NAME."Server crashed code=".$code,$message);
    // write in log file
    $file = fopen('logs/errors.log', 'a+');
    $time_info = date('d-M-Y h:i:s');
    fwrite($file, $message.'<br>');
    fclose($file);

    die($message);
}

function table_display($arrayProducts)//table display
{
    $r = '';
    // $r .= '<style> td,th{
    //     border:1px solid black;}</style>';
    $r .= '<table class="tab" >';
    if (count($arrayProducts) == 0) {
        return 'table is empty';
    }
    $col_names = array_keys($arrayProducts[0]);
    $r .= '<tr>';
    foreach ($col_names as $col) {
        $r .= '<th>'.$col.'</th>';
    }
    $r .= '</tr>';
    foreach ($arrayProducts as $row) {
        $r .= '<tr>';
        foreach ($col_names as $col) {
            $r .= '<td>'.$row[$col].'</td>';
        }
        $r .= '</tr>';
    }
    $r .= '</table>';

    return $r;
}
