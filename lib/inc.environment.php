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

// Manage History //
// Read history from file.
define('CACHE_FILE', "{$_SERVER['DIR_CACHE']}fpcharswap-cache.txt");
$cacheData = @file(CACHE_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Generate history view.
if ($cacheData && !empty($cacheData))
{
    $history = '<ul>';
    
    foreach ($cacheData as &$historyItem)
    {
        $history .= "<li>$historyItem</li>";
    }
    
    $history .= '</ul>';
}

// Updated history file.
function update_history($newString = '', $currentCacheData)
{
    if (!empty($newString))
    {
        // Make sure we are not passing a boolean to the function.
        if (!isset($currentCacheData) || !is_array($currentCacheData))
        {
            $currentCacheData = array();
            $currentCacheData[] = $newString;
        }
        else
        {
            array_unshift($currentCacheData, $newString);
        
            // Trim the array if more than 10 elemnts
            if (sizeof($currentCacheData) >= 10)
            {
                while (sizeof($currentCacheData) >= 10)
                {
                    array_pop($currentCacheData);
                }
            }
        }
        
        // Update cache file
        $fileData = '';
        
        foreach ($currentCacheData as &$historyItem)
        {
            $fileData .= "$historyItem\n";
        }
        
        // Save cache data
        $header = fopen(CACHE_FILE, "w");
        fwrite($header, $fileData);
        fclose($header);
    }
}

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
$formatString = (isset($_POST['formatString']) && !empty($_POST['formatString'])) ? $_POST['formatString'] : '';

if (!empty($actionType) && !empty($formatString))
{
    $formatedString = fp_char_swap($actionType, $formatString);
    update_history($formatedString, $cacheData);
}
elseif (!empty($actionType) && empty($formatString))
{
    $formatedString = "<span style=\"color: red;\">ERROR: Did not receive a string to format!</span>";
}
?>