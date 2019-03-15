<?php
   session_start();
   if (isset($_SESSION['valid_pjer'])) {
      $member_id = $_SESSION['valid_pjer'];
   }
   else {
      header('Location: login.php?fromurl=account_settings.php');
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
<title>PJ Corner &bull; Account Settings</title>

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

<form method="post" action="account_settings.php"> 
<table class="tablebg" width="100%" cellspacing="1"> 
<tr> 
	<th colspan="2" valign="middle">Edit account settings</th> 
</tr> 

<tr>
		<td class="row3" colspan="2" align="center"><span class="gensmall error">
		
		<?php
		
		$fields_valid = 1;

		if(isset($_POST['member_email'])) {
		   $member_email = strtolower(trim($_POST['member_email']));
		   if (!eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$', $member_email)) {
			  $fields_valid = 0;
			  echo "The e-mail address you entered is invalid.<br />";
		   }
		   else {
			  $matching_email_row_count = count_rows("member", "WHERE member_email = '".$member_email."' AND member_id != ".$member_id);
			  if($matching_email_row_count > 0) {
				 $fields_valid = 0;
				 echo "Another user has already registered with this e-mail address.  Please specify another.<br />";
			  }
		   }
		}

		if (isset($_POST['member_password']) && isset($_POST['member_password_confirm'])) {
		   $member_password = $_POST['member_password'];
		   $member_password_confirm = $_POST['member_password_confirm'];
		   if ($member_password == "" && $member_password_confirm == "") {
		      $update_password_query = "";
		   }
		   else {
		       $update_password_query = ", member_password = SHA1('".$member_password."')";
			   if ($member_password != $member_password_confirm) {
				  $fields_valid = 0;
				  echo "The passwords you entered do not match.<br />";
			   }
			   else {
				  if (strlen($member_password) < 6) {
					 $fields_valid = 0;
					 echo "The password you entered is too short.<br />";
				  }
				  if (strlen($member_password) > 30) {
					 $fields_valid = 0;
					 echo "The password you entered is too long.<br />";
				  }

				  $valid_values = array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
										"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
				  $invalid_values = str_replace($valid_values, "", strtolower($member_password));
				  if ($invalid_values != '') {
					 $fields_valid = 0;
					 echo "The password you entered contains invalid characters.<br />";
				  }
				  $easy_passwords = array("password", "secret", "accenture", "iloveyou", "mallya", "siddharth");
				  if (in_array(strtolower($member_password), $easy_passwords) || count_rows("member","WHERE member_first_name = '".$member_password."' AND member_id = ".$member_id) || count_rows("member","WHERE member_last_name = '".$member_password."' AND member_id = ".$member_id)) {
					 $fields_valid = 0;
					 echo "The password you entered is too easy for others to guess.<br />";
				  }	  
		   } 
           }		   
		}
		
		if (isset($_POST['current_member_password'])) {
		   if(count_rows("member", "WHERE member_id = ".$member_id." AND member_password = SHA1('".$_POST['current_member_password']."')")) 
		      $current_member_password = $_POST['current_member_password'];
		   else {
		      $fields_valid = 0;
			  echo "The current password you entered is incorrect.<br />";
		   }
		}
		
		if ($fields_valid && isset($_POST['member_email']) && isset($_POST['member_password']) && isset($_POST['member_password_confirm']) && isset($_POST['current_member_password'])) {
		
		   db_con();
		   
		   $update_member = "UPDATE member SET member_email = '".$member_email."'".$update_password_query." WHERE member_id = ".$member_id;
		   
		   $update_member_result = mysqli_query($db_con, $update_member);
		   
			if ($update_member_result) {
				echo '<div style="color:green">The changes have been saved.</div>';
			}
			else 
				echo "The changes could not be saved due to technical problems.  Error(for support personnel): ".mysqli_error($db_con)." <br />";

			db_close_con();			  
		}
		?>
		
		</span></td>
</tr>



<tr> 
	<td class="row1" width="35%"><b class="genmed">Username: </b></td> 
	<td class="row2"><b class="gen"><?php echo get_member_name_from_id($_SESSION['valid_pjer']); ?></b></td> 
</tr> 
<tr> 
	<td class="row1" width="35%"><b class="genmed">E-mail address: </b></td> 
	<td class="row2"><input type="text" class="post" name="member_email" size="30" maxlength="100" value="<?php if($fields_valid==0) echo $_POST['member_email']; else echo get_email_from_member_id($_SESSION['valid_pjer']); ?>" /></td> 
</tr> 
	<tr> 
		<td class="row1" width="35%"><b class="genmed">New password: </b><br /><span class="gensmall">Must be between 6 and 30 characters.</span></td> 
		<td class="row2"><input type="password" class="post" name="member_password" size="30" maxlength="255" value="" /></td> 
	</tr> 
	<tr> 
		<td class="row1" width="35%"><b class="genmed">Confirm password: </b><br /><span class="gensmall">You only need to confirm your password if you changed it above.</span></td> 
		<td class="row2"><input type="password" class="post" name="member_password_confirm" size="30" maxlength="255" value="" /></td> 
	</tr> 
<tr> 
	<th colspan="2">Confirm changes</th> 
</tr> 
<tr> 
	<td class="row1" width="35%"><b class="genmed">Current password: </b><br /><span class="gensmall">You must confirm your current password if you wish to change it or alter your e-mail address.</span></td> 
	<td class="row2"><input type="password" class="post" name="current_member_password" size="30" maxlength="255" value="" /></td> 
</tr> 
<tr> 
	<td class="cat" colspan="2" align="center"><input class="btnmain" type="submit" name="submit" value="Submit" />&nbsp;&nbsp;<input class="btnlite" type="reset" value="Reset" name="reset" /></td> 
</tr> 
</table> 
 
	<input type="hidden" name="creation_time" value="1256236701" /> 
<input type="hidden" name="form_token" value="2645713942091b88876aca0883de54980c453e6d" /> 
</form></td> 
</tr> 
</table> 
 
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