<?php 

$total_members = count_rows("member","");


$total_pages_integer = 1;

?>

<form method="post" action="memberlist.php"> 
<table class="tablebg" width="100%" cellspacing="1"> 
<tr> 
	<th nowrap="nowrap" width="10%" >#</th> 
	<th nowrap="nowrap" width="10%" align="left">Username</th> 
	<th nowrap="nowrap" width="15%">Joined</th> 
	<th nowrap="nowrap" width="10%">Posts</th> 
	<th nowrap="nowrap" width="15%">Rank</th> 
	<th nowrap="nowrap" width="11%">Reputation</th> 
	</tr> 
<tr class="row2"> 
		<td class="gen" align="center">&nbsp;1&nbsp;</td> 
		<td class="genmed" align="left"><a href="./memberlist.php?mode=viewprofile&amp;u=7">Craig</a></td> 
		<td class="genmed" align="center" nowrap="nowrap">&nbsp;Fri Apr 19, 2002 2:43 am&nbsp;</td> 
		<td class="gen" align="center">37</td> 
		<td class="gen" align="center">Forum Commoner</td> 
		<td class="gen" align="center">&nbsp;&nbsp;</td> 
</tr> 
 
<tr class="row1"> 
	<td class="gen" align="center">&nbsp;2&nbsp;</td> 
	<td class="genmed" align="left"><a href="./memberlist.php?mode=viewprofile&amp;u=2" style="color: #005500;" class="username-coloured">jason</a></td> 
	<td class="genmed" align="center" nowrap="nowrap">&nbsp;Fri Apr 19, 2002 2:44 am&nbsp;</td> 
	<td class="gen" align="center">1715</td> 
	<td class="gen" align="center">Site Admin</td> 
	<td class="gen" align="center">&nbsp;&nbsp;</td> 
</tr> 
 

 
 
<tr> 
	<td class="cat" colspan="8" align="center"><span class="gensmall"></td> 
</tr> 
</table> 
	
</form> 
 
<table width="100%" cellspacing="0" cellpadding="0"> 
<tr> 
	<td class="pagination">Page <strong>1</strong> of <strong>2563</strong> [ <?php echo $total_members; ?> PJers ]</td> 
	<td align="right"><span class="pagination"><b>Go to page</b></span>
		<form name="jump1"  >
           <select name="myjumpbox" OnChange="location.href=jump1.myjumpbox.options[selectedIndex].value">
			  <?php
			  for($pn = 1; $pn <= $total_pages_integer; $pn++) {
                 echo '<option '.select_current_page($page, $pn).' value="showmembers.php?page='.$pn.'">'.$pn;
			  }
			  ?>
 		   </select>
		</form>	
	</td> 
</tr> 
</table> 
 