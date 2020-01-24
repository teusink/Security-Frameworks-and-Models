<html>
<head>
<title>Input validation for web-applications, how to process input safely and securely</title>
</head>
<body>
<?php
// Function to clean input from al its tags
function strip_html_tags($text) {
	// PHP's strip_tags() function will remove tags, but it
	// doesn't remove scripts, styles, and other unwanted
	// invisible text between tags.  Also, as a prelude to
	// tokenizing the text, we need to insure that when
	// block-level tags (such as <p> or <div>) are removed,
	// neighboring words aren't joined.
	$text = preg_replace(
		array(
			// Remove invisible content
			'@<head[^>]*?>.*?</head>@siu',
			'@<style[^>]*?>.*?</style>@siu',
			'@<script[^>]*?.*?</script>@siu',
			'@<object[^>]*?.*?</object>@siu',
			'@<embed[^>]*?.*?</embed>@siu',
			'@<applet[^>]*?.*?</applet>@siu',
			'@<noframes[^>]*?.*?</noframes>@siu',
			'@<noscript[^>]*?.*?</noscript>@siu',
			'@<noembed[^>]*?.*?</noembed>@siu',

			// Add line breaks before & after blocks
			'@<((br)|(hr))@iu',
			'@</?((address)|(blockquote)|(center)|(del))@iu',
			'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
			'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
			'@</?((table)|(th)|(td)|(caption))@iu',
			'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
			'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
			'@</?((frameset)|(frame)|(iframe))@iu',
		),
		array(
			' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
			"\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
			"\n\$0", "\n\$0",
		),
		$text);

	// Remove all remaining tags and comments and return.
	return strip_tags($text);
}

// Function to truncate input to a maximum number of chars
function truncate_chars($text, $limit, $ellipsis = '') { // $ellipsis if you want have trailing dots (...) or something like that
	if( strlen($text) > $limit ) {
		$endpos = strpos(str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $text), ' ', $limit);
		if($endpos !== FALSE)
			$text = trim(substr($text, 0, $endpos)) . $ellipsis;
	}
	return $text;
}

/*	Step 1: Check if the input is actually sent and received
		With isset we can check if there is input, before grabbing it,
		to prevent a null error.
*/
if (isset($_POST['nameField']) &&
	isset($_POST['emailField']) &&
	isset($_POST['passwordField']) &&
	isset($_POST['repeatPasswordField'])) { // (required fields first)
	
	/*	Step 2: Store input in memory, separate it from the source
			Remove scripts from input and save it in a separate variable.
		
		Step 3: Check variable for, and remove all scripting
			All kinds of script tags are removed from the code. See more
			details in the function above this code.
	*/
	$nameField = strip_html_tags($_POST['nameField']);
	$emailField = strip_html_tags($_POST['emailField']);
	$passwordField = strip_html_tags($_POST['passwordField']);
	$repeatPasswordField = strip_html_tags($_POST['repeatPasswordField']);
	
	if (isset($_POST['dateField'])) {  // (and here the non-required fields)
		$dateField = strip_html_tags($_POST['dateField']);
	} else {
		$dateField = "";
	}
	if (isset($_POST['urlField'])) {  // (and here the non-required fields)
		$urlField = strip_html_tags($_POST['urlField']);
	} else {
		$urlField = "";
	}
	
	/*	Step 4: Trim the variable
			Remove all trailing and preceding spaces from input (no use in keeping them).
			You can skip this code if you do not want sanitization, we do a regular
			expression match in the code later.
	*/
	$nameField = trim($nameField);
	$emailField = trim($emailField);
	$passwordField = trim($passwordField);
	$repeatPasswordField = trim($repeatPasswordField);
	$dateField = trim($dateField);
	$urlField = trim($urlField);
	
	/*	Step 5: Truncate the variable to the maximum size of expected value
			Break the variable to its maximum designated size  to make sure that you
			don't create a buffer overflow.
			You can skip this code if you do not want sanitization, we do a regular
			expression match in the code later.
	*/
	$nameField = truncate_chars($nameField, 50);
	$emailField = truncate_chars($emailField, 254);
	$passwordField = truncate_chars($passwordField, 16);
	$repeatPasswordField = truncate_chars($repeatPasswordField, 16);
	$dateField = truncate_chars($dateField, 10);
	$urlField = truncate_chars($urlField, 254);
	
	/*	Now we are going to repeat steps 4 and 5 and do step 6.
		If you don't want to do the steps 4 and 5 above, you for sure need to
		do them below!
		
		Step 6: Check if it is the correct variable type and/or format
			Checking for correct data (format) in input.
	*/
	if (preg_match("/^.{1,50}$/", $nameField) &&
		preg_match("/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b/", $emailField) &&
		preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,16}$/", $passwordField) &&
		preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,16}$/", $repeatPasswordField) &&
		(preg_match("/^(19|20)\d\d[- \/.](0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])$/", $dateField) || $dateField == "") &&
		(preg_match("/(^http:\/\/.{7,254})|(^https:\/\/.{7,254})/", $urlField) || $urlField == "") &&
		$passwordField == $repeatPasswordField) {
		
		// And we repeat step 6 here, by sanitizing the variables by using a PHP function
		$emailField = filter_var($emailField, FILTER_SANITIZE_EMAIL);
		$urlField = filter_var($urlField, FILTER_SANITIZE_URL);
		
		/*
			Step 7: Check if it is expected content (also called white listing)
				Not relevant in this example.
				
			Step 8: When relevant, check existence of local resources
				Not relevant in this example.
				
			Step 9: And now is it input for the process
				Yes, all done and all well. We can now safely echo the values in oblivion!
		*/
		?><h1>Received values</h1>
		<p><?php
			echo 'Name: '.$nameField.'<br />';
			echo 'Email: '.$emailField.'<br />';
			echo 'Password: '.$passwordField.'<br />';
			echo 'Password repeated: '.$repeatPasswordField.'<br />';
			echo 'Birthdate: '.$dateField.'<br />';
			echo 'Website: '.$urlField.'<br />';
		?></p><?php
		
	} else {
		?><p>Not all fields are in proper format or passwords do not match.</p><?php
	}
} else {
	?><p>Not all required fields are received.</p><?php
}
?>
</body>
</html>