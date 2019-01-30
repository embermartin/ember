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
  </style>
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
			<a href="index.php">&larr; QA List</a>
	</nav>

<div class="container">

  <h1 class="my-4 text-center">Add a QA</h1>
	<form action="functions.php" method="post">
		<input type="hidden" id="form" name="form" value="qa_add" >
		<div class="row">
		    <div class="col-sm">
		      <div class="form-group">
			    <label for="QA">QA</label>
			    <input type="text" class="form-control" name="qa" id="qa">
			  </div>
		    </div>

		    <div class="col-sm">
		      <div class="form-group">
			    <label for="grade">Grade</label>
			    <input type="text" class="form-control" name="grade" id="grade">
			  </div>
		    </div>
			
		    <div class="col-sm">
		      <div class="form-group">
			    <label for="grower">Grower</label>
			    <select class="form-control" name="grower_id">
					<?php 
						$sql_grower = "SELECT * FROM grower";
						$result = $conn->query($sql_grower);
						while($row = $result->fetch_assoc()) {
								echo "<option value=\"" . $row["id"] . "\">" . $row["name"] . "</option>";
						}
					?>
			    </select>
			  </div>
		    </div>
		</div>
		
		<div class="row">
		    <div class="col-sm">
		      <div class="form-group">
			    <label for="weight">Contracted Weight</label>
			    <input type="number" step="any" step="any" class="form-control" name="contracted_weight" id="contracted_weight">
			  </div>
		    </div>

		    <div class="col-sm">
		      <div class="form-group">
			    <label for="wsc">WSC</label>
			    <input type="number" step="any" class="form-control" name="wsc" id="wsc">
			  </div>
		    </div>

		    <div class="col-sm">
		      <div class="form-group">
			    <label for="ddm">DDM</label>
			    <input type="number" step="any" class="form-control" name="ddm" id="ddm">
			  </div>
		    </div>
		</div>

		<div class="row">
		    <div class="col-sm">
		      <div class="form-group">
			    <label for="ndf">NDF</label>
			    <input type="number" step="any" class="form-control" name="ndf" id="ndf">
			  </div>
		    </div>

		    <div class="col-sm">
		      <div class="form-group">
			    <label for="adf">ADF</label>
			    <input type="number" step="any" class="form-control" name="adf" id="adf">
			  </div>
		    </div>

		    <div class="col-sm">
		      <div class="form-group">
			    <label for="cp">CP</label>
			    <input type="number" step="any" class="form-control" name="cp" id="cp">
			  </div>
		    </div>
	    </div>
		<button class="btn btn-success my-2 float-right" type="submit">Save</button>
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