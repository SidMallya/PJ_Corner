<?php
   session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-gb" xml:lang="en-gb">	
<head>

<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="content-language" content="en-gb" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="imagetoolbar" content="no" />
<!--<meta http-equiv="Pragma" content="no-cache">-->
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta name="copyright" content="Siddharth Mallya" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<title>PJ Corner &bull; Search</title>

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

<div id="pagecontent"> 
 
	<form method="get" action="search_results.php"> 
	
	<table class="tablebg" width="100%" cellspacing="1"> 
	<tr> 
		<th colspan="4">Search query</th> 
	</tr> 
	
<?php	

   if(isset($_GET['search_error'])) {
      echo '<tr>';
      switch ($_GET['search_error']) {
         case 1:
		    echo '<td class="row3" colspan="3" align="center"><span class="gensmall">The keyword field size exceeded maximum.</span></td>';
            break;
         case 2:
            echo '<td class="row3" colspan="3" align="center"><span class="gensmall">The author field size exceeded maximum.</span></td>';
			break;		    
         case 3:
            echo '<td class="row3" colspan="3" align="center"><span class="gensmall">Enter at least one search criteria.</span></td>';
			break;
         case 4:
            echo '<td class="row3" colspan="3" align="center"><span class="gensmall">The keyword field size is too small.<br />The author field size is too small.</span></td>';
			break;   
         case 5:
            echo '<td class="row3" colspan="3" align="center"><span class="gensmall">The keyword field size is too small.</span></td>';
			break;
         case 6:
            echo '<td class="row3" colspan="3" align="center"><span class="gensmall">The author field size is too small.</span></td>';
			break;   
         default:
            echo '<td class="row3" colspan="3" align="center"><span class="gensmall">Unknown search error.</span></td>';
			break;  
      }
	  echo '</tr>';
   }
	
?>	

	<tr> 
		<td class="row1" colspan="2" width="50%"><b class="genmed">Search for keywords: </b><br /><span class="gensmall">Specify keywords to be searched separated by spaces.</span></td> 
		<td class="row2" colspan="2" valign="top"><input type="text" style="width: 300px" class="post" name="keywords" size="30" maxlength="50" /></td> 
	</tr> 
	<tr> 
		<td class="row1" colspan="2"><b class="genmed">Search for author:</b><br /><span class="gensmall">If specified the search returns the matching PJs by the author.</span></td> 
		<td class="row2" colspan="2" valign="middle"><input type="text" style="width: 300px" class="post" name="author" size="30" maxlength="45" /></td> 
	</tr> 
	<tr> 
		<td class="cat" colspan="4" align="center">
<input class="btnmain" type="submit" value="Search" />&nbsp;&nbsp;<input class="btnlite" type="reset" value="Reset" /></td> 
	</tr> 
	</table> 
	
	</form> 
 
	<br clear="all" /> 
 
</div> 

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


