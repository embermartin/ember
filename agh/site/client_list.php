<?php include('functions.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Manage Clients</title> 
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

<?php include('nav.php'); ?>

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

  <h1 class="my-4 text-center">Manage Clients</h1>

	<a href="client_add.php" class="btn btn-success my-2 float-right">Add Client</a>
  	<table class="table mt-4">
	  <thead>
	    <tr>
	      <th scope="col">Client name</th>
	      <th scope="col">Edit</th>
	  </thead>
	  <tbody>
	  		<?php 
				$sql = "SELECT * FROM client";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
						echo "<td>" . $row["name"] . "</td>";
						echo "<td><a href=\"client_view.php?id=" . $row["id"] . "\">Edit</a></td>";
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