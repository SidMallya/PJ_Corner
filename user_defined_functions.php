<?php

//User defined functions 

function db_con() {
   
   global $db_con;
   @ $db_con = mysqli_connect("localhost","root","changeme","test");
   
   date_default_timezone_set('Asia/Calcutta');
        
   if (mysqli_connect_errno()) {
      printf("Connect failed:  %s\n", mysqli_connect_error());
      exit();
   }
   
   mysqli_query($db_con, "SET SESSION time_zone = '+05:30'");

}

function db_close_con() {
   global $db_con;
   mysqli_close($db_con);
}

function count_rows($cr_tablename, $cr_where_condition) {

   db_con();

   global $db_con;
   $cr_result = mysqli_query($db_con, "SELECT COUNT(*) AS row_count FROM ".$cr_tablename." ".$cr_where_condition);
   $cr_row = mysqli_fetch_assoc($cr_result);
         
   db_close_con();
   
   return $cr_row['row_count'];

}

function most_recent_member() {

   db_con();

   global $db_con;
   $mrm_query = "SELECT member_id,member_first_name,member_last_name FROM member WHERE member_reg_ts = (SELECT MAX(member_reg_ts) FROM member)";
   $mrm_result = mysqli_query($db_con, $mrm_query);
   $mrm_row = mysqli_fetch_assoc($mrm_result);
         
   db_close_con();
   
   return $mrm_row['member_id']."-".$mrm_row['member_first_name']." ".$mrm_row['member_last_name'];

}

function get_member_name_from_id($gmnfi_pj_member_id) {

   db_con();

   global $db_con;
   $gmnfi_query = "SELECT member_first_name,member_last_name FROM member WHERE member_id = ".$gmnfi_pj_member_id;
   $gmnfi_result = mysqli_query($db_con, $gmnfi_query);
   $gmnfi_row = mysqli_fetch_assoc($gmnfi_result);
         
   db_close_con();
   
   return $gmnfi_row['member_first_name']." ".$gmnfi_row['member_last_name'];


}

function get_member_id_from_email($gmife_member_email) {

   db_con();

   global $db_con;
   $gmife_query = "SELECT member_id FROM member WHERE member_email = '".$gmife_member_email."'";
   $gmife_result = mysqli_query($db_con, $gmife_query);
   $gmife_row = mysqli_fetch_assoc($gmife_result);
         
   db_close_con();
   
   return $gmife_row['member_id'];

}

function get_email_from_member_id($gefmi_member_id) {

   db_con();

   global $db_con;
   $gefmi_query = "SELECT member_email FROM member WHERE member_id = ".$gefmi_member_id;
   $gefmi_result = mysqli_query($db_con, $gefmi_query);
   $gefmi_row = mysqli_fetch_assoc($gefmi_result);
         
   db_close_con();
   
   return $gefmi_row['member_email'];

}

// Below two functions are by Johan Kdnngerd

function selfURL() {
	$s = empty($_SERVER["HTTPS"]) ? ''
		: ($_SERVER["HTTPS"] == "on") ? "s"
		: "";
	$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
	$port = ($_SERVER["SERVER_PORT"] == "80") ? ""
		: (":".$_SERVER["SERVER_PORT"]);
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
}

function strleft($s1, $s2) {
	return substr($s1, 0, strpos($s1, $s2));
}

function formatted_date_from_ts($fdft_ts) {

   db_con();
   
   global $db_con;
   $fdft_result = mysqli_query($db_con, "SELECT DATE_FORMAT('".$fdft_ts."', '%a %b %d, %Y %l:%i %p') as formatted_date");
   $fdft_row = mysqli_fetch_assoc($fdft_result);
   db_close_con();
   
   return $fdft_row['formatted_date'];
}

function get_total_pjs_by_member($gtpbm_member_id) {
   return count_rows("pj", "WHERE pj_member_id = ".$gtpbm_member_id);
}

