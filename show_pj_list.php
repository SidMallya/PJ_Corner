<?php 

if (isset($_GET['pn'])) { 
    $page = $_GET['pn'];

	$total_pjs = count_rows("pj", "");	
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
	if (!count_rows("pj", ""))
	   $posts_per_page = 0;	

}
else {
   $page = 1;
   $total_pjs = count_rows("pj", "");
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
	
   if (!count_rows("pj", ""))
      $posts_per_page = 0;	
  
}

?>

<tr>
	<td class="cat" colspan="2"><h4><?php echo $pj_sort_type; if ($posts_per_page) echo "Page ".$page." of ".$total_pages_integer; else echo "No PJs yet" ?></h4></td>
	<td class="catdiv" colspan="3">&nbsp;</td>
</tr>

<?php

db_con();
$starting_post = ($page - 1) * 10;
$post_query = "SELECT * FROM pj ORDER BY ".$order_by." DESC LIMIT ".$starting_post.",".$posts_per_page;
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
                 echo '<option '.select_current_page($page, $pn).' value="index.php?content='.$content.'&pn='.$pn.'">'.$pn;
			  }
			  ?>
 		   </select>
		</form>		
		</td> 
</tr> 
</table> 
		