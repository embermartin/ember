<?php include('functions.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>QA Management</title>
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
			<a href="client_list.php">&larr; Client List</a>
	</nav>

<div class="container">
	
	<?php
		if(isset($_GET["id"])){
			$id = $_GET["id"];
		}
		$sql = "SELECT * FROM client WHERE id = " . $id;
		$result = $conn->query($sql);
		$row = mysqli_fetch_assoc($result);
	?>
  <h1 class="my-4 text-center"><?php echo $row["name"]; ?></h1>

	<form action="functions.php" method="post">
		<input type="hidden" id="form" name="form" value="client_update" >
		<input type="hidden" id="client_id" name="client_id" value="<?php echo $row["id"]; ?>" >
		<div class="row">
		    <div class="col-sm">
		      <div class="form-group">
			    <label for="QA">Name</label>
			    <input type="text" class="form-control" name="name" id="name" value="<?php echo $row["name"]; ?>">
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