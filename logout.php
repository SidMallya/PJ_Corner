<?php
   session_start();
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
<title>PJ Corner &bull; Logout</title>

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

   <table class="tablebg" width="100%" cellspacing="1">
   <tr>
	   <th>Information</th>
   </tr>
   <tr> 
<?php
   
   if (isset($_SESSION['valid_pjer'])) {  
      $old_user = $_SESSION['valid_pjer'];
      unset($_SESSION['valid_pjer']);
      $destroy_result = session_destroy();
   }

   if (!empty($old_user)) {
      if ($destroy_result) {
         echo '<td class="row1" align="center"><br /><p class="gen">You have been successfully logged out.<br /><br /><a href="index.php">Return to the index page</a> </p><br /></td>';
         echo '<meta http-equiv="REFRESH" content="2;url=index.php">';
      }  
      else {
         echo '<td class="row1" align="center"><br /><p class="gen">You could not be logged out.  Please try logging out after sometime.<br /><br /><a href="index.php">Return to the index page</a> </p><br /></td>';
         echo '<meta http-equiv="REFRESH" content="2;url=index.php">';		 
      }
   }
   else {
      echo '<td class="row1" align="center"><br /><p class="gen">You were not logged in, and so have not been logged out.<br /><br /><a href="index.php">Return to the index page</a> </p><br /></td>';
      echo '<meta http-equiv="REFRESH" content="2;url=index.php">';
   }
?>
   
	   
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


