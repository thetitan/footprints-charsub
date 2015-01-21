<?php
/* FootPrints special character convention swap.
 * Name: class.ManageHistory.php
 * Type: Model.
 * Copyright: Innovadix Corp.
 * Developer: Alexandar Tzanov - atzanov@innovadix.com
 * Revised: 2013-11-06
 * Description: Core functionality - format string.
 */


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
?>