<?php
   session_start();
   if (isset($_SESSION['valid_pjer'])) {
      $member_id = $_SESSION['valid_pjer'];
   }
   else {
      header('Location: login.php?fromurl=post_new_pj.php');
      die();
   }
   
   if (isset($_POST['cancel'])) {
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
<title>PJ Corner &bull; Post New PJ</title>

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
	
<form action="post_new_pj.php" method="post" name="postform" accept-charset="UTF-8" enctype="multipart/form-data"> 
<table class="tablebg" width="100%" cellspacing="1"> 
<tr> 
	<th colspan="2"><b>Post a new PJ</b></th> 
</tr> 

<?php

if (isset($_POST['subject']) && isset($_POST['PJ'])) {
   $invalid_tags = array("<", ">", "&#60;", "&#62;");
   $subject = str_replace($invalid_tags, "", ($_POST['subject']));   
   $PJ = nl2br(str_replace($invalid_tags, "", trim($_POST['PJ'])));

   echo '<tr><td class="row2" colspan="2" align="center"><span class="genmed error">';
   
   if ($subject == "") {
      $pj_not_ok = 1;   
      echo 'You must specify a subject when posting a new PJ.<br />';
   }
   if (strlen($subject) > 60) {
      $pj_not_ok = 1;   
      echo 'Your subject exceeds the maximum character limit.<br />';
   }

   if (strlen($PJ) < 15) {
      $pj_not_ok = 1;   
      echo 'Your PJ contains too few characters.<br />';
   }

   if (strlen($PJ) > 1000) {
      $pj_not_ok = 1;   
      echo 'Your PJ exceeds the maximum character limit.<br />';
   }



   if (!isset($pj_not_ok)) {
      db_con();
      $insert_pj = "INSERT INTO pj (pj_post_ts, pj_update_ts, pj_member_id, pj_heading, pj_content) VALUES (NULL,NULL,".$member_id.",'".mysqli_real_escape_string($db_con,$subject)."','".mysqli_real_escape_string($db_con,$PJ)."')";
      $insert_result = mysqli_query($db_con, $insert_pj);
	  if ($insert_result) {
		 echo '<meta http-equiv="REFRESH" content="0;url=index.php">';
		 die();
	  }	 
          else {
	     $pj_not_ok = 1; 
	     echo 'Your PJ could not be posted.  Please contact the site administrator if problem persists.<br />';		 
	  }	 
	  db_close_con();
   }
   
   echo '</span></td></tr>';
}


   
?> 
<tr> 
	<td class="row1" width="22%"><b class="genmed">PJ Subject:</b></td> 
	<td class="row2" width="78%"><input class="post" style="width:450px" type="text" name="subject" size="45" maxlength="60" tabindex="2" value="<?php if(isset($pj_not_ok)) echo $subject;?>" /></td> 
</tr> 
<tr> 
	<td class="row1" valign="top"><b class="genmed">PJ body:</b><br /><span class="gensmall">Enter your PJ here, it may contain no more than <strong>1000</strong> characters.&nbsp;</span><br /><br /> 
		</td> 
	<td class="row2" valign="top"> 
 
		<table width="100%" cellspacing="0" cellpadding="0" border="0"> 
 
		<tr> 
			<td valign="top" style="width: 100%;"><textarea name="PJ" rows="15" cols="76" tabindex="3"  style="width: 98%;"><?php if(isset($pj_not_ok)) echo $PJ;?></textarea></td> 
						<td width="80" align="center" valign="top"> 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			            </td> 
				 	</tr> 
		</table> 
	</td> 
</tr> 
 
 
	<tr> 
		<td class="cat" colspan="2" align="center"> 
			&nbsp; <input class="btnmain" type="submit" name="post" value="Submit" /> 
			&nbsp; <input class="btnlite" type="submit" name="cancel" value="Cancel" /> 
		</td> 
	</tr> 
 

</table> 	

</form>
	
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