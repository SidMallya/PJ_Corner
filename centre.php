<div id="wrapcentre">
		<p class="searchbar">
		<span style="float: left;"><a href="index.php?content=most_recent">Most Recent PJs</a> | <a href="index.php?content=most_viewed">Most Viewed PJs</a> | <a href="index.php?content=top_rated">Top rated PJs</a></span>
			</p>
	
	<br style="clear: both;" />

	<table class="tablebg" width="100%" cellspacing="1" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="index.php">PJ index</a></p>
			<p class="datetime">All times are IST </p>
		</td>
	</tr>
	</table>
    <br />

<?php	
   if (!isset($content))
      $content = "most_recent";


if (isset($_REQUEST['content'])) {

   $content = $_REQUEST['content'];
   
}

switch ($content) {
	case "most_recent":
	 $pj_sort_type = "Most Recent - ";
	 $order_by = "pj_post_ts";
	 break;
	case "most_viewed":
	 $pj_sort_type = "Most Viewed - ";
	 $order_by = "pj_views";
	 break;
	case "top_rated":
	 $pj_sort_type = "Top Rated - ";
	 $order_by = "pj_rating";
	 break;
	default:
	 $pj_sort_type = "Most Recent - ";
	 $order_by = "pj_post_ts";
	 $content = "most_recent";
	 break;
}	  

	  

	  
?>	

<table class="tablebg" cellspacing="1" width="100%">
<tr>
	<td class="cat" colspan="5" align="right"><b><?php get_previous_page_href_i(); ?></b> | <b><?php get_next_page_href_i(); ?></b>&nbsp;</td>
</tr>
<tr>
	<th colspan="2">&nbsp;PJ&nbsp;</th>
	<th width="50">&nbsp;Views&nbsp;</th>
	<th width="50">&nbsp;Rating&nbsp;</th>
	<th>&nbsp;Posted on and by&nbsp;</th>
</tr>

<?php

include 'show_pj_list.php';
include 'statistics.php';

?>		
			
<br clear="all" />

</div>