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

	<div class="modal fade" id="moveModal" tabindex="-1" role="dialog" aria-labelledby="moveModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Move stock</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="functions.php" method="post">
		      <div class="modal-body">
					<input type="hidden" id="form" name="form" value="lot_move" >
					<input type="hidden" class="lot_id" id="move_lot_id" name="lot_id" value="" >
					<input type="hidden" class="status_id" id="move_status_id" name="status_id" value="" >
					<input type="hidden" class="total_weight" id="move_total_weight" name="total_weight" value="" >
					<input type="hidden" id="move_parent_qa" name="parent_qa" value="<?php echo $_GET["id"]; ?>" >
		        	<div class="row">
		        		<div class="col-5">
				            <div class="form-group">
					            <label for="move_weight" class="col-form-label">Weight:</label>
					            <input type="text" class="form-control" id="move_weight" name="move_weight">
				            </div>
				        </div>
				        <div class="col-7">
				            <div class="form-group">
					            <label for="move_location" class="col-form-label">Moving to:</label>
					            <select class="form-control" name="move_location" id="move_location">
									<?php 
										$sql_location = "SELECT * FROM location";
										$result = $conn->query($sql_location);
										while($row = $result->fetch_assoc()) {
												echo "<option value=\"" . $row["id"] . "\">" . $row["name"] . "</option>";
										}
									?>
							    </select>
					        </div>
					    </div>
					</div>
		          <div class="form-group">
		            <label for="move_note" class="col-form-label">Note (optional):</label>
		            <textarea class="form-control" id="move_note" name="move_note"></textarea>
		          </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		        <button type="submit" class="btn btn-primary">Confirm</button>
		      </div>
	      </form>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="soldModal" tabindex="-1" role="dialog" aria-labelledby="soldModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Sell to client</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="functions.php" method="post">
		      <div class="modal-body">
					<input type="hidden" id="form" name="form" value="lot_sold" >
					<input type="hidden" class="lot_id" id="sold_lot_id" name="lot_id" value="" >
					<input type="hidden" class="total_weight" id="sold_total_weight" name="total_weight" value="" >
					<input type="hidden" id="sold_parent_qa" name="parent_qa" value="<?php echo $_GET["id"]; ?>" >
		        	<div class="row">
		        		<div class="col-5">
				            <div class="form-group">
					            <label for="sold_weight" class="col-form-label">Weight:</label>
					            <input type="text" class="form-control" id="sold_weight" name="sold_weight">
				            </div>
				        </div>
				        <div class="col-7">
				            <div class="form-group">
					            <label for="sold_client" class="col-form-label">Client:</label>
					            <select class="form-control" name="sold_client" id="sold_client">
									<?php 
										$sql_client = "SELECT * FROM client";
										$result = $conn->query($sql_client);
										while($row = $result->fetch_assoc()) {
												echo "<option value=\"" . $row["id"] . "\">" . $row["name"] . "</option>";
										}
									?>
							    </select>
					        </div>
					    </div>
					</div>
		          <div class="form-group">
		            <label for="sold_note" class="col-form-label">Note (optional):</label>
		            <textarea class="form-control" id="sold_note" name="sold_note"></textarea>
		          </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		        <button type="submit" class="btn btn-primary">Confirm</button>
		      </div>
	      </form>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="offeredModal" tabindex="-1" role="dialog" aria-labelledby="offeredModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Offer to client</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="functions.php" method="post">
		      <div class="modal-body">
					<input type="hidden" id="form" name="form" value="lot_offered" >
					<input type="hidden" class="lot_id" id="offered_lot_id" name="lot_id" value="" >
					<input type="hidden" class="total_weight" id="offered_total_weight" name="total_weight" value="" >
					<input type="hidden" id="offered_parent_qa" name="parent_qa" value="<?php echo $_GET["id"]; ?>" >
		        	<div class="row">
		        		<div class="col-5">
				            <div class="form-group">
					            <label for="offered_weight" class="col-form-label">Weight:</label>
					            <input type="text" class="form-control" id="offered_weight" name="offered_weight">
				            </div>
				        </div>
				        <div class="col-7">
				            <div class="form-group">
					            <label for="offered_client" class="col-form-label">Client:</label>
					            <select class="form-control" name="offered_client" id="offered_client">
									<?php 
										$sql_client = "SELECT * FROM client";
										$result = $conn->query($sql_client);
										while($row = $result->fetch_assoc()) {
												echo "<option value=\"" . $row["id"] . "\">" . $row["name"] . "</option>";
										}
									?>
							    </select>
					        </div>
					    </div>
					</div>
		          <div class="form-group">
		            <label for="offered_note" class="col-form-label">Note (optional):</label>
		            <textarea class="form-control" id="offered_note" name="offered_note"></textarea>
		          </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		        <button type="submit" class="btn btn-primary">Confirm</button>
		      </div>
	      </form>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="pressedModal" tabindex="-1" role="dialog" aria-labelledby="pressedModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Mark as pressed</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="functions.php" method="post">
		      <div class="modal-body">
					<input type="hidden" id="form" name="form" value="lot_pressed" >
					<input type="hidden" class="lot_id" id="pressed_lot_id" name="lot_id" value="" >
					<input type="hidden" class="total_weight" id="pressed_total_weight" name="total_weight" value="" >
					<input type="hidden" id="pressed_parent_qa" name="parent_qa" value="<?php echo $_GET["id"]; ?>" >
		        	<div class="row">
		        		<div class="col-6">
				            <div class="form-group">
					            <label for="pressed_weight" class="col-form-label">Weight pressed:</label>
					            <input type="text" class="form-control" id="pressed_weight" name="pressed_weight">
				            </div>
				        </div>
						<div class="form-group">
				            <label for="pressed_weight_result" class="col-form-label">Resulting weight:</label>
				            <input type="text" class="form-control" id="pressed_weight_result" name="pressed_weight_result">
			            </div>
					</div>
		          <div class="form-group">
		            <label for="pressed_note" class="col-form-label">Note (optional):</label>
		            <textarea class="form-control" id="pressed_note" name="pressed_note"></textarea>
		          </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		        <button type="submit" class="btn btn-primary">Confirm</button>
		      </div>
	      </form>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="shipModal" tabindex="-1" role="dialog" aria-labelledby="shipModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Mark as shipped</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="functions.php" method="post">
		      <div class="modal-body">
					<input type="hidden" id="form" name="form" value="lot_ship" >
					<input type="hidden" class="lot_id" id="ship_lot_id" name="lot_id" value="" >
					<input type="hidden" class="total_weight" id="ship_total_weight" name="ship_total_weight" value="" >
					<input type="hidden" id="ship_parent_qa" name="parent_qa" value="<?php echo $_GET["id"]; ?>" >
		        	<div class="row">
		        		<div class="col-12">
				            <div class="form-group">
					            <label for="ship_weight" class="col-form-label">Weight shipped:</label>
					            <input type="text" class="form-control" id="ship_weight" name="ship_weight">
				            </div>
				        </div>
					</div>
		          <div class="form-group">
		            <label for="ship_note" class="col-form-label">Note (optional):</label>
		            <textarea class="form-control" id="ship_note" name="ship_note"></textarea>
		          </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		        <button type="submit" class="btn btn-primary">Confirm</button>
		      </div>
	      </form>
	    </div>
	  </div>
	</div>

	<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
			<a href="index.php">&larr; QA List</a>
	</nav>

