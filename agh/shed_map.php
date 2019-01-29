<?php include('functions.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>QA Management</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/datatables.min.css"/>
<!--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/chart.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
 
<script type="text/javascript" src="js/datatables.min.js"></script>
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

  	.bar-chart{
  		height: 400px;
  		width: 200px;
  		background-color: #ddd;
  		text-align: center;
  	}

  	.bar-chart>div{
  		height: 1px;
  		width: 200px;
  		float: left;
  		overflow: hidden;
  		color: #333;
  		font-size: 16px;
  		line-height: 100%;
  		padding: 5px 2px;
  		box-sizing: border-box;
  	}

  	.location{
  		width: 25%;
  		display: inline-block;
  		min-width: 200px;
  		padding-bottom: 50px;
  	}

  	.status-0{
  		background-color: #61BB46;
  	}

  	.status-1{
  		background-color: #FDB827;
  	}

  	.status-2{
  		background-color: #F5821F;
  	}

  	.status-3{
  		background-color: #E03A3E;
  	}

  	.status-4{
  		background-color: #963D97;
  	}

  	.status-5{
  		background-color: #009DDC;
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
		<a class="nav-link" href="index.php">QA List</a>
	  </li>
	  <li class="nav-item active">
		<a class="nav-link" href="#">Shed Map <span class="sr-only">(current)</span></a>
	  </li>
	  <li class="nav-item">
		<a class="nav-link" href="#">Sales</a>
	  </li>
	  <li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

  <h1 class="my-4 text-center">Shed Map</h1>
  <br /><br />


  	<?php
  		$grade_colours = array();
  		$base_colours = array("#F9FFBD","#CFBDFF","#BDFEFF","#FF9292", "#FEBDFF", "#DDFFFF");
  		$sql_colours = "SELECT qa.grade, lot.id FROM lot 
						JOIN qa on qa.id = lot.parent_qa GROUP BY grade";
  		$result_colours = $conn->query($sql_colours);

  		$count = 0;
  		while($row_colour = $result_colours->fetch_assoc()) {
  			//var_dump($row_colour);
  			//echo $row_colour["grade"];
  			$grade_colours[$row_colour["grade"]] = $base_colours[$count];
  			$count++;
  		}
  		// echo "<pre>";
  		// var_dump($grade_colours);
  		// echo $grade_colours["GH-1A"];
  		// echo "</pre>";

	  	$sql = "SELECT location.name, location.id, location.max_capacity FROM location";
	  	$result = $conn->query($sql);
		while($row = $result->fetch_assoc()) {
			echo "<div class=\"location\">";
			echo "<h2 class=\"mb-0\">" . $row["name"] . "</h2>";
			if($row["max_capacity"] > 0){
				echo "Max. " .  $row["max_capacity"] . "t";
			} else {
				echo "Unlimited ";
			}

			echo "<br /><br />";

			  	$sql2 = "SELECT SUM(lot.weight) as sum_weight, grade, location.name
				FROM qa
				INNER JOIN lot ON lot.parent_qa = qa.id
				INNER JOIN location ON location.id = lot.location
				WHERE location.id = " . $row["id"] . "
				GROUP BY grade";

				$result2 = $conn->query($sql2);
				echo '<div class="bar-chart" data-capacity="' . $row["max_capacity"] . '">';
				while($row2 = $result2->fetch_assoc()) {
					
		      		echo '<div title="' . $row2["grade"] . '" data-value="' . $row2["sum_weight"] . '" data-grade="' . $row2["grade"] . '" style="background-color: ' . $grade_colours[$row2["grade"]] . '">';
		      			echo $row2["grade"] . " / " . $row2["sum_weight"] . "t";
		      		echo '</div>';

				    
				}
				echo '</div>';
			echo "</div>";
		}
	?>

	<?php
		$sql_location = "SELECT location.name, location.id, location.max_capacity FROM location";
	  	$result_location = $conn->query($sql_location);
		while($row_location = $result_location->fetch_assoc()) {
	?>
	<br /><br /><br />
	<h1 class="my-4 text-center"><?php echo $row_location["name"]; ?></h1>
	<table class="table mt-4">
	  <thead>
	    <tr>
	      <th scope="col">Grade</th>
	      <th scope="col">On site (t)</th>
	      <th scope="col">On farm</th>
	      <th scope="col">Grower</th>
	      <th scope="col">Location</th>
	      <th scope="col">QA</th>
	      <th scope="col">DDM</th>
	      <th scope="col">ADF</th>
	      <th scope="col">NDF</th>
	      <th scope="col">WSC</th>
	      <th scope="col">CP</th>
	      <th scope="col">View</th>
	    </tr>
	  </thead>
	  <tbody>
	  		<?php 
				$sql = "SELECT *, qa.id as qa_id, grower.name as grower_name, location.name as location_name FROM qa 
				INNER JOIN grower ON qa.grower_id = grower.id
				INNER JOIN lot on lot.parent_qa = qa.id
				INNER JOIN location on lot.location = location.id
				WHERE location.name = \"" . $row_location["name"] . "\"
				GROUP BY qa";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
						echo "<td>" . $row["grade"] . "</td>";
						echo "<td>" . "-" . "</td>";
						echo "<td>" . "-" . "</td>";
						echo "<td>" . $row["grower_name"] . "</td>";
						echo "<td>" . $row["location_name"] . "</td>";
						echo "<td>" . $row["qa"] . "</td>";
						echo "<td>" . $row["ddm"] . "</td>";
						echo "<td>" . $row["adf"] . "</td>";
						echo "<td>" . $row["ndf"] . "</td>";
						echo "<td>" . $row["wsc"] . "</td>";
						echo "<td>" . $row["cp"] . "</td>";
						echo "<td><a href=\"qa_view.php?id=" . $row["qa_id"] . "\">View</a></td>";
					echo "</tr>";
				}
			?>
	  </tbody>
	</table>
	<?php
		}
	?>

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
					$(this).css("width",Math.trunc(100/total*value)+"%")
				});
			});

			$(".bar-chart").each(function(){
				var total = $(this).data("capacity");
				if(total == 0){
					$("div", this).each(function(){
						var value = $(this).data("value");
						total += parseInt(value);
					});
				}
				//set widths
				$("div", this).each(function(){
					var value = $(this).data("value");
					$(this).css("height",Math.trunc(100/total*value)+"%")
				});
			});

			$('.table').DataTable({
				paging: false
			});
		});
	</script>
</html>