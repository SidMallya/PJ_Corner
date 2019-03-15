<?php

if (isset($_GET['u'])) {
	if (is_numeric($_GET['u'])) {
	   if (count_rows("member", "WHERE member_id = ".$_GET['u']))
		  $get_member_id = $_GET['u'];
	   else {
	      echo '<meta http-equiv="REFRESH" content="0;url=member_list.php">';
		  die();
	   }
	}
	else {
	   echo '<meta http-equiv="REFRESH" content="0;url=member_list.php">';
	   die();
	}
}
else {
   echo '<meta http-equiv="REFRESH" content="0;url=member_list.php">';
   die();
}
   
   
db_con();
$member_query = "SELECT * FROM member WHERE member_id = ".$get_member_id;
$member_query_result = mysqli_query($db_con, $member_query);
db_close_con();

$member_query_result_row = mysqli_fetch_assoc($member_query_result);

$member_id = $member_query_result_row['member_id'];
$member_name = $member_query_result_row['member_first_name']." ".$member_query_result_row['member_last_name'];
$member_joined_date = formatted_date_from_ts($member_query_result_row['member_reg_ts']);
$member_total_pjs = get_total_pjs_by_member($member_id);
$member_rank = get_member_reputation(get_member_reputation_number($member_id));
$member_reputation = get_member_reputation_number($member_id);

?>

<div id="pagecontent"> 
 
	<table class="tablebg" width="100%" cellspacing="1"> 
	<tr> 
		<th colspan="2" nowrap="nowrap">Viewing profile - <?php echo $member_name; ?></th> 
	</tr> 
	<tr> 
		<td class="cat" width="40%" align="center"><h4>Profile</h4></td> 
		<td class="cat" width="60%" align="center"><h4>PJer statistics</h4></td> 
	</tr> 
	<tr> 
		<td class="row1" align="center"> 
 
			<table cellspacing="1" cellpadding="2" border="0"> 
						<tr> 
				<td align="center"><b class="gen"><?php echo $member_name; ?></b></td> 
			</tr> 
							<tr> 
					<td class="postdetails" align="center"><?php echo $member_rank; ?></td> 
				</tr> 
	    
			</table> 
		</td> 
		
		<td class="row1"> 
			<table width="100%" cellspacing="1" cellpadding="2" border="0"> 
			<tr> 
				<td class="gen" align="right" nowrap="nowrap">Joined: </td> 
				<td width="100%"><b class="gen"><?php echo $member_joined_date; ?></b></td> 
			</tr> 
			<tr> 
				<td class="gen" align="right" valign="top" nowrap="nowrap">Total PJs: </td> 
				<td><b class="gen"><?php echo $member_total_pjs; ?></b><span class="genmed"><br />[<?php echo number_format(($member_total_pjs/count_rows("pj","")*100),2); ?>% of all PJs]<br /><a href="show_users_pjs.php?u=<?php echo $member_id; ?>">Show user's PJs</a></span></td> 
			</tr> 
			<tr> 
				<td class="gen" align="right" nowrap="nowrap">Reputation: </td> 
				<td width="100%"><b class="gen"><?php echo $member_reputation; ?></b></td> 
			</tr> 

			
						</table> 
		</td> 
	</tr> 

			<tr> 
			<td class="cat" colspan="2" align="right"><?php get_previous_member($member_id); ?> | <?php get_next_member($member_id); ?>&nbsp;</td> 
		</tr> 
<br /> 
 
		</table> 
 
</div> 

 
<br clear="all" /> 