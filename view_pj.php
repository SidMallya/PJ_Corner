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
<title>PJ Corner &bull; View PJ</title>

<link rel="stylesheet" href="stylesheet.css" type="text/css" />

<?php
   include 'user_defined_functions.php';
?>

</head>

<body class="ltr">

<?php
   include 'header.php';
   if (isset($_GET['pj_id'])) {
	   if (is_numeric($_GET['pj_id'])) {
		  if(count_rows("pj", "WHERE pj_id = ".$_GET['pj_id'])) {
   	         $get_pj_id = $_GET['pj_id'];
             update_pj_views($get_pj_id);
		  }
		  else {
			 echo '<meta http-equiv="REFRESH" content="0;url=index.php">';
			 die();      
		  }   
	   }
	   else {
		  echo '<meta http-equiv="REFRESH" content="0;url=index.php">';
		  die();      
	   }
	}
   else {
      echo '<meta http-equiv="REFRESH" content="0;url=index.php">';
      die();
   }
   
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

<?php
   if (isset($_SESSION['valid_pjer'])) {
	  echo '<td align="left" valign="middle" nowrap="nowrap"><a href="post_new_pj.php"><img src="images/button_pj_new.gif" alt="Post new PJ" title="Post new PJ" /></a></td>';
   }
?>	
	
