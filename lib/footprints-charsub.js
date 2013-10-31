/* FootPrints special character convention swap.
 * Copyright: Innovadix Corp.
 * Developer: Alexandar Tzanov
 * Released: 2013-10-29
 * Revised: 2013-08-17
 * Description: This form will encript and decrypt strings based on BMC
 * FootPrints special character requirements.
 */

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