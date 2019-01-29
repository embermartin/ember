<?php include('functions.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Manage Locations</title> 
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
<!--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/chart.min.js"></script>
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

  	.colour{
		color: white;
  	}
  </style>
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	<ul class="navbar-nav mr-auto">
	  <li class="nav-item">
		<a class="nav-link" href="index.php">QA List <span class="sr-only">(current)</span></a>
	  </li>
	  <li class="nav-item">
		<a class="nav-link" href="shed_map.php">Shed Map</a>
	  </li>
	  <li class="nav-item">
		<a class="nav-link" href="#">Sales</a>
	  </li>
	  <li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  Admin
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
		  <a class="dropdown-item" href="location_list.php">Manage Sheds/Locations</a>
		  <a class="dropdown-item" href="client_list.php">Manage Clients</a>
		  <a class="dropdown-item" href="grower_list.php">Manage Growers</a>
		</div>
	  </li>
	</ul>
	<form class="form-inline my-2 my-lg-0">
	  <input class="form-control mr-sm-2" type="search" placeholder="Start typing..." aria-label="Search">
	  <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
	</form>
  </div>
</nav>

<div class="container">
  <?php
  	if(isset($_GET["status"])){
			if($_GET["status"] == "new"){
				?>
					<div class="alert alert-success" role="alert">
						<strong><?php echo $_GET["name"]; ?></strong> has been added successfully.
					</div>
				<?php
			} else if($_GET["status"] == "updated"){
				?>
					<div class="alert alert-success" role="alert">
						<strong><?php echo $_GET["name"]; ?></strong> has been updated successfully.
					</div>
				<?php
			}
		}
	?>

  <h1 class="my-4 text-center">Manage Locations</h1>

	<a href="location_add.php" class="btn btn-success my-2 float-right">Add Location</a>
  	<table class="table mt-4">
	  <thead>
	    <tr>
	      <th scope="col">Location name</th>
	      <th scope="col">Max capacity</th>
	      <th scope="col">On site</th>
	      <th scope="col">Off site</th>
	      <th scope="col">Colour Indicator</th>
	      <th scope="col">Edit</th>
	  </thead>
	  <tbody>
	  		<?php 
				$sql = "SELECT * FROM location";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
						echo "<td>" . $row["name"] . "</td>";
						echo "<td>" . $row["max_capacity"] . "</td>";
						echo "<td>" . $row["on_site"] . "</td>";
						echo "<td>" . $row["off_site"] . "</td>";
						echo "<td class=\"colour\" style=\"background-color: " .  $row["colour"] . ";\">" . $row["colour"] . "</td>";
						echo "<td><a href=\"location_view.php?id=" . $row["id"] . "\">Edit</a></td>";
					echo "</tr>";
				}
			?>
	  </tbody>
	</table>
	

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
					$(this).css("width",(100/total*value) + "%")
				});
			});
		});
	</script>
</html>