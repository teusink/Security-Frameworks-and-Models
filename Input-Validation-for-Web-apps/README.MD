# Input validation for web-applications, how to process input safely and securely

In this repository I will talk about input validation for
web-applications. Input validation is a process that gets the input from the
source (user, database, textfile, et cetera), checks it for any faulty and nasty
and sneaky contents, and then sends it to the process that needs the input.

Input validation is not only about security. It is also about building
user-friendly applications (a message when the data-entry does not comply) and
keeping data consistency (all data is stored in the same format).

In example, you can choose to store all dates in yyyy-mm-dd format in your
database. When you make sure you do that, you can easily analyze and generate
statistics of the data in your database. When a user of the system enters data
in a wrong format, you can either automatically change it (sanitizing), or send
a message to the user to enter it in the correct format.

The first all about the process of input validation. Part
two and and three will contain code examples from PHP and JavaScript for every
relevant step in the process.

## 1. Process

### 1.1 OWASP

But first, lets take a look at OWASP. It stands for Open Web Application
Security Project. Their mission is to improve security of software. Short and
fairly simple statement, but a very important one. They also track down the most
often used (or rather misused) vulnerabilities that are present in (sometimes
poorly) written software. This is the list with the [top 10 vulnerabilities in
2013](https://www.owasp.org/index.php/Top10#OWASP_Top_10_for_2013).

1.  Injection
1.  Broken Authentication and Session Management
1.  Cross-Site Scripting (XSS)
1.  Insecure Direct Object References
1.  Security Misconfiguration
1.  Sensitive Data Exposure
1.  Missing Function Level Access Control
1.  Cross-Site Request Forgery (CSRF)
1.  Using Components with Known Vulnerabilities
1.  Unvalidated Redirects and Forwards

From that list the following vulnerabilities can be mitigated with proper input
validation.

1.  Injection
1.  Cross-Site Scripting (XSS)

Two out of the top three of the most often seen vulnerabilities can be mitigated
with proper input validation. That is how important this topic is. Please bare
in mind that with input validation alone you will not be secure, but it is a big
step forward.

### 1.2 Input validation Steps

I believe that you need to follow a certain protocol for every input you will
process in your application. In my experience the following steps needs to be
done.

1.  **Check if the input is actually sent and received**<br> This check is to
prevent any “null” or “not defined” errors when you execute step 2 in this
process. If there is no (required) value being sent, the process can and should
stop here.
1.  **Store input in memory, separate it from the source**<br> Store the input in
memory, for example a variable (no permanent storage!). This is to separate the
input you are going to check from the actual source of the input. When you don’t
do this, the attacker might alter the data later in the process.
1.  **Check variable for, and remove all scripting**<br> In this part we check the
variable for scripting. Scripts in input variables might cause havoc on systems
but injecting malicious code.
1.  **Trim the variable**<br> Trimming is a process to remove all preceding and
trailing spaces, tabs, and more of a variable. This keeps data in the database
clean and helps with preventing a buffer overflow. Buffer overflow happens when
you want to store a variable in a record, but the record is smaller than the
variable and thus resulting in a buffer overflow which can be misused by an
attacker.
1.  **Truncate the variable to the maximum size of expected value**<br> This is the
second step in preventing a buffer overflow. When all the spaces are gone, you
will discard all data in the variable that exceeds the maximum storage of that
record and its attributes. This step might be optional when you are processing
data in text form, but think about this step thoroughly and carefully.
1.  **Check if it is the correct variable type and/or format**<br> This step will
check if you got the the type of variable you are expecting and if it is in the
right format. Do you only expect a numeric value? Or do you expect a string? But
also consider date-formats, URLs, and email addresses. This is the place to
check for it. When incorrect you can either drop the input or convert it
(sanitizing) to the proper type.
1.  **Check if it is expected content (also called white listing)**<br> This is an
important and probably most difficult step to work out in the code when handling
specific data. For example, in some cases you might expect an URL which always
precedes with “https://www.google.com/". So when you have received and processed
your input, the last step is to check if you see that the variable meets your
requirements. This is a content-specific check to prevent unauthorized data
being send to your application. This can be different for every type of input in
your application.
1.  **When relevant, check existence of local resources**<br> This step is probably
only relevant when you are processing input that is pointing to local resources.
Think about files an user can upload, or an URL you convert to a local resource.
In these cases, always check if the resource (file, database, etc) exists,
before actually accessing it. The reason that this step is at the end, is to
prevent malicious code being executed when you access the local resources on
your web- or application servers.
1.  **And now is it input for the process**<br> All checks are done, it is safe (as
it can be) to process the input. This can be storing it in the database or
presenting it the Graphical User Interface of your application. Don’t forget to
close the connection or resources you accessed in your entire process when you
don’t need it anymore.

**Note**: You can either check for invalid input and correct it (sanitizing), or
reject it. What the best situation is for your application depends entirely on
the use-case. Just keep this in mind.

When this needs to be done? Well, that is simple. This process needs to be
**executed every time** you receive input. Every time. Never ever trust input
and never ever ever trust user generated input. I cannot emphasize this enough
:). It seems an open door, but again, think about the top 3 OWASP
vulnerabilities.

