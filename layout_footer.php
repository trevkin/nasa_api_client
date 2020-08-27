</div>
    <!-- /container -->
 
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
 
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
<!-- bootbox library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script>
function getDesc(id)
	{//$('#image_modal').modal('show')		
	$.ajax
		({
    	type: 'GET',
    	url: 'get_image.php',
    	data: {'id':id},
    	dataType: 'text',
    success: function(data)
			{			
      		$('#image_modal').find('.modal-body').html(data);		
			$('#image_modal').modal('show');	
    		}
		});
	}
$(document).ready(function(){
    $('[class="rig-cell"]').tooltip();   
});

</script>
</body>
</html>