<div id="pagecontent"> 

	<table class="tablebg" width="100%" cellspacing="1"> 
	<tr> 
		<td class="cat"> 
			<table width="100%" cellspacing="0"> 
			<tr> 
				<td class="nav" nowrap="nowrap">&nbsp;</td> 
				<td class="nav" align="right" nowrap="nowrap"><b><?php get_previous_pj($get_pj_id); ?> | <?php get_next_pj($get_pj_id); ?>&nbsp;<b></td> 
			</tr> 
			</table> 
		</td> 
	</tr> 
	</table> 

 
	<table class="tablebg" width="100%" cellspacing="1"> 
			<tr> 
			<th>Author</th> 
			<th>PJ</th> 
		</tr> 
	
	<?php

	if (isset($_POST['submit_pj_rating'])) {
   	   $submit_pj_rating = $_POST['submit_pj_rating'];
	   db_con();
	   $insert_rating = "INSERT INTO rating (rating_ts,rating_pj_id,rating_by_member_id,rating_member_rating) VALUES (NULL,".$get_pj_id.",".$_SESSION['valid_pjer'].",".$submit_pj_rating.")";
	   $update_pj_rating = "UPDATE pj SET pj_rating = (SELECT (SUM(rating_member_rating)/COUNT(rating_member_rating)) FROM rating WHERE rating_pj_id = ".$get_pj_id.") where pj_id = ".$get_pj_id;
	   @mysqli_query("BEGIN");
	   if (mysqli_query($db_con, $insert_rating) && mysqli_query($db_con, $update_pj_rating)) {
	      @mysqli_query("COMMIT");
		  $submit_rating_success = 1;
	   }
	   else {
		  @mysql_query("ROLLBACK");
		  $submit_rating_success = 0;					  
	   }
	   db_close_con();
	}	

    db_con();
    $pj_query = "SELECT * FROM pj WHERE pj_id = ".mysqli_real_escape_string($db_con,$get_pj_id);
    $pj_query_result = mysqli_query($db_con, $pj_query);
    db_close_con();	

	
	$pj_query_result_row = mysqli_fetch_assoc($pj_query_result);

	$pj_id = $pj_query_result_row['pj_id'];
	$pj_member_id = $pj_query_result_row['pj_member_id'];
	$pj_member_name = get_member_name_from_id($pj_member_id);
	$pj_heading = $pj_query_result_row['pj_heading'];
	$pj_content = $pj_query_result_row['pj_content'];
	$pj_views = $pj_query_result_row['pj_views'];
	$pj_rating = $pj_query_result_row['pj_rating'];
	$pj_post_ts = $pj_query_result_row['pj_post_ts'];

	?>
			
	<tr class="row1"> 
			<td align="center" valign="middle"> 
				<b class="postauthor"><?php echo $pj_member_name; ?></b> 
			</td> 
			<td width="100%" height="25"> 
				<table width="100%" cellspacing="0"> 
				<tr> 
									<td class="gensmall" width="100%"><div style="float: left;">&nbsp;<b>PJ subject:</b> <?php echo stripslashes($pj_heading); ?></div><div style="float: right;"><img src="images/icon_post_target.gif" width="12" height="9" alt="Post" title="Post" /><b>Posted:</b>&nbsp;<?php echo formatted_date_from_ts($pj_post_ts); ?>&nbsp;</div></td> 
				</tr> 
				</table> 
			</td> 
		</tr> 
		
		<tr class="row1"> 
			<td valign="top" class="profile"> 
				<table cellspacing="4" align="center" width="150"> 
				<tr> 
					<td class="postdetails"><?php echo get_member_reputation(get_member_reputation_number($pj_member_id)); ?></td> 
				</tr> 
							</table> 
 
				<span class="postdetails"> 
				<br /><b>Joined:</b> <?php echo get_registered_date($pj_member_id); ?>				
				<br /><b>PJs:</b> <?php echo get_total_pjs_by_member($pj_member_id); ?>				
				<br />
				<br /><b style="color:#3366CC;">Reputation:&nbsp;</b><i style="color:#3366CC;"><?php echo get_member_reputation_number($pj_member_id); ?></i>
					</span> 
 
			</td> 
			<td valign="top"> 
				<table width="100%" cellspacing="5"> 
				<tr> 
					<td> 
					
						<div class="postbody"><?php echo stripslashes($pj_content); ?></div> 
 
					<br clear="all" /><br /> 
    				</td> 
				</tr> 
				</table> 
			</td> 
		</tr> 
 
		<tr class="row2"> 
			<td><div class="gensmall" style="float: left;">&nbsp;<a href="member_list.php?mode=viewprofile&u=<?php echo "$pj_member_id" ?>";><img src="images/icon_user_profile.gif" alt="Profile" title="Profile" /></a></div></td> 
			<td class="gensmall" width="100%">
			<div style="float: left;">&nbsp;<b>PJ views:</b> <?php echo $pj_views; ?></div><br />
			<div style="float: left;">&nbsp;<b>PJ Rating:</b> <?php echo $pj_rating.'/10 - '.get_rating_text($pj_rating); ?></div><br />
			<div style="float: left;">&nbsp;<b>Total Votes:</b> <?php echo count_rows("rating","WHERE rating_pj_id = ".$pj_id); ?></div>
			<?php
			   if (isset($_SESSION['valid_pjer'])) {
				  if ($pj_member_id != $_SESSION['valid_pjer'] && !count_rows("rating","WHERE rating_pj_id = ".$pj_id." AND rating_by_member_id = ".$_SESSION['valid_pjer'])) {
					 echo '<form action="view_pj.php?pj_id='.$pj_id.'" method="POST">';
					 echo '<div style="float: right;">&nbsp;<b>Rate this PJ:&nbsp;</b>';
					 echo '<select name="submit_pj_rating">';
					 for($i = 1; $i <= 10; $i++) {
						echo '<option value="';
						echo $i; 
						echo '">'.$i;
					 }
					 echo '</select>';
					 echo '<input type="submit" value="Submit">';
					 echo '(10 = Excellent; 1 = Horrible)';
					 echo '&nbsp;</div>';
					 echo '</form>';				  
				  }
                  else {
				     if (isset($submit_rating_success) && count_rows("rating","WHERE rating_pj_id = ".$pj_id." AND rating_by_member_id = ".$_SESSION['valid_pjer'])) {
				        if ($submit_rating_success)
				           echo '<div style="float: right;color: green;">&nbsp;<b>Thanks for rating!&nbsp;</b>';
					    else
						   echo '<div style="float: right;color: red;">&nbsp;<b>Your rating could not be accepted at this time.  Please try again later.&nbsp;</b>';					 
				     }
			      }
		       } 		  
			?>   
			</td>
		</tr> 
 
		
	</table> 
 
</div>
	
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