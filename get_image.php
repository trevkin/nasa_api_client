<?php
//setup composer and get dependencies
require "vendor/autoload.php";

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

//include image object to store our images 
include "objects/image.php";

session_start();

$imageArray = $_SESSION['images'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : "";

if($id >= 0)
	{		
	if (is_numeric($id))
		{	
		if ($imageArray[$id])
			{
			try {
				//set up a guzzle session and get the json file from the images url
				$client = new Client(['verify' => false]);
				$response = $client->get($_SESSION['images'][$id]->image ,
					[
					//, 'api_key' => 'DDBHdfX1zUe1V5eHyzpQiGcIb6k6oVQLaAoaYFkh']
					]
					);
				//process the response if it was successful
				if ($response->getStatusCode() == 200)
					{
					//convert the json to an array or image urls			
					$imageArray = json_decode($response->getBody(), true);
					
					//check array has elements and then publish the image and specs				
					//if (count($imageArray)>0)
					for($i=0;$i< count($imageArray);$i++) 
						{
						$pathInfoVar = pathinfo($imageArray[$i]);
						if ($pathInfoVar['extension'] == "jpg" || $pathInfoVar['extension'] == "jpeg")
							{	
							echo "<table class='table table-hover table-responsive table-bordered'>";
							echo "	<tr>";
							echo "		<td colspan=\"2\"><img src=\"{$imageArray[$i]}\" style=\"width:100%\"></td>";
							echo "	</tr>";	
							echo "	<tr>";
							echo "		<td>{$_SESSION['images'][$id]->description}</td>";
							echo "		<td>".date("jS M Y",strtotime($_SESSION['images'][$id]->date_created))."</td>";
							echo "	</tr>";
							echo "</table>";
							break;
							}
						}
					}
				}
			catch (GuzzleHttp\Exception\ClientException $e) 
				{	
				echo "<div class='alert alert-danger'>{$e}</div>";
				}
			
			}
		}
	}
?>