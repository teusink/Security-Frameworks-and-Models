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
server-side, but also client-side. For example, when you have an online form
that users are filling in and sending it to your application, you can and you
should do validation checks with every field a user fills in client-side. When
the data is submitted, you perform a server-side input validation.

This improves the user experience in your application, and it contributes to the
layered-defense principle. If the client-side defense layer fails (because the
attacker is circumventing the form or regular ways of submitting input), you
will have your second layer of defense ready, and that is the server-side input
validation.

### 1.3 Sources

Here are a couple of informative and useful sources you might want to check out.

* Open Web Application Security Project (OWASP) — [https://www.owasp.org/](https://www.owasp.org/)
* Open Sourced Vulnerability Database (OSVDB) — [https://osvdb.org/](https://osvdb.org/)
* TestingSecurity.com — [http://www.testingsecurity.com/](http://www.testingsecurity.com/)
* The importance of input validation, by Kevin Beaver — [http://searchsoftwarequality.techtarget.com/tip/The-importance-of-input-validation](http://searchsoftwarequality.techtarget.com/tip/The-importance-of-input-validation)

*****

## 2. Client-side

In the first part the entire process was explained. In this
post we are going to do some coding on the client-side, in this case JavaScript.

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
client-side and server-side input validation coding. It is very important to
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

If you want to go right away to a full example file, go to my gist: 
[https://gist.github.com/teusink/132d52260f81ab55baa9]

### 2.3 HTML First

On the client-side this step is not needed, but it might come in handy when you
are building user-friendly (intuitive) applications. So lets start with the
forms itself.

With the coming of HTML5 new field types are introduced, in addition to those
already available with HTML4. Make use of those new field types. You will also
notice the use of the pattern attribute in the input type element. Pattern makes
use of regular expressions to validate the data that is entered in the form.

You don’t need to worry about older browsers, as they gracefully degrade to
normal text fields. Down-side of this is that some or all controls might not
work anymore. So there will be still a need for JavaScript.

**Example code client-side HTML**
<script src="https://gist.github.com/teusink/132d52260f81ab55baa9.js?file=form.html"></script>

### 2.4 JavaScript Second

Before submitting the data from the form to the webserver it is key to validate
it on the client-side first. This due to the various layers of defense. There is
the form validation, there is the JavaScript validation and there will be the
PHP (server sided) validation. You may not skip JavaScript if you think a
browser will support the new form elements. Always include this step.

**Example code client-side JavaScript**
<script src="https://gist.github.com/teusink/132d52260f81ab55baa9.js?file=javascript.js"></script>

### 2.5 Disclaimer concerning the code

Please be aware that the code is merely an example to show what can be done to
do input validation and it is not ready for production environments. Chances are
that the regular expressions can be improved and other code might as well.

Always make sure that you follow the requirements of your applications and
incorporate the security in its design. From there you can implement all the
input validation you need for the best security of your application.

### 2.6 Sources

Here are a couple of informative and useful sources you might want to check out.

* JavaScript Form validation: [http://www.w3schools.com/js/js_form_validation.asp](https://www.w3schools.com/js/js_form_validation.asp)
* Regular Expressions 101: [https://regex101.com/](https://regex101.com/)
* Regex Test: [http://regexpal.com/](http://regexpal.com/)
* Regular Expressions Cheat Sheet by DaveChild: [http://www.cheatography.com/davechild/cheat-sheets/regular-expressions/](https://www.cheatography.com/davechild/cheat-sheets/regular-expressions/)
* RegExLib.com Cheat Sheet: [http://regexlib.com/CheatSheet.aspx](http://regexlib.com/CheatSheet.aspx)
* RegExLib.com: [http://regexlib.com/](http://regexlib.com/)

*****

## 3. Server-side

In the first part the entire process was explained. In the second part we did
some coding on the client-side, and now we will look in to server-side coding in
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

### 3.2 Server-sided PHP

The server-sided code for input validation can be found below. In this situation
we use PHP and I will show two kinds of examples. One is the input validation
only and the other is input validation and sanitation. Keep in mind with
sanitation that when done on the server-side, you probably need it also on the
client-side (there is no point doing server-side only, as the user will face
input validation errors by the client-side validation).

That being said, all steps are explained in the code itself.

**Example code server-side PHP**
<script src="https://gist.github.com/teusink/132d52260f81ab55baa9.js?file=exampleserver.php"></script>

### 3.4 All done now…

Happy days! You passed all tests and can assume that the input is validated,
sanitized and safe to send it to the database, files or other storage or
processing locations.

That’s about it for the input validation process, client-side execution and
server-side execution. Please bare in mind to never ever trust (user) input and
always process it appropriately. The most common vulnerabilities are due to
improper input validation.

I hope you like the set of posts on this topic and thank you for reading my
blog!

### 3.5 Disclaimer concerning the code

Please be aware that the code above is merely an example to show what can be
done to do input validation and it is not ready for production environments.
Chances are that the regular expressions can be improved and other code might as
well.

Always make sure that you follow the requirements of your applications and
incorporate the security in its design. From there you can implement all the
input validation you need for the best security of your application.

### 3.6 Sources

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

*****
