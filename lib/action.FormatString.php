<?php
/* FootPrints special character convention swap.
 * Name: action.formatString.php
 * Type: Model.
 * Copyright: Innovadix Corp.
 * Developer: Alexandar Tzanov - atzanov@innovadix.com
 * Revised: 2013-11-06
 * Description: Core functionality - format string.
 */

session_start();

 // Process Request
function fp_char_swap($direction, $dbString = '')
{
    $specialChars = array(' ','\'','"','`','@','.','-',';',':',')','(','#','$','%','^','&','*','~','/','\\','?',']','[','>','<','!','{','}','=','+','|',',');
    $specialCharsSub = array('__b','__a','__q','__t','__m','__d','__u','__s','__c','__p','__P','__3','__4','__5','__6','__7','__8','__0','__f','__F','__Q','__e','__E','__g','__G','__B','__W','__w','__C','__A','__I','__M');
    
    // If a string was provided continue with the character substitution.
    if (!empty($dbString))
    {
        if ($direction == 'Encode')
        {
            for ($i = 0; $i < sizeof($specialChars); $i++)
            {
                $dbString = str_replace($specialChars[$i], $specialCharsSub[$i], $dbString);
            }
        }
        elseif ($direction == 'Decode')
        {
            for ($i = 0; $i < sizeof($specialCharsSub); $i++)
            {
                $dbString = str_replace($specialCharsSub[$i], $specialChars[$i], $dbString);
            }
        }
    }
    
    return $dbString;
}

// Process form
$actionType = (isset($_POST['actionType']) && !empty($_POST['actionType'])) ? $_POST['actionType'] : '';
$newFormatString = (isset($_POST['formatString']) && !empty($_POST['formatString'])) ? $_POST['formatString'] : '';

// Confirm data is supplied.
if (!empty($actionType) && !empty($newFormatString))
{
	// Check if there are space in the string when decoding.
	if ($actionType == "Encode")
	{
		
	}
	// If the string is not already encoded, process request.
	else
	{
		$formattedString = fp_char_swap($actionType, $newFormatString);
	}
    
}
// Return error of data missing.
elseif (!empty($actionType) && empty($newFormatString))
{
    $formattedString = "<span style=\"color: red;\">ERROR: Did not receive a string to format!</span>";
}

// Updated the session and back to the form.
$_SESSION['formattedSting'] = $formattedString;
header("Location: ./index.php");
?>