function get_member_reputation_number($gmrn_member_id) {

   $total_pjs_by_member = get_total_pjs_by_member($gmrn_member_id);

   db_con();
   global $db_con;
   $gmrn_result = mysqli_query($db_con, "SELECT SUM(pj_rating/2) as total_member_rating FROM pj WHERE pj_member_id =".$gmrn_member_id);
   $gmrn_row = mysqli_fetch_assoc($gmrn_result);
   $total_member_rating = $gmrn_row['total_member_rating'];
   db_close_con();

   $member_reputation_number = (int)($total_pjs_by_member + $total_member_rating);
   return $member_reputation_number;
}

function get_member_reputation($gmr_reputation_number) {

   switch(true) {
      case ($gmr_reputation_number <= 5): 
	     return "Newborn PJer";	  
	     break;
      case ($gmr_reputation_number <= 10): 
	     return "Kindergarten PJer";	  
	     break;
      case ($gmr_reputation_number <= 30): 
	     return "Junior PJer";	  
	     break;
      case ($gmr_reputation_number <= 60): 
	     return "Senior PJer";	  
	     break;
      case ($gmr_reputation_number <= 100): 
	     return "PJ Guru";	  
	     break;
      case ($gmr_reputation_number <= 150): 
	     return "PJ Black Belt";	  
	     break;
      case ($gmr_reputation_number <= 210): 
	     return "PJ Expert";	  
	     break;
      case ($gmr_reputation_number <= 300): 
	     return "PJ Ph.D";	  
	     break;
      case ($gmr_reputation_number <= 500): 
	     return "PJ Grandmaster";	  
	     break;
      case ($gmr_reputation_number >= 501): 
	     return "PJ God";	  
	     break;
	  default:
	     return "Ghost PJer";
		 break;
   } 
}

function get_registered_date($grd_member_id) {

   db_con();
   global $db_con;
   $grd_result = mysqli_query($db_con, "SELECT DATE_FORMAT(member_reg_ts, '%a %b %d, %Y %l:%i %p') as member_registered_date FROM member WHERE member_id = ".$grd_member_id);
   $grd_row = mysqli_fetch_assoc($grd_result);   
   db_close_con();

   return $grd_row['member_registered_date'];
   
}

function update_pj_views($upv_pj_id) {

   db_con();
   global $db_con;
   $upv_result = mysqli_query($db_con, "UPDATE pj SET pj_views = pj_views + 1 WHERE pj_id = ".$upv_pj_id);
   db_close_con();

}

function get_rating_text($gri_pj_rating) {
   switch ($gri_pj_rating) {
      case(10):
	    return 'Excellent';
		break;
      case(9):
	    return 'Superb';
		break;
      case(8):
	    return 'Very Good';
		break;
      case(7):
	    return 'Good';
		break;
      case(6):
	    return 'Above Average';
		break;
      case(5):
	    return 'Average';
		break;
      case(4):
	    return 'Below Average';
		break;
      case(3):
	    return 'Poor';
		break;
      case(2):
	    return 'Bad';
		break;
      case(1):
	    return 'Horrible';
		break;
      case(0):
	    return 'Not rated yet';
		break;		
   }
}

function get_previous_pj($gpp_pj_id) {	
   $older_pjs = count_rows("pj", "WHERE pj_id < ".$gpp_pj_id);
   
   if ($older_pjs) {
      db_con();
      global $db_con;
      $gpp_result = mysqli_query($db_con, "SELECT pj_id FROM pj WHERE pj_id < ".$gpp_pj_id." ORDER BY pj_id DESC LIMIT 1;");
      $gpp_row = mysqli_fetch_assoc($gpp_result);   
      db_close_con();

      $gpp_previous_pj_id =  $gpp_row['pj_id'];   
	  echo '<a href="view_pj.php?pj_id='.$gpp_previous_pj_id.'">Previous PJ</a>';
   }
   else {
      echo 'Previous PJ ';
   }
}

