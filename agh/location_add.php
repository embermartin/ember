<?php include('functions.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add a location</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
<!--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <style>
  	.shed1{
  		background-color: #cc0000;
  	}
  	.shed2{
  		background-color: #cccc00;
  	}
  	.shed3{
  		background-color: #0000cc;
  	}

  	.chart{
  		height: 30px;
  		width: 200px;
  		background-color: #ddd;
  	}

  	.chart>div{
  		height: 30px;
  		width: 1px;
  		float: left;
  		text-align: right;
  		overflow: hidden;
  		color: white;
  		font-size: 10px;
  		line-height: 30px;
  		padding: 0 2px;
  	}
  </style>
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
			<a href="location_list.php">&larr; Location List</a>
	</nav>

<div class="container">
  <h1 class="my-4 text-center">Add Location</h1>

	<form action="functions.php" method="post">
		<input type="hidden" id="form" name="form" value="location_add" >
		<div class="row">
		    <div class="col-sm">
		      <div class="form-group">
			    <label for="QA">Name</label>
			    <input type="text" class="form-control" name="name" id="name" value="">
			  </div>
		    </div>
		</div>
		
		<div class="row">
			<div class="col-sm">
		      <div class="form-group">
			    <label for="max_capacity">Capacity</label>
			    <input type="number" step="any" step="any" class="form-control" name="max_capacity" id="max_capacity" value="">
			  </div>
		    </div>



		    <div class="col-sm">
		      <div class="form-group">
			    <label for="grower">On site</label>
			    <select class="form-control" name="on_site">
			      <option value="1">On site</option>
			      <option value="0">Off site</option>
			    </select>
			  </div>
		    </div>

		    <div class="col-sm">
		      <div class="form-group">
			    <label for="colour">Colour Indicator</label>
			    <input type="text"class="form-control" name="colour" id="colour" placeholder="i.e. blue, lightgreen, darkred" value="">
			  </div>
		    </div>
		</div>

		<button class="btn btn-success my-2 float-right" type="submit">Update</button><br />
	</form>


</div>

</body>
	<script>
		$('document').ready(function(){
			$(".chart").each(function(){
				var total = 0;
				//create total
				$("div", this).each(function(){
					var value = $(this).data("value");
					total += parseInt(value);
				});
				//set widths
				$("div", this).each(function(){
					var value = $(this).data("value");
					$(this).css("width",(100/total*value)+"%")
				});
			});
		});
	</script>
</html>