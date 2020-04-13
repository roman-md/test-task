<?php

require_once 'include/dBug.php';


function writeToLog($data, $title = '')
{
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
    $log .= print_r($data, 1);
    $log .= "\n------------------------\n";
    file_put_contents( $_SERVER['DOCUMENT_ROOT'].'/log1.txt', $log, FILE_APPEND);
    //file_put_contents( __FILE__.'/log.txt', $log, FILE_APPEND);
    return true;
}

require_once 'include/consts.php';
require_once 'include/events.php';