function get_next_pj($gnp_pj_id) {	
   $newer_pjs = count_rows("pj", "WHERE pj_id > ".$gnp_pj_id);
   
   if ($newer_pjs) {
      db_con();
      global $db_con;
      $gnp_result = mysqli_query($db_con, "SELECT pj_id FROM pj WHERE pj_id > ".$gnp_pj_id." ORDER BY pj_id ASC LIMIT 1;");
      $gnp_row = mysqli_fetch_assoc($gnp_result);   
      db_close_con();

      $gnp_next_pj_id =  $gnp_row['pj_id'];   
	  echo '<a href="view_pj.php?pj_id='.$gnp_next_pj_id.'">Next PJ</a>';
   }
   else {
      echo 'Next PJ ';
   }
}

function select_current_page($scp_page, $scp_pn) {
   if ($scp_page == $scp_pn) 
      return 'selected="'.$scp_pn.'"';
   else
      return "";
}

function get_previous_page_href_i() {
    global $content;
	if (isset($_GET['pn'])) {
		if (is_numeric($_GET['pn'])) {
           if ($_GET['pn'] <= 1)
		      echo 'Previous Page';
		   else 
		      echo '<a href="index.php?content='.$content.'&pn='.($_GET['pn'] - 1).'">Previous Page</a>';
		}
		else
		   echo 'Previous Page';
	}
	else 
	echo 'Previous Page';
}

function get_next_page_href_i() {
    global $content;
	if (isset($_GET['pn'])) {	
		if (is_numeric($_GET['pn'])) {
		   $gnph_total_pjs = count_rows("pj", "");	
		   $gnph_total_pages_decimal = $gnph_total_pjs / 10;
		   $gnph_remainder = $gnph_total_pjs % 10; 

		   if ($gnph_remainder == 0) {
		      $gnph_total_pages_integer = (int)$gnph_total_pages_decimal;
		   }
		   else {
		      $gnph_total_pages_integer = (int)$gnph_total_pages_decimal + 1;
		   }		
		
           if ($_GET['pn'] >= $gnph_total_pages_integer)
		      echo 'Next Page';
		   else 
		      echo '<a href="index.php?content='.$content.'&pn='.($_GET['pn'] + 1).'">Next Page</a>';
		}
		else {
		    $gnph_total_pjs = count_rows("pj", "");	
			if ($gnph_total_pjs <= 10)
			  echo 'Next Page';
			else
			  echo '<a href="index.php?content='.$content.'&pn=2">Next Page</a>';		
		}
	}
	else {
	   $gnph_total_pjs = count_rows("pj", "");	
	   if ($gnph_total_pjs <= 10)
	      echo 'Next Page';
	   else
	      echo '<a href="index.php?content='.$content.'&pn=2">Next Page</a>';
    }
}

function get_previous_page_href_m() {
	if (isset($_GET['pn'])) {
		if (is_numeric($_GET['pn'])) {
           if ($_GET['pn'] <= 1)
		      echo 'Previous Page';
		   else 
		      echo '<a href="member_list.php?pn='.($_GET['pn'] - 1).'">Previous Page</a>';
		}
		else
		   echo 'Previous Page';
	}
	else 
	echo 'Previous Page';
}

function get_next_page_href_m() {
	if (isset($_GET['pn'])) {	
		if (is_numeric($_GET['pn'])) {
		   $gnph_total_members = count_rows("member", "");	
		   $gnph_total_pages_decimal = $gnph_total_members / 25;
		   $gnph_remainder = $gnph_total_members % 25; 

		   if ($gnph_remainder == 0) {
		      $gnph_total_pages_integer = (int)$gnph_total_pages_decimal;
		   }
		   else {
		      $gnph_total_pages_integer = (int)$gnph_total_pages_decimal + 1;
		   }		
		
           if ($_GET['pn'] >= $gnph_total_pages_integer)
		      echo 'Next Page';
		   else 
		      echo '<a href="member_list.php?pn='.($_GET['pn'] + 1).'">Next Page</a>';
		}
		else {
		    $gnph_total_members = count_rows("member", "");	
			if ($gnph_total_members <= 25)
			  echo 'Next Page';
			else
			  echo '<a href="member_list.php?pn=2">Next Page</a>';		
		}
	}
	else {
	   $gnph_total_members = count_rows("member", "");	
	   if ($gnph_total_members <= 25)
	      echo 'Next Page';
	   else
	      echo '<a href="member_list.php?pn=2">Next Page</a>';
    }
}

