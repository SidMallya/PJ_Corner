<?php
    session_start();
	if (isset($_GET['keywords']) && isset($_GET['author'])) {
	  $illegal_characters = array("%", "_", "\"", "'");
	  $search_keywords = str_replace($illegal_characters, "", trim($_GET['keywords']));
	  $search_author = str_replace($illegal_characters, "", trim($_GET['author']));
	  
	  if(strlen($search_keywords) > 50) {
		 header('Location: search.php?search_error=1');	
		 die();		 
	  }
	  if(strlen($search_author) > 45) {
		 header('Location: search.php?search_error=2');		 
		 die();
	  }
	  if ($search_keywords == "" && $search_author == "") {
		 header('Location: search.php?search_error=3');		 
		 die();
	  }
	  if($search_keywords != "" && strlen($search_keywords) < 3 && $search_author != "" && strlen($search_author) < 3) {
		 header('Location: search.php?search_error=4');		 
		 die();
	  }	  	  
	  if($search_keywords != "" && strlen($search_keywords) < 3) {
		 header('Location: search.php?search_error=5');		 
		 die();
	  }	  
	  if($search_author != "" && strlen($search_author) < 3) {
		 header('Location: search.php?search_error=6');		 
		 die();
	  }
	  
	}
	else {
	header('Location: search.php');
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
<meta http-equiv="Pragma" content="no-cache">
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta name="copyright" content="Siddharth Mallya" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<title>PJ Corner &bull; Search Results </title>

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

<?php 

$where_clause = " WHERE ";

if ($search_keywords != "" && $search_author != "") {
   $table_names = " member,pj ";
   $where_clause .= " member_id = pj_member_id AND ";
}

if ($search_keywords == "" && $search_author != "") {
   $where_clause .= " member_id = pj_member_id AND ";
}


if ($search_keywords != "") {
    $table_names = " pj ";
	$search_keyword_parts = explode(" ", $search_keywords);
	$array_row = 0;
	foreach ($search_keyword_parts as $search_keyword_parts_value) {
	 if ($search_keyword_parts_value != "") {
		$content_cond_array[$array_row] = "pj_content like '%".$search_keyword_parts_value."%'";
		$array_row++;
	 }
	}
	$content_cond = " (".implode(" AND ", $content_cond_array).") ";
	$where_clause .= $content_cond;
}

if ($search_keywords != "" && $search_author != "") {
   $where_clause .= " AND ";
}

if ($search_author != "") {
    $table_names = " pj,member ";
	$search_author_parts = explode(" ", $search_author, 2);
	$array_row = 0;
	foreach ($search_author_parts as $search_author_parts_value) {
	 if ($search_author_parts_value != "") {
		$author_cond_array[$array_row] = "(member_first_name like '%".$search_author_parts_value."%' "."OR member_last_name like '%".$search_author_parts_value."%' )";
		$array_row++;
	 }
	}
	$content_cond = " (".implode(" AND ", $author_cond_array).") ";
	$where_clause .= $content_cond;
}

if (isset($_GET['pn'])) { 
    $page = $_GET['pn'];

	$total_pjs = count_rows($table_names, $where_clause);	
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
	if (!count_rows($table_names, $where_clause))
	   $posts_per_page = 0;	
}
else {
   $page = 1;
   $total_pjs = count_rows($table_names, $where_clause);	
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
	if (!count_rows($table_names, $where_clause))
	   $posts_per_page = 0;	
}

?>	
	
<table class="tablebg" cellspacing="1" width="100%">
<tr>
	<td class="cat" colspan="5" align="right"><b><?php get_previous_page_href_sr(); ?></b> | <b><?php get_next_page_href_sr(); ?></b>&nbsp;</td>
</tr>
<tr>
	<th colspan="2">&nbsp;PJ&nbsp;</th>
	<th width="50">&nbsp;Views&nbsp;</th>
	<th width="50">&nbsp;Rating&nbsp;</th>
	<th>&nbsp;Posted on and by&nbsp;</th>
</tr>

<tr>
	<td class="cat" colspan="2"><h4><?php echo "PJ Search:<br />&nbsp;Keywords: ".$search_keywords." | Author: ".$search_author." | "; if ($posts_per_page) echo "Page ".$page." of ".$total_pages_integer; else echo "No results found"?></h4></td>
	<td class="catdiv" colspan="3">&nbsp;</td>
</tr>

<?php

db_con();
$starting_post = ($page - 1) * 10;
$post_query = "SELECT * FROM ".$table_names.$where_clause." ORDER BY pj_rating DESC LIMIT ".$starting_post.",".$posts_per_page;
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
    <td class="row1" width="100%"><a class="forumlink" href="view_pj.php?pj_id=<?php echo $pj_id ?>"><?php echo stripslashes($pj_heading); ?></a><p class="forumdesc"><?php echo stripslashes($pj_content); ?><br /></p></td>
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
                 echo '<option '.select_current_page($page, $pn).' value="search_results.php?keywords='.$search_keywords.'&author='.$search_author.'&pn='.$pn.'">'.$pn;
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