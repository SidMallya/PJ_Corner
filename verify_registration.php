<tr>
	<td class="row3" colspan="2" align="center">
	<span class="gensmall error">

<?php

$fields_valid = 1;

if(isset($_POST['registration_code'])) { 
   $valid_registration_code = "e05678b3fcf4f11551586a3f3c2b65fde212ed2a"; //SHA1('pj_registration_code')
   $registration_code = $_POST['registration_code'];
   if ($registration_code != $valid_registration_code) {
      $fields_valid = 0;
      echo 'Registration code is invalid.<br />';
   }
}

if(isset($_POST['member_first_name'])) {
   $member_first_name = ucwords(strtolower(trim($_POST['member_first_name'])));
   if (strlen($member_first_name) < 3) {
      $fields_valid = 0;	  
	  echo 'The first name you entered is too short.<br />';
   }
   if (strlen($member_first_name) > 16) {
      $fields_valid = 0;	  
	  echo 'The first name you entered is too long.<br />';
   }
   if (!ctype_alpha($member_first_name)) {
      $fields_valid = 0;
	  echo 'The first name you entered must contain only alphabets.<br />';
   }   
}

if(isset($_POST['member_last_name'])) {
   $member_last_name = ucwords(strtolower(trim($_POST['member_last_name'])));
   if (strlen($member_last_name) < 1) {
      $fields_valid = 0;	  
	  echo 'The last name you entered is too short.<br />';
   }
   if (strlen($member_last_name) > 28) {
      $fields_valid = 0;	  
	  echo 'The last name you entered is too long.<br />';
   }
   if (!ctype_alpha($member_last_name)) {
      $fields_valid = 0;
	  echo 'The last name you entered must contain only alphabets.<br />';
   }   
}

if(isset($_POST['member_email'])) {
   $member_email = strtolower(trim($_POST['member_email']));
   if (!eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$', $member_email)) {
      $fields_valid = 0;
      echo "The e-mail address you entered is invalid.<br />";
   }
   else {
      $matching_email_row_count = count_rows("member", "WHERE member_email = '".$member_email."'");
	  if($matching_email_row_count > 0) {
         $fields_valid = 0;
         echo "You have already registered in the past.  Only one account per person is allowed.<br />";
      }
   }
}

if (isset($_POST['member_password']) && isset($_POST['member_password_confirm'])) {
   $member_password = $_POST['member_password'];
   $member_password_confirm = $_POST['member_password_confirm'];
   if ($member_password != $member_password_confirm) {
      $fields_valid = 0;
      echo "The passwords you entered do not match.<br />";
   }
   else {
      if (strlen($member_password) < 6) {
	     $fields_valid = 0;
         echo "The password you entered is too short.<br />";
      }
      if (strlen($member_password) > 30) {
	     $fields_valid = 0;
         echo "The password you entered is too long.<br />";
      }

	  $valid_values = array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
                            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
      $invalid_values = str_replace($valid_values, "", strtolower($member_password));
	  if ($invalid_values != '') {
	     $fields_valid = 0;
	     echo "The password you entered contains invalid characters.<br />";
      }
      $easy_passwords = array("password", "secret", "accenture", "iloveyou", "mallya", "siddharth");
	  if (in_array(strtolower($member_password), $easy_passwords) || strtolower($member_password) == strtolower($member_first_name) || strtolower($member_password) == strtolower($member_last_name)) {
	     $fields_valid = 0;
	     echo "The password you entered is too easy for others to guess.<br />";
      }	  
   }   
}

if ($fields_valid && isset($_POST['registration_code']) && isset($_POST['member_first_name']) && isset($_POST['member_last_name']) && isset($_POST['member_email']) && isset($_POST['member_password']) && isset($_POST['member_password_confirm'])) {
   
   db_con();
   
   $insert_member = "INSERT INTO member (member_reg_ts, member_update_ts, member_first_name, member_last_name, member_email, member_password) 
                                       VALUES (NULL,NULL,'".$member_first_name."','".$member_last_name."','".$member_email."',sha1('".$member_password."'))";
 			   
   $insert_member_result = mysqli_query($db_con, $insert_member);
   if ($insert_member_result) {
      echo '<div style="color:green">Registration successful.  Click <a href="login.php">here</a> to login.</div>';
   }
   else 
      echo "Registration unsuccessful due to technical problems.  Error(for support personnel): ".mysqli_error($db_con)." <br />";
 
   db_close_con();
}   




	
?>

	</span>
	</td>
</tr>


