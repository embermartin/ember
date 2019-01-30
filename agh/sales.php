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
  		margin-right: -1px;
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

  	.even{
  		background-color: #f3f3f3 !important;
  	}
  </style>
</head>
<body>

<?php include('nav.php'); ?>
<div class="container">

  <h1 class="my-4 text-center">Sales</h1>

	<a href="qa_add.php" class="btn btn-success my-2 float-right">Add QA</a>
  	<table class="table mt-4" id="qaList">
	  <thead>
	    <tr>
	      <th scope="col">Grade</th>
	      <th scope="col">Weight</th>
	      <th scope="col">Status</th>
	      <th scope="col">Offered to</th>
	      <th scope="col">Sold to</th>
	    </tr>
	  </thead>
	  <tbody>
	  		<?php 
				$sql = "SELECT lot.status, lot.weight, qa.grade, c1.name AS offered_to, c2.name AS sold_to FROM lot 
				LEFT JOIN qa ON qa.id = lot.parent_qa
				LEFT JOIN client as c1 ON c1.id = lot.offered_to
				LEFT JOIN client as c2 ON c2.id = lot.sold_to
				WHERE status IN ('2','3')";

				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
						echo "<td>" . $row["grade"] . "</td>";
						echo "<td>" . $row["weight"] . "</td>";
						echo "<td>" . printStatus($row["status"]) . "</td>";
						echo "<td>" . $row["offered_to"] . "</td>";
						echo "<td>" . $row["sold_to"] . "</td>";
					echo "</tr>";
				}
			?>
	  </tbody>
	</table>
	<hr class="mt-5" style="width: 50px;"/>
	<h4 class="text-center mt-5">Quick view</h4>

	<table class="table mt-5 mx-auto" style="width: 800px; max-width: 100%">
	  <thead>
	    <tr>
	      <th scope="col">Grade</th>
	      <th scope="col">On site (b)</th>
	      <th scope="col">Location</th>
	      <th scope="col">Status</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php 
	  		$sql = "SELECT SUM(lot.weight) as sum_weight, grade
					FROM qa
					INNER JOIN lot ON lot.parent_qa = qa.id
					GROUP BY grade;";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
						echo "<td>" . $row["grade"] . "</td>";
						echo "<td>" . $row["sum_weight"] . "</td>";
						//location
						echo '<td>';
							$sql2 = "SELECT SUM(lot.weight) as sum_weight, location.name as location_name, location.colour AS location_colour
								FROM qa
								INNER JOIN lot ON lot.parent_qa = qa.id
								INNER JOIN location ON location.id = lot.location
								WHERE qa.grade = \"" . $row["grade"] . "\" GROUP BY location_name";

							$result2 = $conn->query($sql2);
							echo '<div class="chart">';
								while($row2 = $result2->fetch_assoc()) {
							      		echo '<div title="' . $row2["location_name"] . '" data-value="' . $row2["sum_weight"] . '" style="background-color: ' . $row2["location_colour"] . ';">';
							      			echo $row2["location_name"];
							      		echo '</div>';
							    }
						    echo '</div>';
						echo '</td>';
						//status
						echo '<td>';
							$sql2 = "SELECT SUM(lot.weight) as sum_weight, lot.status as lot_status
								FROM qa
								INNER JOIN lot ON lot.parent_qa = qa.id
								WHERE qa.grade = \"" . $row["grade"] . "\" GROUP BY lot_status";

							$result2 = $conn->query($sql2);
							echo '<div class="chart">';
								while($row2 = $result2->fetch_assoc()) {
							      		echo '<div title="' . printStatus($row2["lot_status"]) . '" data-value="' . $row2["sum_weight"] . '" class="status-' . $row2["lot_status"] . '">';
							      			echo printStatus($row2["lot_status"]);
							      		echo '</div>';
							    }
						    echo '</div>';
						echo '</td>';
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
					$(this).css("width",Math.trunc(100/total*value)+"%")
				});
			});

			$('#qaList').DataTable({
				paging: false
			});
		});
	</script>
</html>