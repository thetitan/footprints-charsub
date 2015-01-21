<?php
/* FootPrints special character convention swap.
 * Copyright: Innovadix Corp.
 * Developer: Alexandar Tzanov - atzanov@innovadix.com
 * Released: 2013-10-29
 * Revised: 2013-08-17
 * Description: This form will encript and decrypt strings based on BMC
 * FootPrints special character requirements.
 */

// Show all errors on the screen. 
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Initiate user session and retrieve the formated string.
session_start();
$formattedString = (isset($_SESSION['formattedString']) && !empty())

// Declare and define constants.
$workPath = getcwd();
define("DIR_LIB", $workPath."lib/");

?>