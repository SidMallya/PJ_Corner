<table class="tablebg" width="100%" cellspacing="1">
<tr>
	<td class="cat" colspan="2"><h4>Statistics</h4></td>
</tr>
<tr>
	<td class="row1"><img src="images/statistics.gif" alt="Statistics" /></td>
	<td class="row1" width="100%" valign="middle"><p class="genmed">
	Total PJs <strong> <?php echo count_rows("pj", ""); ?> </strong> | 
	Total registered PJers <strong> <?php echo count_rows("member",""); ?> </strong> | 
	<?php 
	$most_recent_member = explode("-", most_recent_member());	
	$most_recent_member_uid = $most_recent_member[0];
	$most_recent_member_name = $most_recent_member[1];
	?>
	Our newest PJer <strong><a href="member_list.php?mode=viewprofile&u=<?php echo $most_recent_member_uid; ?>"><?php echo $most_recent_member_name; ?></a></strong></p>
	</td>
</tr>
</table>
