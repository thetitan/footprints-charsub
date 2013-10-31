<?php
require_once("./lib/inc.environment.php");
?><!DOCTYPE html>
<html>
<head>
	<title>FootPrints Special Character Swap</title>
	<meta name="keywords" content="BMC, Numara, FootPrints, special characters, swap, replace">
	<meta name="author" content="Innovadix Corp.">
	<meta name="description" content="A tool to encode and decore strings with FootPrints special character requerments.">
    
    <link href="./lib/footprints-charsub.css" media="screen" type="text/css" rel="stylesheet">
    <script src="./lib/footprints-charsub.js" type="text/javascript"></script>
</head>

<body>
    <div class="wrapper">
        <div id="header">
            <h1>FootPrints Special Character Swap</h1>
        </div>
        <header id="introduction">
            <p>This is a tool to help encode and decode strings using FootPrints special character conventions.</p>
            <p>Example of a few instances when you would need to use this tool are: when sending an auto-assign emails to FootPrints; creating services and categories; developing a subroutine to use the SOAP API.</p>
        </header>
        <section id="form-view">
            <form name="fpsc-format" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validate_form(this);">
                <p><label for="actionType">Format Action</lebel>:&nbsp;
                    <select name="actionType" id="actionType">
                        <option value="" selected="yes"></option>
                        <option value="Encode">Encode</option>
                        <option value="Decode">Decode</option>
                    </select>
                </p>
                <p><label for="formatString">Format String</label>:&nbsp;
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
            ?>
        </section>
        <section id="cache-view">
            <?php
            if (isset($history) && !empty($history))
            {
                echo "<hr>";
                echo "<h2>History</h2>";
                echo "<p>Below are the last ten formatted strings:</p>";
                echo $history;
            }
            ?>
        </section>
    </div>
    <div class="wrapper">
        <footer>
            <p>Copyright &copy;<?php print date("Y"); ?> <a href="http://www.innovadix.com/">Innovadix Corp.</a> All rights reserved.</p>
        </footer>
    </div>
</body>
</html>