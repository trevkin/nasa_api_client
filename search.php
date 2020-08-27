<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<table class='table table-hover table-responsive table-bordered'>
 <tr>
        <td colspan="2">This site allows you to search the amazing NASA image archive via it's API</td>
       
    </tr>
     <tr>
        <td>Search Term</td>
        <td><input name="query" value="" placeholder="Planet, moon, mission, astronaut etc" class="form-control"/></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <button type="submit" class="btn btn-primary" >Search</button>
        </td>
    </tr>
</table>
<form><?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

//if the form has been submitted send the api call
if($_POST)
	{
	if ($_POST['query'] && $_POST['query'] != "")
		{
		try {
			$client = new Client(['verify' => false]);
			$response = $client->get("https://images-api.nasa.gov/search" ,
			[
			'query' => ['q' => $_POST['query']]
			//, 'api_key' => 'DDBHdfX1zUe1V5eHyzpQiGcIb6k6oVQLaAoaYFkh']
			]
			);
			//process the response if it was successful
			if ($response->getStatusCode() == 200)
				{
				//convert the json to an object
				$someObject = json_decode($response->getBody());
				$imagesArray = array();
				// Loop through the items array within the Object				  
				for($i=0;$i< count($someObject->collection->items);$i++) 
					{
					$image = new Image();
					$image->id = $i;
					$image->title = $someObject->collection->items[$i]->data[0]->title;
					$image->description = $someObject->collection->items[$i]->data[0]->description;
					$image->image = $someObject->collection->items[$i]->href;
					//echo $someObject->collection->items[$i]->href;
					$image->date_created = $someObject->collection->items[$i]->data[0]->date_created;
					
					for($j=0;$j<count($someObject->collection->items[$i]->links);$j++) 
						{
						if ($someObject->collection->items[$i]->links[$j]->rel == "preview")
							{
							$image->preview = $someObject->collection->items[$i]->links[$j]->href;
							}						
						}	
					$imagesArray[] = $image;						
					}
				
				$_SESSION['images'] = $imagesArray;
				echo "<div class='alert alert-success'>Response received for query: {$_POST['query']}</div>";
				}
			}
		catch (GuzzleHttp\Exception\ClientException $e) 
			{	
			echo "<div class='alert alert-danger'>{$e}</div>";
			}
		}
	else
		{
		unset($_SESSION['images']);
		echo "<div class='alert alert-danger'>You didn't search for anything?</div>";	
		}
	}
else
	{
	unset($_SESSION['images']);
	}

?>