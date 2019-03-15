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
<title>PJ Corner &bull; Login</title>

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

<form action="login.php" method="post"> 
 
<table class="tablebg" width="100%" cellspacing="1"> 
<tr> 
			<th colspan="2">Login</th> 
</tr> 

<?php

if (isset($_GET['fromurl'])) {
   $from_url = $_GET['fromurl'];

   echo '<tr>';
   switch($from_url) {
      case "post_new_pj.php":
         echo '<td class="row3" colspan="2" align="center"><span class="gensmall">You need to login in order to post a PJ.</span></td> ';
		 break;
	  case "member_list.php":
	     echo '<td class="row3" colspan="2" align="center"><span class="gensmall">You need to login in order to view the member information.</span></td> ';
		 break;
  	  case "account_settings.php":
	     echo '<td class="row3" colspan="2" align="center"><span class="gensmall">You need to login in order to view and edit your account settings.</span></td> ';
		 break;
	  default:
	     echo '!';
		 break;
   }
   echo '</tr>';
}

?>

<tr>	<td class="row1" width="50%"> 
		<p class="genmed">In order to login you must be registered. Logging in gives you increased capabilities such as posting and rating PJs and viewing PJer information.</p> 
 
		<p class="genmed" align="center"> 
			<a href="terms.php">Terms of use</a> | <a href="privacy.php">Privacy policy</a> 
		</p> 
	</td> 
		<td class="row2"> 
	
		<table align="center" cellspacing="1" cellpadding="4" style="width: 100%;"> 
		
		<?php
           include 'verify_login.php';
        ?>
		
		<tr> 
			<td valign="top" ><b class="gensmall">Email:</b></td> 
			<td><input class="post" type="text" name="member_email" size="25" value="" tabindex="1" /></td> 
		</tr> 
		<tr> 
			<td valign="top" ><b class="gensmall">Password:</b></td> 
			<td> 
				<input class="post" type="password" name="member_password" size="25" tabindex="2" /> 
			</td> 
		</tr> 
		</table> 
	</td> 
</tr> 
 
<tr> 
	<td class="cat" colspan="2" align="center"><input type="hidden" name="fromurl" value="<?php if (isset($_GET['fromurl'])) echo $_GET['fromurl']; else echo "index.php"; ?>" /> 
    <input type="submit" name="login" class="btnmain" value="Login" tabindex="5" /></td> 
</tr> 
</table> 
 
</form> 
 
<br clear="all" /> 	
	
	<table class="tablebg" width="100%" cellspacing="1" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="index.php">PJ index</a></p>
			<p class="datetime">All times are IST </p>
		</td>
	</tr>
	</table>
	<br clear="all" />

</div>
	
<?php
   include 'footer.html';
?>

</body>
</html>