function get_previous_member($gpm_member_id) {	
   $older_members = count_rows("member", "WHERE member_id < ".$gpm_member_id);
   
   if ($older_members) {
      db_con();
      global $db_con;
      $gpm_result = mysqli_query($db_con, "SELECT member_id FROM member WHERE member_id < ".$gpm_member_id." ORDER BY member_id DESC LIMIT 1;");
      $gpm_row = mysqli_fetch_assoc($gpm_result);   
      db_close_con();

      $gpm_previous_member_id =  $gpm_row['member_id'];   
	  echo '<a href="member_list.php?mode=viewprofile&u='.$gpm_previous_member_id.'">Previous member</a>';
   }
   else {
      echo 'Previous member';
   }
}

function get_next_member($gnm_member_id) {	
   $newer_members = count_rows("member", "WHERE member_id > ".$gnm_member_id);
   
   if ($newer_members) {
      db_con();
      global $db_con;
      $gnm_result = mysqli_query($db_con, "SELECT member_id FROM member WHERE member_id > ".$gnm_member_id." ORDER BY member_id ASC LIMIT 1;");
      $gnp_row = mysqli_fetch_assoc($gnm_result);   
      db_close_con();

      $gnm_next_member_id =  $gnp_row['member_id'];   
	  echo '<a href="member_list.php?mode=viewprofile&u='.$gnm_next_member_id.'">Next member</a>';
   }
   else {
      echo 'Next member';
   }
}

function get_previous_page_href_sup() {
	if (isset($_GET['pn'])) {
		if (is_numeric($_GET['pn'])) {
           if ($_GET['pn'] <= 1)
		      echo 'Previous Page';
		   else 
		      echo '<a href="show_users_pjs.php?u='.$_GET['u'].'&pn='.($_GET['pn'] - 1).'">Previous Page</a>';
		}
		else
		   echo 'Previous Page';
	}
	else 
	echo 'Previous Page';
}

function get_next_page_href_sup() {
	if (isset($_GET['pn'])) {	
		if (is_numeric($_GET['pn'])) {
		   $gnph_total_pjs = count_rows("pj", "WHERE pj_member_id = ".$_GET['u']);	
		   $gnph_total_pages_decimal = $gnph_total_pjs / 10;
		   $gnph_remainder = $gnph_total_pjs % 10; 

		   if ($gnph_remainder == 0) {
		      $gnph_total_pages_integer = (int)$gnph_total_pages_decimal;
		   }
		   else {
		      $gnph_total_pages_integer = (int)$gnph_total_pages_decimal + 1;
		   }		
		
           if ($_GET['pn'] >= $gnph_total_pages_integer)
		      echo 'Next Page';
		   else 
		      echo '<a href="show_users_pjs.php?u='.$_GET['u'].'&pn='.($_GET['pn'] + 1).'">Next Page</a>';
		}
		else {
		    $gnph_total_pjs = count_rows("pj", "");	
			if ($gnph_total_pjs <= 10)
			  echo 'Next Page';
			else
			  echo '<a href="show_users_pjs.php?u='.$_GET['u'].'&pn=2">Next Page</a>';		
		}
	}
	else {
	   $gnph_total_pjs = count_rows("pj", "WHERE pj_member_id = ".$_GET['u']);	
	   if ($gnph_total_pjs <= 10)
	      echo 'Next Page';
	   else
	      echo '<a href="show_users_pjs.php?u='.$_GET['u'].'&pn=2">Next Page</a>';
    }
}