You can do input validation on multiple levels. You can do input validation
back-end-side, but also front-end-side. For example, when you have an online form
that users are filling in and sending it to your application, you can and you
should do validation checks with every field a user fills in front-end-side. When
the data is submitted, you perform a back-end-side input validation.

This improves the user experience in your application, and it contributes to the
layered-defense principle. If the front-end-side defense layer fails (because the
attacker is circumventing the form or regular ways of submitting input), you
will have your second layer of defense ready, and that is the back-end-side input
validation.

### 1.3 Sources

Here are a couple of informative and useful sources you might want to check out.

* Open Web Application Security Project (OWASP) — [https://www.owasp.org/](https://www.owasp.org/)
* Open Sourced Vulnerability Database (OSVDB) — [https://osvdb.org/](https://osvdb.org/)
* TestingSecurity.com — [http://www.testingsecurity.com/](http://www.testingsecurity.com/)
* The importance of input validation, by Kevin Beaver — [http://searchsoftwarequality.techtarget.com/tip/The-importance-of-input-validation](http://searchsoftwarequality.techtarget.com/tip/The-importance-of-input-validation)

*****

## 2. Front-end-side

In the first part the entire process was explained. In this
post we are going to do some coding on the front-end-side, in this case JavaScript.

But keep in mind that the same principles apply to all programming languages.
Input validation is not only about security. It is also about building
user-friendly applications (a message when the data-entry does not comply) and
keeping data consistency (all data is stored in the same format). In example,
you can choose to store all dates in yyyy-mm-dd format in your database. When
you make sure you do that, you can easily analyze and generate statistics of the
data in your database.

When a user of the system enters data in a wrong format, you can either
automatically change it (sanitizing), or send a message to the user to enter it
in the correct format.

### 2.1 The Input Requirements

Let’s assume we will make a small register form with the most basic input
values. The following input is requested from the user, including all the
requirements of the input data.

* **Name (name and surname)**, Required field, Maximum length is 50 characters
* **E-mail address**, Required field, Needs to validate as email address
* **Password**, Required field, Requires at least one lower and one uppercase letter, one digit, no spaces and a length of 8–16 length, Must be same as repeat password
* **Repeat password**, Required field, Requires at least one lower and one uppercase letter, one digit, no spaces and a length of 8–16 length, Must be same as password
* **Birth-date**, Optional, Needs to validate as a proper date (mm/dd/yyyy)
* **Personal website**, Optional, Must validate as a proper URL, Only http and https is allowed

Very basic values of course, but good enough for the example throughout the
front-end-side and back-end-side input validation coding. It is very important to
first sit down with your co-workers about the requirements of the data, before
actually start coding.

### 2.2 Input validation Steps

For every step in the process we will look at what it might mean for JavaScript.
Some steps will not be required at all, some optional and some definitely
required.

1.  Check if the input is actually sent and received
1.  Store input in memory, separate it from the source
1.  Check variable for, and remove all scripting
1.  Trim the variable
1.  Truncate the variable to the maximum size of expected value
1.  Check if it is the correct variable type and / or format
1.  Check if it is expected content (also called white listing)
1.  When relevant, check existence of local resources
1.  And now is it input for the process

All steps will be explained in the code examples.

### 2.3 HTML First

On the front-end-side this step is not needed, but it might come in handy when you
are building user-friendly (intuitive) applications. So lets start with the
forms itself.

With the coming of HTML5 new field types are introduced, in addition to those
already available with HTML4. Make use of those new field types. You will also
notice the use of the pattern attribute in the input type element. Pattern makes
use of regular expressions to validate the data that is entered in the form.

You don’t need to worry about older browsers, as they gracefully degrade to
normal text fields. Down-side of this is that some or all controls might not
work anymore. So there will be still a need for JavaScript.

**HTML**
```
<html>
<head>
	<title>Input validation for web-applications, how to process input safely and securely</title>
	<script><!-- Javascript here --></script>
</head>
<body>
	
	<!--	In the example below you will see the use of:
			- required (whether a field is required or not)
			- maxlength (what the maximum size of the value may be)
			- pattern (regular expression)
			
			These are basic checks concerning input validation, where
			as the pattern is the most complex. Pattern is relatively new
			and might not be supported on all browsers. Hence the extra
			javascript checks that needs to be done also.
	-->
	
	<p id="errorMessage"></p>
	
	<h1>Form for input values</h1>
	
	<form name="testForm" action="example-back-end.php" onsubmit="return validateForm()" method="post">
	
		<label for="nameField">Name *</label>
		<input type="text" name="nameField" id="nameField" maxlength="50" placeholder="John Doe" pattern="^.{1,50}$" required>
		<p>Full or partial name or nickname, maximum of 50 characters</p>
		
		<label for="emailField">Email address *</label>
		<input type="email" name="emailField" id="emailField" maxlength="254" placeholder="john@doe.com" pattern="\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b" required>
		<p>Must be in format of john@doe.com</p>
		
		<label for="passwordField">Password *</label>
		<input type="password" name="passwordField" id="passwordField" maxlength="16" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,16}$" required>
		<p>Requires at least one lower and one upper case letter, one digit, no spaces and a length of 8 to 16</p>
		
		<label for="repeatPasswordField">Password *</label>
		<input type="password" name="repeatPasswordField" id="repeatPasswordField" maxlength="16" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,16}$" required>
		<p>Must be the same password as the one typed above</p>
		
		<label for="dateField">Birthdate</label>
		<input type="date" name="dateField" id="dateField" maxlength="10" placeholder="2000/12/31" pattern="^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$">
		<p>Must be in format of mm/dd/yyyy</p>
		
		<label for="urlField">Personal website</label>
		<input type="url" name="urlField" id="urlField" maxlength="254" placeholder="http://www.johndoe.com" pattern="(^http://.{7,254})|(^https://.{7,254})">
		<p>URL most start with http:// or https://</p>
		
		<input type="submit" value="Submit">
		
		<p>All fields with an asterisk (*) are required</p>
	
	</form>

</body>
</html>
```

### 2.4 JavaScript Second

Before submitting the data from the form to the webserver it is key to validate
it on the front-end-side first. This due to the various layers of defense. There is
the form validation, there is the JavaScript validation and there will be the
PHP (back-end sided) validation. You may not skip JavaScript if you think a
browser will support the new form elements. Always include this step.

**Javascript**
```
function validateForm() {
	/*	Step 1: Check if the input is actually sent and received
			This step is only done when sending data from the front-end to the back-end.
			So it holds no relevance here.
		
		Step 2: Store input in memory, separate it from the source
			Here we store all input in variables.
	*/
	var nameField = document.forms["testForm"]["nameField"].value,
		emailField = document.forms["testForm"]["emailField"].value,
		passwordField = document.forms["testForm"]["passwordField"].value,
		repeatPasswordField = document.forms["testForm"]["repeatPasswordField"].value,
		dateField = document.forms["testForm"]["dateField"].value,
		urlField = document.forms["testForm"]["urlField"].value,
		// To modify the error message on screen
		formError = true,
		errorMessage = document.getElementById("errorMessage"),
		
		/*	In the patterns below we check for the following steps.
			
			Step 3: Check variable for, and remove all scripting
				Besides using regular expression, we do not check for scripting
				here. For example, the nameField element is just being check
				if it does not exceed the 50 characters limit.
			
			Step 4: Trim the variable
				All regular expressions in this example have size limits.
			
			Step 5: Truncate the variable to the maximum size of expected value
				We do not use this step here. When the variable is to long, the
				expression will fail and return an error.
			
			Step  6: Check if it is the correct variable type and/or format
				This step is done here (correct date, email and url format)
		*/
		namePattern = new RegExp(/^.{1,50}$/),
		emailPattern = new RegExp(/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b/),
		passwordPattern = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,16}$/),
		datePattern = new RegExp(/^(19|20)\d\d[- \/.](0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])$/),
		urlPattern = new RegExp(/(^http:\/\/.{7,254})|(^https:\/\/.{7,254})/);
	
	errorMessage.innerHTML = "";
	/* In this step we are going to get all the values from the forms.
		We are going to test if there is content in them,
		and in case of the required fields, we are going to require
		the input.
	*/
	if (nameField === null || nameField === "" ||
			emailField === null || emailField === "" ||
			passwordField === null || passwordField === "" ||
			repeatPasswordField === null || repeatPasswordField === "") {
		errorMessage.innerHTML = "Not all required fields are filled in!";
		formError = false;
		
	} else {
		/*	Here we actually check if all input values matches the patterns
			and if the passwords are equal to each other or not.
		*/
		if (namePattern.test(nameField) !== true &&
				emailPattern.test(emailField) !== true &&
				passwordPattern.test(passwordField) !== true &&
				passwordPattern.test(repeatPasswordField) !== true &&
				(datePattern.test(dateField) !== true || dateField === null || dateField === "") &&
				(urlPattern.test(urlField) !== true || urlField === null || urlField === "") &&
				passwordField === repeatPasswordField) {
				
			errorMessage.innerHTML = "Not all fields are filled out correctly!";
			formError = false;
		} else {
			errorMessage.innerHTML = "All fields are filled in correctly";
			formError = true;
		}
		/*	
			Step 7: Check if it is expected content (also called white listing)
				This is not done in this example.
				
			Step 8: When relevant, check existence of local resources
				This is not done in this example (not relevant).
		*/
	}
	/*	Step 9: And now is it input for the process
			When formError becomes true, then all checks are done
			and the outcome is valid. The input values are now
			send to the server.
	*/
	return formError;
}
```

### 2.5 Sources

Here are a couple of informative and useful sources you might want to check out.

* JavaScript Form validation: [http://www.w3schools.com/js/js_form_validation.asp](https://www.w3schools.com/js/js_form_validation.asp)
* Regular Expressions 101: [https://regex101.com/](https://regex101.com/)
* Regex Test: [http://regexpal.com/](http://regexpal.com/)
* Regular Expressions Cheat Sheet by DaveChild: [http://www.cheatography.com/davechild/cheat-sheets/regular-expressions/](https://www.cheatography.com/davechild/cheat-sheets/regular-expressions/)
* RegExLib.com Cheat Sheet: [http://regexlib.com/CheatSheet.aspx](http://regexlib.com/CheatSheet.aspx)
* RegExLib.com: [http://regexlib.com/](http://regexlib.com/)

*****

## 3. Back-end-side

In the first part the entire process was explained. In the second part we did
some coding on the front-end-side, and now we will look in to back-end-side coding in
PHP. But keep in mind that the same principles apply to all programming
languages. Input validation is not only about security. It is also about
building user-friendly applications (a message when the data-entry does not
comply) and keeping data consistency (all data is stored in the same format).

In example, you can choose to store all dates in yyyy-mm-dd format in your
database. When you make sure you do that, you can easily analyze and generate
statistics of the data in your database. When a user of the system enters data
in a wrong format, you can either automatically change it (sanitizing), or send
a message to the user to enter it in the correct format.

### 3.1 Input validation Steps

For every step in the process we will look at what it might mean for JavaScript.
Some steps will not be required at all, some optional and some definitely
required.

1.  Check if the input is actually sent and received
1.  Store input in memory, separate it from the source
1.  Check variable for, and remove all scripting
1.  Trim the variable
1.  Truncate the variable to the maximum size of expected value
1.  Check if it is the correct variable type and / or format
1.  Check if it is expected content (also called white listing)
1.  When relevant, check existence of local resources
1.  And now is it input for the process

### 3.2 Back-end PHP

The back-end-sided code for input validation can be found below. In this situation
we use PHP and I will show two kinds of examples. One is the input validation
only and the other is input validation and sanitation. Keep in mind with
sanitation that when done on the back-end-side, you probably need it also on the
front-end-side (there is no point doing back-end-side only, as the user will face
input validation errors by the front-end-side validation).

That being said, all steps are explained in the code itself.

**PHP**
```
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
```

### 3.3 Sources

Here are a couple of informative and useful sources you might want to check out.

* PHP strip_tags:
[https://php.net/manual/en/function.strip-tags.php](https://php.net/manual/en/function.strip-tags.php)
* PHP preg_match:
[https://php.net/manual/en/function.preg-match.php](https://php.net/manual/en/function.preg-match.php)
* PHP filter_var:
[https://php.net/manual/en/function.filter-var.php](https://php.net/manual/en/function.filter-var.php)
* PHP form validation:
[http://www.w3schools.com/php/php_form_validation.asp](https://www.w3schools.com/php/php_form_validation.asp)
* Regex Test: [http://regexpal.com/](http://regexpal.com/)
* Regular Expressions Cheat Sheet by DaveChild:
[http://www.cheatography.com/davechild/cheat-sheets/regular-expressions/](https://www.cheatography.com/davechild/cheat-sheets/regular-expressions/)
* RegExLib.com Cheat Sheet:
[http://regexlib.com/CheatSheet.aspx](http://regexlib.com/CheatSheet.aspx)
* RegExLib.com: [http://regexlib.com/](http://regexlib.com/)

## 4. All done now…

Happy days! You passed all tests and can assume that the input is validated,
sanitized and safe to send it to the database, files or other storage or
processing locations.

That’s about it for the input validation process, front-end-side execution and
back-end-side execution. Please bare in mind to never ever trust (user) input and
always process it appropriately. The most common vulnerabilities are due to
improper input validation.

I hope you like the set of posts on this topic and thank you for reading my
blog!

### 4.1 Full example code front-end-side

https://github.com/teusink/Security-Frameworks-and-Models/blob/master/Input-Validation-for-Web-apps/example-front-end.html

### 4.2 Full example code front-end-side

https://github.com/teusink/Security-Frameworks-and-Models/blob/master/Input-Validation-for-Web-apps/example-back-end.php

### 4.3 Disclaimer

Please be aware that the code is merely an example to show what could be done to
do input validation and it is not ready for production environments. Chances are
that the regular expressions can be improved and other code might as well.
The code also has not been security tested for programming vulnerabilities,
as well for any other issues in regard to continuity and integrity.

Always make sure that you follow the requirements of your applications and
incorporate the security in its design. From there you can implement all the
input validation you need for the best security of your application.

*****
