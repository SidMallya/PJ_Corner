<div id="wrapheader">

	<div id="logodesc">
		<table width="100%" cellspacing="0">
		<tr>
			<td><img src="images/PJ_corner_logo.png" alt="" title="" HEIGHT="80", WIDTH="200"/></td>
			<td width="100%" align="center"><h1>PJ Corner</h1><span class="gen">Discover your hidden PJ talent</span></td>
		</tr>
		</table>
	</div>
	
	<div id="menubar">
		<table width="100%" cellspacing="0">
		<tr>
			<?php 
               if (isset($_SESSION['valid_pjer'])) {
			?>
			
			<td class="genmed">
				<a href="logout.php"><img src="images/icon_mini_login.gif" width="12" height="13" alt="*" /> Logout [ <?php echo get_member_name_from_id($_SESSION['valid_pjer']); ?> ]</a></td>
			<td class="genmed" align="right">
				<a href="faq.php"><img src="images/icon_mini_faq.gif" width="12" height="13" alt="*" /> FAQ</a>
				&nbsp; &nbsp;<a href="search.php"><img src="images/icon_mini_search.gif" width="12" height="13" alt="*" /> Search</a>&nbsp; &nbsp;<a href="member_list.php"><img src="images/icon_mini_members.gif" width="12" height="13" alt="*" /> Members</a>&nbsp; &nbsp;<a href="account_settings.php"><img src="images/icon_mini_profile.gif" width="12" height="13" alt="*" /> Account Settings</a>			</td>

			<?php 
			}
			   else {
            ?>
				
			
			<td class="genmed">
				<a href="login.php"><img src="images/icon_mini_login.gif" width="12" height="13" alt="*" /> Login</a>&nbsp; &nbsp;<a href="register.php"><img src="images/icon_mini_register.gif" width="12" height="13" alt="*" /> Register</a>
								</td>
			<td class="genmed" align="right">
				<a href="faq.php"><img src="images/icon_mini_faq.gif" width="12" height="13" alt="*" /> FAQ</a>
				&nbsp; &nbsp;<a href="search.php"><img src="images/icon_mini_search.gif" width="12" height="13" alt="*" /> Search</a>			</td>

			<?php 
			}
            ?>




				</tr>
		</table>
	</div>

	<div id="datebar">
		<table width="100%" cellspacing="0">
		<tr>
			<td class="gensmall"></td>
			<td class="gensmall" align="right">
			<?php
			date_default_timezone_set('Asia/Calcutta');
			echo date("D M d, Y g:i A");
			?>
			<br /></td>
		</tr>
		</table>
	</div>

</div>