function get_previous_user_pj($gpp_pj_id) {
   $older_pjs = count_rows("pj", "WHERE pj_id < ".$gpp_pj_id." AND pj_member_id = ".$_GET['u']);
   
   if ($older_pjs) {
      db_con();
      global $db_con;
      $gpp_result = mysqli_query($db_con, "SELECT pj_id FROM pj WHERE pj_id < ".$gpp_pj_id." AND pj_member_id = ".$_GET['u']." ORDER BY pj_id DESC LIMIT 1;");
      $gpp_row = mysqli_fetch_assoc($gpp_result);   
      db_close_con();

      $gpp_previous_pj_id =  $gpp_row['pj_id'];   
	  echo '<a href="view_user_pj.php?u='.$_GET['u'].'&pj_id='.$gpp_previous_pj_id.'">Previous PJ</a>';
   }
   else {
      echo 'Previous PJ ';
   }
}

function get_next_user_pj($gnp_pj_id) {	
   $newer_pjs = count_rows("pj", "WHERE pj_id > ".$gnp_pj_id." AND pj_member_id = ".$_GET['u']);
   
   if ($newer_pjs) {
      db_con();
	  global $db_con;
      $gnp_result = mysqli_query($db_con, "SELECT pj_id FROM pj WHERE pj_id > ".$gnp_pj_id." AND pj_member_id = ".$_GET['u']." ORDER BY pj_id ASC LIMIT 1;");
      $gnp_row = mysqli_fetch_assoc($gnp_result);   
      db_close_con();

      $gnp_next_pj_id =  $gnp_row['pj_id'];   
	  echo '<a href="view_user_pj.php?u='.$_GET['u'].'&pj_id='.$gnp_next_pj_id.'">Next PJ</a>';
   }
   else {
      echo 'Next PJ ';
   }
}

function get_previous_page_href_sr() {
    global $search_keywords;
	global $search_author;
	if (isset($_GET['pn'])) {
		if (is_numeric($_GET['pn'])) {
           if ($_GET['pn'] <= 1)
		      echo 'Previous Page';
		   else 
		      echo '<a href="search_results.php?keywords='.$search_keywords.'&author='.$search_author.'&pn='.($_GET['pn'] - 1).'">Previous Page</a>';
		}
		else
		   echo 'Previous Page';
	}
	else 
	echo 'Previous Page';
}

function get_next_page_href_sr() {
    global $search_keywords;
	global $search_author;
	global $table_names;
	global $where_clause;
	if (isset($_GET['pn'])) {	
		if (is_numeric($_GET['pn'])) {
		   $gnph_total_pjs = count_rows($table_names, $where_clause);	
		   $gnph_total_pages_decimal = $gnph_total_pjs / 10;
		   $gnph_remainder = $gnph_total_pjs % 10; 

		   if ($gnph_remainder == 0) {
		      $gnph_total_pages_integer = (int)$gnph_total_pages_decimal;
		   }
		   else {
		      $gnph_total_pages_integer = (int)$gnph_total_pages_decimal + 1;
		   }		
		
           if ($_GET['pn'] >= $gnph_total_pages_integer)
		      echo 'Next Page';
		   else 
		      echo '<a href="search_results.php?keywords='.$search_keywords.'&author='.$search_author.'&pn='.($_GET['pn'] + 1).'">Next Page</a>';
		}
		else {
		    $gnph_total_pjs = count_rows($table_names, $where_clause);	
			if ($gnph_total_pjs <= 10)
			  echo 'Next Page';
			else
			  echo '<a href="search_results.php?keywords='.$search_keywords.'&author='.$search_author.'&pn=2">Next Page</a>';		
		}
	}
	else {
	   $gnph_total_pjs = count_rows($table_names, $where_clause);	
	   if ($gnph_total_pjs <= 10)
	      echo 'Next Page';
	   else
	      echo '<a href="search_results.php?keywords='.$search_keywords.'&author='.$search_author.'&pn=2">Next Page</a>';
    }
}


?>


