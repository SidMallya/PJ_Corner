<?php
   session_start();
   if (isset($_SESSION['valid_pjer'])) {
      header('Location: index.php');
      die();
   }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-gb" xml:lang="en-gb">	
<head>

<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="content-language" content="en-gb" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="imagetoolbar" content="no" />
<!--<meta http-equiv="Pragma" content="no-cache">-->
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta name="copyright" content="Siddharth Mallya" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<title>PJ Corner &bull; Register</title>

<link rel="stylesheet" href="stylesheet.css" type="text/css" />

<?php
   include 'user_defined_functions.php';
?>

</head>

<body class="ltr">

<?php
   include 'header.php';
?>

<div id="wrapcentre">
	<table class="tablebg" width="100%" cellspacing="1" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="index.php">PJ index</a></p>
			<p class="datetime">All times are IST </p>
		</td>
	</tr>
	</table><br />

<form name="register" method="post" action="register.php">

<table class="tablebg" width="100%" cellspacing="1">
<tr>
	<th colspan="2" valign="middle">Registration</th>
</tr>

<?php
   include 'verify_registration.php';
?>

<tr>
	<td class="row1" width="38%"><b class="genmed">Registration Code: </b><br /><span class="gensmall">Enter 40 digit registration code provided by the site administrator.</span></td>
	<td class="row2"><input class="post" type="text" name="registration_code" size="25" maxlength="40" value="<?php if(!$fields_valid ) echo $registration_code; ?>" /></td>
</tr>
<tr>
	<td class="row1" width="38%"><b class="genmed">First name: </b><br /><span class="gensmall">Length must be between 3 and 16 characters.</span></td>
	<td class="row2"><input class="post" type="text" name="member_first_name" size="25" value="<?php if(!$fields_valid ) echo $member_first_name; ?>" /></td>
</tr>
<tr>
	<td class="row1" width="38%"><b class="genmed">Last name: </b><br /><span class="gensmall">Length must be between 1 and 28 characters.</span></td>
	<td class="row2"><input class="post" type="text" name="member_last_name" size="25" value="<?php if(!$fields_valid ) echo $member_last_name; ?>" /></td>
</tr>
<tr>
	<td class="row1"><b class="genmed">E-mail address: </b></td>
	<td class="row2"><input class="post" type="text" name="member_email" size="25" maxlength="100" value="<?php if(!$fields_valid ) echo $member_email; ?>" /></td>
</tr>
<tr>
	<td class="row1"><b class="genmed">Password: </b><br /><span class="gensmall">Must be between 6 and 30 characters.</span></td>
	<td class="row2"><input class="post" type="password" name="member_password" size="25" value="" /></td>
</tr>
<tr>
	<td class="row1"><b class="genmed">Confirm password: </b></td>
	<td class="row2"><input class="post" type="password" name="member_password_confirm" size="25" value="" /></td>
</tr>

<tr>
	<td class="cat" colspan="2" align="center">
    <input class="btnmain" type="submit" name="submit" id="submit" value="Submit" />&nbsp;&nbsp;<input class="btnlite" type="reset" value="Reset" name="reset" />
	</td>
</tr>
</table>
</form>

</div>
	
<?php
   include 'footer.html';
?>

</body>
</html>