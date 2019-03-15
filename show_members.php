<?php 

if (isset($_GET['pn'])) { 
    $page = $_GET['pn'];

	$total_members = count_rows("member", "");	
	$total_pages_decimal = $total_members / 25;
	$remainder = $total_members % 25; 
	
	if ($remainder == 0) {
	   $total_pages_integer = (int)$total_pages_decimal;
	   $members_per_page = 25;	   
	}
	else {
	   $total_pages_integer = (int)$total_pages_decimal + 1;
	   if ($page == $total_pages_integer)
		  $members_per_page = $remainder;
	   else 
		  $members_per_page = 25;
	}

	if ($page > $total_pages_integer || !is_numeric($page) || $page < 1) {
	   $page = 1;
       if ($total_members < 25)
          $members_per_page = $remainder;
       else
          $members_per_page = 25;
    }
	if (!count_rows("member", ""))
	   $members_per_page = 0;
}
else {
   $page = 1;
   $total_members = count_rows("member", "");
   $total_pages_decimal = $total_members / 25;   
   $remainder = $total_members % 25; 
   
	if ($remainder == 0) {
	   $total_pages_integer = (int)$total_pages_decimal;
	   $members_per_page = 25;	   
	}
	else {
	   $total_pages_integer = (int)$total_pages_decimal + 1;
	   if ($page == $total_pages_integer)
		  $members_per_page = $remainder;
	   else 
		  $members_per_page = 25;
	}   
   if (!count_rows("member", ""))
	   $members_per_page = 0;
}
?>


<table class="tablebg" width="100%" cellspacing="1"> 
<tr> 
	<th nowrap="nowrap" width="5%" >#</th> 
	<th nowrap="nowrap" width="20%" align="left">Member Name</th> 
	<th nowrap="nowrap" width="15%">Joined</th> 
	<th nowrap="nowrap" width="10%">PJs</th> 
	<th nowrap="nowrap" width="15%">Rank</th> 
	<th nowrap="nowrap" width="11%">Reputation</th> 
	</tr> 
	
	
<?php

db_con();
$starting_pj = ($page - 1) * 25;
$member_query = "SELECT * FROM member LIMIT ".$starting_pj.",".$members_per_page;
$member_query_result = mysqli_query($db_con, $member_query);
db_close_con();

for($i=1; $i <= $members_per_page; $i++) {

	$member_query_result_row = mysqli_fetch_assoc($member_query_result);
	
	if ($i % 2 == 0)
	   $row_class = "row1";
	else 
	   $row_class = "row2";

	$member_id = $member_query_result_row['member_id'];
	$member_name = $member_query_result_row['member_first_name']." ".$member_query_result_row['member_last_name'];
	$member_joined_date = formatted_date_from_ts($member_query_result_row['member_reg_ts']);
	$member_total_pjs = get_total_pjs_by_member($member_id);
	$member_rank = get_member_reputation(get_member_reputation_number($member_id));
	$member_reputation = get_member_reputation_number($member_id);
	

?>

	
<tr class="<?php echo $row_class; ?>"> 
		<td class="gen" align="center">&nbsp;<?php echo ($page - 1 + $i) ?>&nbsp;</td> 
		<td class="genmed" align="left"><a href="member_list.php?mode=viewprofile&amp;u=<?php echo $member_id.'">'.$member_name; ?></a></td> 
		<td class="genmed" align="center" nowrap="nowrap">&nbsp;<?php echo $member_joined_date; ?>&nbsp;</td> 
		<td class="gen" align="center"><?php echo $member_total_pjs; ?></td> 
		<td class="gen" align="center"><?php echo $member_rank; ?></td> 
		<td class="gen" align="center">&nbsp;<?php echo $member_reputation; ?>&nbsp;</td> 
</tr> 
 
<?php
} 
?>

<tr> 
	<td class="cat" colspan="6" align="right"><b><?php get_previous_page_href_m(); ?></b> | <b><?php get_next_page_href_m(); ?></b>&nbsp;</td> 
</tr> 
</table> 
	

 
<table width="100%" cellspacing="0" cellpadding="0"> 
<tr> 
	<td class="pagination">Page <strong><?php if($total_pages_integer) echo $page; else echo $total_pages_integer; ?></strong> of <strong><?php echo $total_pages_integer ?></strong> [ <?php echo $total_members; ?> PJers ]</td> 
	<td align="right"><span class="pagination"><b>Go to page</b></span>
		<form name="jump1"  >
           <select name="myjumpbox" OnChange="location.href=jump1.myjumpbox.options[selectedIndex].value">
			  <?php
			  for($pn = 1; $pn <= $total_pages_integer; $pn++) {
                 echo '<option '.select_current_page($page, $pn).' value="show_members.php?page='.$pn.'">'.$pn;
			  }
			  ?>
 		   </select>
		</form>	
	</td> 
</tr> 
</table> 
 