<div class="container">
	
	<?php
		if(isset($_GET["id"])){
			$id = $_GET["id"];
		}
		$sql = "SELECT * FROM qa WHERE id = " . $id;
		$result = $conn->query($sql);
		$row = mysqli_fetch_assoc($result);

		if(isset($_GET["t"])){
			$date = new DateTime();
			$timestamp = $date->getTimestamp();
			$t = intval($_GET["t"]);
			if($timestamp - $t < 30){ //if younger than 30s
				if($_GET["status"] == "new"){
					?>
						<div class="alert alert-success" role="alert">
							<strong><?php echo $row["qa"]; ?></strong> has been added successfully.
						</div>
					<?php
				} else if($_GET["status"] == "updated"){
					?>
						<div class="alert alert-success" role="alert">
							<strong><?php echo $row["qa"]; ?></strong> has been updated successfully.
						</div>
					<?php
				} else if($_GET["status"] == "move"){
					?>
						<div class="alert alert-success" role="alert">
							<strong><?php echo $_GET["weight"]; ?> tons</strong> of QA<?php echo $row["qa"]; ?> has been moved successfully.
						</div>
					<?php
				} else if($_GET["status"] == "sold"){
					?>
						<div class="alert alert-success" role="alert">
							<strong><?php echo $_GET["weight"]; ?> tons</strong> of QA<?php echo $row["qa"]; ?> has been sold successfully.
						</div>
					<?php
				} else if($_GET["status"] == "offered"){
					?>
						<div class="alert alert-success" role="alert">
							<strong><?php echo $_GET["weight"]; ?> tons</strong> of QA<?php echo $row["qa"]; ?> has been offered successfully.
						</div>
					<?php
				} else if($_GET["status"] == "pressed"){
					?>
						<div class="alert alert-success" role="alert">
							<strong><?php echo $_GET["weight"]; ?> tons</strong> of QA<?php echo $row["qa"]; ?> has been pressed successfully.
						</div>
					<?php
				} else if($_GET["status"] == "shipped"){
					?>
						<div class="alert alert-success" role="alert">
							<strong><?php echo $_GET["weight"]; ?> tons</strong> of QA<?php echo $row["qa"]; ?> has been shipped successfully.
						</div>
					<?php
				}
			}
		}
	?>
  <h1 class="my-4 text-center">QA<?php echo $row["qa"]; ?></h1>

	<form action="functions.php" method="post">
		<input type="hidden" id="form" name="form" value="qa_update" >
		<input type="hidden" id="qa_id" name="qa_id" value="<?php echo $row["id"]; ?>" >
		<div class="row">
		    <div class="col-sm">
		      <div class="form-group">
			    <label for="QA">QA</label>
			    <input type="text" class="form-control" name="qa" id="qa" value="<?php echo $row["qa"]; ?>">
			  </div>
		    </div>

		    <div class="col-sm">
		      <div class="form-group">
			    <label for="grade">Grade</label>
			    <input type="text" class="form-control" name="grade" id="grade" value="<?php echo $row["grade"]; ?>">
			  </div>
		    </div>

		    <div class="col-sm">
		      <div class="form-group">
			    <label for="grower">Grower</label>
			    <select class="form-control" name="grower_id">
			      <?php 
						$sql_grower = "SELECT * FROM grower";
						$result = $conn->query($sql_grower);
						while($row_grow = $result->fetch_assoc()) {
							 	if($row_grow["id"] == $row["grower_id"]){
							 		$selected = " selected";
							 	} else {
							 		$selected = "";
							 	}
								echo "<option value=\"" . $row_grow["id"] . "\"" . $selected . ">" . $row_grow["name"] . "</option>";
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
			    <input type="number" step="any" step="any" class="form-control" name="contracted_weight" id="contracted_weight" value="<?php echo $row["contracted_weight"]; ?>">
			  </div>
		    </div>

		    <div class="col-sm">
		      <div class="form-group">
			    <label for="wsc">WSC</label>
			    <input type="number" step="any" class="form-control" name="wsc" id="wsc" value="<?php echo $row["wsc"]; ?>">
			  </div>
		    </div>

		    <div class="col-sm">
		      <div class="form-group">
			    <label for="ddm">DDM</label>
			    <input type="number" step="any" class="form-control" name="ddm" id="ddm" value="<?php echo $row["ddm"]; ?>">
			  </div>
		    </div>
		</div>

		<div class="row">
		    <div class="col-sm">
		      <div class="form-group">
			    <label for="ndf">NDF</label>
			    <input type="number" step="any" class="form-control" name="ndf" id="ndf" value="<?php echo $row["ndf"]; ?>">
			  </div>
		    </div>

		    <div class="col-sm">
		      <div class="form-group">
			    <label for="adf">ADF</label>
			    <input type="number" step="any" class="form-control" name="adf" id="adf" value="<?php echo $row["adf"]; ?>">
			  </div>
		    </div>

		    <div class="col-sm">
		      <div class="form-group">
			    <label for="cp">CP</label>
			    <input type="number" step="any" class="form-control" name="cp" id="cp" value="<?php echo $row["cp"]; ?>">
			  </div>
		    </div>
	    </div>
		<button class="btn btn-success my-2 float-right" type="submit">Update</button><br />
	</form>
	<hr class="mt-5" style="width: 50px;"/>
	<h4 class="text-center mt-5">Inventory</h4>

	<table class="table mt-5 mx-auto">
	  <thead>
	    <tr>
	      <th>Location</th>
	      <th>Weight</th>
	      <th>Pressed weight</th>
	      <th>Notes</th>
	      <th>Status</th>
	      <th>Offered to</th>
	      <th>Sold to</th>
	      <th>Change Location</th>
	      <th>Change Status</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php
	  		$sql2 = "SELECT *, location.id AS location_id, location.name AS location_name, lot.id AS lot_id, c1.name AS sold_client_name, c2.name AS offered_client_name
					FROM lot 
					INNER JOIN location ON location.id = lot.location
					LEFT JOIN client as c1 ON c1.id = lot.sold_to
					LEFT JOIN client as c2 ON c2.id = lot.offered_to
					WHERE parent_qa = $id AND lot.weight > 5
					ORDER BY lot.status";
	  		//echo $sql2;
			$result = $conn->query($sql2);
			$client_name = "";
			while($row = $result->fetch_assoc()) {
				$moveModal = "#moveModal";
				$status_link = "<td><a href=\"\" data-toggle=\"modal\" data-target=\"#offeredModal\" data-lot=\"" . $row["lot_id"] . "\" data-location=\"" . $row["location_id"] . "\" data-weight=\"" . $row["weight"] . "\">Offer</a> / <a href=\"\" data-toggle=\"modal\" data-target=\"#soldModal\" data-lot=\"" . $row["lot_id"] . "\" data-location=\"" . $row["location_id"] . "\" data-weight=\"" . $row["weight"] . "\">Sell to Client</a></td>";

				if($row["status"] == "0"){
					$moveLabel = "Receive on site";
				} else if ($row["status"] == "1") { //In Stock
					$moveLabel = "Move";
				} else if ($row["status"] == "2") { //Offered to Client
					$moveLabel = "Move";
					$status_link = "<td><a href=\"\" data-toggle=\"modal\" data-target=\"#pressedModal\" data-lot=\"" . $row["lot_id"] . "\" data-location=\"" . $row["location_id"] . "\" data-weight=\"" . $row["weight"] . "\">Press</a> / <a href=\"\" data-toggle=\"modal\" data-target=\"#soldModal\" data-lot=\"" . $row["lot_id"] . "\" data-location=\"" . $row["location_id"] . "\" data-weight=\"" . $row["weight"] . "\">Cancel Offer</a></td>";
				} else if ($row["status"] == "3") { //Sold to Client
					$moveLabel = "Move";
					$status_link = "<td><a href=\"\" data-toggle=\"modal\" data-target=\"#pressedModal\" data-lot=\"" . $row["lot_id"] . "\" data-location=\"" . $row["location_id"] . "\" data-weight=\"" . $row["weight"] . "\">Press</a> / <a href=\"\" data-toggle=\"modal\" data-target=\"#soldModal\" data-lot=\"" . $row["lot_id"] . "\" data-location=\"" . $row["location_id"] . "\" data-weight=\"" . $row["weight"] . "\">Cancel Sale</a></td>";
				} else if ($row["status"] == "4") { //Pressed
					$moveLabel = "Move";
					$status_link = "<td><a href=\"\" data-toggle=\"modal\" data-target=\"#shipModal\" data-lot=\"" . $row["lot_id"] . "\" data-location=\"" . $row["location_id"] . "\" data-weight=\"" . $row["pressed_weight"] . "\">Ship</a></td>";
				} else if ($row["status"] == "5") { //Shipped
					$moveLabel = "Move";
					$status_link = "<td></td>";
				} else {
					$moveLabel = "Move";
				}


				echo "<tr>";
					echo "<td>" . $row["location_name"] . "</td>";
					echo "<td>" . $row["weight"] . "</td>";
					echo "<td>" . $row["pressed_weight"] . "</td>";
					echo "<td><a onclick=\"alert('" . htmlspecialchars(addslashes($row["note"])) . "');\" href=\"#\">View notes</a></td>";
					echo "<td>" . printStatus($row["status"]) . "</td>";
					echo "<td>" . $row["offered_client_name"] . "</td>";
					echo "<td>" . $row["sold_client_name"] . "</td>";
					echo "<td><a href=\"\" data-toggle=\"modal\" data-target=\"" . $moveModal . "\" data-lot=\"" . $row["lot_id"] . "\" data-status=\"" . $row["status"] . "\" data-weight=\"" . $row["weight"] . "\">" . $moveLabel . "</a></td>";
					echo $status_link;
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
					$(this).css("width",(100/total*value)+"%")
				});
			});

			$('#moveModal').on('shown.bs.modal', function () {
				$('#move_weight').trigger('focus');
			})

			$('a[data-toggle="modal"]').click(function(){
				$("#move_weight, #sold_weight, #offered_weight, #pressed_weight, #ship_weight").attr("placeholder","Max. " + $(this).data("weight"));
				$(".lot_id").val($(this).data("lot"));
				$(".total_weight").val($(this).data("weight"));
				$(".location_id").val($(this).data("location"));
				$(".status_id").val($(this).data("status"));
			});

		});
	</script>
</html>