<?php
   session_start();
   
   if (isset($_SESSION['valid_pjer'])) {
      $member_id = $_SESSION['valid_pjer'];
   }
   else {
      header('Location: login.php?fromurl=member_list.php');
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
<title>PJ Corner &bull; User's PJs </title>

<link rel="stylesheet" href="stylesheet.css" type="text/css" />

<?php
   include 'user_defined_functions.php';
?>

</head>

<body class="ltr">

<?php
   include 'header.php';
	if (isset($_GET['u'])) {
	   if (is_numeric($_GET['u'])) {
		  if(count_rows("member", "WHERE member_id =".$_GET['u'])) {
			 $get_member_id = $_GET['u'];
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

<table class="tablebg" cellspacing="1" width="100%">
<tr>
	<td class="cat" colspan="5" align="right"><b><?php get_previous_page_href_sup(); ?></b> | <b><?php get_next_page_href_sup(); ?></b>&nbsp;</td>
</tr>
<tr>
	<th colspan="2">&nbsp;PJ&nbsp;</th>
	<th width="50">&nbsp;Views&nbsp;</th>
	<th width="50">&nbsp;Rating&nbsp;</th>
	<th>&nbsp;Posted on and by&nbsp;</th>
</tr>

	
<?php 

if (isset($_GET['pn'])) { 
    $page = $_GET['pn'];

	$total_pjs = count_rows("pj", "WHERE pj_member_id = ".$get_member_id);	
	$total_pages_decimal = $total_pjs / 10;
	$remainder = $total_pjs % 10; 
	
	if ($remainder == 0) {
	   $total_pages_integer = (int)$total_pages_decimal;
	   $posts_per_page = 10;	   
	}
	else {
	   $total_pages_integer = (int)$total_pages_decimal + 1;
	   if ($page == $total_pages_integer)
		  $posts_per_page = $remainder;
	   else 
		  $posts_per_page = 10;
	}

	if ($page > $total_pages_integer || !is_numeric($page) || $page < 1) {
	   $page = 1;
       if ($total_pjs < 10)
          $posts_per_page = $remainder;
       else
          $posts_per_page = 10;
    }
	if (!count_rows("pj", "WHERE pj_member_id = ".$get_member_id))
	   $posts_per_page = 0;	
}
else {
   $page = 1;
   $total_pjs = count_rows("pj", "WHERE pj_member_id = ".$get_member_id);	
   $total_pages_decimal = $total_pjs / 10;   
   $remainder = $total_pjs % 10; 
   
	if ($remainder == 0) {
	   $total_pages_integer = (int)$total_pages_decimal;
	   $posts_per_page = 10;	   
	}
	else {
	   $total_pages_integer = (int)$total_pages_decimal + 1;
	   if ($page == $total_pages_integer)
		  $posts_per_page = $remainder;
	   else 
		  $posts_per_page = 10;
	}   

	if (!count_rows("pj", "WHERE pj_member_id = ".$get_member_id))
	   $posts_per_page = 0;	
  
}

?>

<tr>
	<td class="cat" colspan="2"><h4><?php echo get_member_name_from_id($get_member_id)."'s PJS "; echo " | "; if ($posts_per_page) echo "Page ".$page." of ".$total_pages_integer; else echo "No PJs yet" ?></h4></td>
	<td class="catdiv" colspan="3">&nbsp;</td>
</tr>

<?php

db_con();
$starting_post = ($page - 1) * 10;
$post_query = "SELECT * FROM pj WHERE pj_member_id = ".$get_member_id." ORDER BY pj_rating DESC LIMIT ".$starting_post.",".$posts_per_page;
$post_query_result = mysqli_query($db_con, $post_query);
db_close_con();



for($i=1; $i <= $posts_per_page; $i++) {

	$post_query_result_row = mysqli_fetch_assoc($post_query_result);

	$pj_id = $post_query_result_row['pj_id'];
	$pj_member_id = $post_query_result_row['pj_member_id'];
	$pj_member_name = get_member_name_from_id($pj_member_id);
	$pj_heading = $post_query_result_row['pj_heading'];
	if (strlen($post_query_result_row['pj_content']) > 50)
	   $pj_content = substr($post_query_result_row['pj_content'], 0, 50)."...";
	else 
	   $pj_content = $post_query_result_row['pj_content'];
	$pj_views = $post_query_result_row['pj_views'];
	$pj_rating = $post_query_result_row['pj_rating'];
	$pj_post_ts = $post_query_result_row['pj_post_ts'];

?>


<tr>
    <td class="row1" width="50" align="center"><img src="images/pj_read.gif" width="46" height="25" alt="PJ" title="PJ" /></td>
    <td class="row1" width="100%"><a class="forumlink" href="view_user_pj.php?u=<?php echo $pj_member_id ?>&pj_id=<?php echo $pj_id ?>"><?php echo stripslashes($pj_heading); ?></a><p class="forumdesc"><?php echo stripslashes($pj_content); ?><br /></p></td>
    <td class="row2" align="center"><p class="topicdetails"><?php echo $pj_views; ?></p></td>
    <td class="row2" align="center"><p class="topicdetails"><?php echo $pj_rating."/10"; ?></p></td>
    <td class="row2" align="center" nowrap="nowrap"><p class="topicdetails"><?php echo formatted_date_from_ts($pj_post_ts); ?></p><p class="topicdetails"><a href="member_list.php?mode=viewprofile&u=<?php echo $pj_member_id; ?>"><?php echo $pj_member_name; ?></a></p></td>
</tr>

<?php 
}
?>

<table width="100%" cellspacing="1"> 
<tr> 
        <?php 
		   if (isset($_SESSION['valid_pjer'])) {
		      echo '<td align="left" valign="middle" nowrap="nowrap"><a href="post_new_pj.php"><img src="images/button_pj_new.gif" alt="Post new PJ" title="Post new PJ" /></a></td>';
		   }
        ?>
		<td class="gensmall" width="100%" align="right" nowrap="nowrap"><b>Go to page</b></td>
		<td class="gensmall" width="100%" align="right" nowrap="nowrap">
		<form name="jump1"  >
           <select name="myjumpbox" OnChange="location.href=jump1.myjumpbox.options[selectedIndex].value">
			  <?php
			  for($pn = 1; $pn <= $total_pages_integer; $pn++) {
                 echo '<option '.select_current_page($page, $pn).' value="show_users_pjs.php?u='.$get_member_id.'&pn='.$pn.'">'.$pn;
			  }
			  ?>
 		   </select>
		</form>		
		</td> 
</tr> 
</table> 
	
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