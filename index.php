<?php
/* FootPrints special character convention swap.
 * Copyright: Innovadix Corp.
 * Developer: Alexandar Tzanov - atzanov@innovadix.com
 * Released: 2013-04-11
 * Revised: 2013-08-17
 * Description: This form will encript and decrypt strings based on BMC FootPrints
 * 	special character requirements.
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
?><!DOCTYPE html>
<html>
<head>
	<title>FootPrints Special Character Swap</title>
	<meta name="keywords" content="BMC, Numara, FootPrints, special characters, swap, replace">
	<meta name="author" content="Innovadix Corp.">
	<meta name="description" content="A tool to encode and decore strings with FootPrints special character requerments.">
<script>
// Function to check if value is empty
function validate_required(field,alerttxt)
{
	with (field)
	{
		if (value==null||value=="")
		{
			alert(alerttxt);
			return false;
		}
		else
		{
			return true;
		}
	}
}

// Check to see if all required fields are populated
function validate_form(thisform)
{
	with (thisform)
	{
		if (validate_required(actionType, "Please indicate if you want the string Encoded or Decoded.") == false)
		{
			actionType.focus();
			return false;
		}
		if (validate_required(formatString, "Please enter the string you would like formatted.") == false)
		{
			formatString.focus();
			return false;
		}
	}
}
</script>
</head>

<body style="background-color: #5e3a72;">
    <div style="width: 800px; margin: 20px auto 20px auto; background-color: white; border: 2px solid gray; padding: 10px;">
        <center><h1>FootPrints Special Character Swap</h1></center>
        <hr>
        <p>This is a tool to help encode and decode strings using FootPrints special character conventions.</p>
        <p>Example of a few instances when you would need to use this tool are when you are sending emails to FootPrints, or creating services and categories.</p>
        <hr>
        <form name="fpsc-format" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validate_form(this);">
            <p>Format Action: 
                <select name="actionType" id="actionType">
                    <option value="" selected="yes"></option>
                    <option value="Encode">Encode</option>
                    <option value="Decode">Decode</option>
                </select>
            </p>
            <p>Format String:
                <input type="text" name="formatString" id="formatString" size="50" />
            </p>
            <input type="submit" name="format" id="submit" value="Format" />
        </form>
        <?php
        if (isset($formatedString) && !empty($formatedString))
        {
            echo "<hr>";
            echo "<h2>Results</h2>";
            echo "<p style=\"font-weight: bold; text-align: center; font-size: 18px; margin-bottom: 10px;\">$formatedString</p>";
        }
        if (isset($history) && !empty($history))
        {
            echo "<hr>";
            echo "<h2>History</h2>";
            echo "<p>Below are the last ten formatted strings:</p>";
            echo $history;
        }
        ?>
        <hr>
        <!--p style="text-align: right; font-size: 12px;"><a href="mailto:support@?Subject=FootPrints%20char%20tool">Feedback</a></p-->
        <p>Copyright &copy; 2013 Innovadix Corp. All rights reserved.</p>
    </div>
</body>
</html>