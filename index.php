<?php
//Start your session.
session_start();
//setup composer and get dependencies
require "vendor/autoload.php";


//include image object to store our images 
include "objects/image.php";

//include the header file and populate its title
$page_title = "Search NASA images";
include "layout_header.php";

//get the search form and guzzle call code
include "search.php";

if (isset($_SESSION['images']))
	{
	$columnLimit = 4;
	$itemsPerColumnLimit = (int)floor(count($_SESSION['images'])/ $columnLimit);
	$extras = count($_SESSION['images']) % $columnLimit;
	$currentColumnCount = 1;
	$currentItemsCount = 0;
	$currentExtrasCount = 0;
	echo "<div class=\"row\">";
	echo "	<div class=\"column\">";
	
	//loop through each item in the image array from the session
	foreach ($_SESSION['images'] as $image)
		{
		echo "	    <a class=\"rig-cell\" href=\"javascript:getDesc({$image->id});\" data-placement=\"bottom\" title=\"Click for larger image!\">";
		echo "		<img src=\"{$image->preview}\" style=\"width:100%\"  />";
		echo "	    </a>";	
		++$currentItemsCount;
		if ($currentItemsCount >= $itemsPerColumnLimit)
			{
			if ($currentExtrasCount < $extras)
				{
				++$currentExtrasCount;
				--$currentItemsCount;
				continue;
				}
			if ($currentColumnCount < $columnLimit)
				{
				echo "</div>";
				echo "<div class=\"column\">";
				
				$currentItemsCount=0;
				++$currentColumnCount;
				}
			else
				{
				echo "</div>";
				}
			}
		
			
		
		}
	echo "</div>";	
	}
	

//include the bootstrap modal and the footer
include "modal.php";
include "layout_footer.php";
?>