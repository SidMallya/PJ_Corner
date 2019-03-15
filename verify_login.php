<?php

if (isset($_POST['member_email']) && isset($_POST['member_password'])) {		
   $fields_ok = 1;
   $member_email = trim($_POST['member_email']);
   $member_password = $_POST['member_password'];
   
   if ($member_email == "" or $member_password == "") {
      $fields_ok = 0;
	  echo '<tr>';
	  echo '<td class="gensmall" colspan="2" align="left"><span class="error">All fields are mandatory.</span></td>';
	  echo '</tr>';
   }
   
   if($fields_ok) {
      $login_ok = count_rows("member","WHERE member_email = '".addslashes($member_email)."' AND member_password = SHA1('".addslashes($member_password)."')");
	  if ($login_ok) {
	     $_SESSION['valid_pjer'] = get_member_id_from_email($member_email);
		 if (isset($_POST['fromurl'])) {
		    $previous_url = $_POST['fromurl'];
			echo '<meta http-equiv="REFRESH" content="0;url='.$previous_url.'">';
			die();
		 }
		 else
		    echo '<meta http-equiv="REFRESH" content="0;url=index.php">';
			die();
	  }
      else {
         echo '<tr>';
	     echo '<td class="gensmall" colspan="2" align="left"><span class="error">Authorization failed.  This has happened either because the email and password did not match or the email is not registered.</span></td>';
	     echo '</tr>';
     }
   }  
}

?>


