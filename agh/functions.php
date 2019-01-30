<?php

	ob_start();
    session_start();

    if($_SESSION['valid'] != true){
    	header('Location: login.php');
    }

	$servername = "ls-f7b18ae7f72c01fe4dd8b8ba4ca3e40b30901535.cmnbttmu6wjr.ap-southeast-2.rds.amazonaws.com";
	$username = "dbmasteruser";
	$password = "jackmein";
	$dbname = "agh";

	// $servername = "localhost";
	// $username = "root";
	// $password = "";
	// $dbname = "agh";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	if(isset($_GET["action"])){
		$action = $_GET["action"];
		if($action == "remove_user"){
			$user = $_GET["id"];
			// sql to delete user
			$sql = "DELETE FROM users WHERE id=" . $user;

			if ($conn->query($sql) === TRUE) {
			    echo "User deleted successfully";
			    $date = new DateTime();
				$timestamp = $date->getTimestamp();
				header('Location: user_list.php?status=deleted&t=' . $timestamp);
			} else {
			    echo "Error deleting record: " . $conn->error;
			}
		}
	}

	if(isset($_POST["form"])){
		$form = $_POST["form"];

		if ($form == "login"){
			//echo "attempting to login";
			
			// echo "<pre>";
			// var_dump($_POST);
			// echo "</pre>";

			$email = $_POST["email"];
			$pass = $_POST["password"];

			$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$pass'";

			
			if($result = $conn->query($sql)){
				$row = mysqli_fetch_assoc($result);
				
				if(isset($row["id"])){
					$admin = $row["admin"];
					$_SESSION['admin'] = $admin;
					$_SESSION['valid'] = true;
					header('Location: index.php');
					echo $user;
				} else {
					echo "user not found";
					header('Location: login.php?wrong');
				}
				
			} else {
				echo "error logging in";
			}
			

			

		} else if($form == "qa_add") {
		    echo "adding a qa!";

		    $qa = $_POST["qa"];
		    $contracted_weight = $_POST["contracted_weight"];
		    $grade = $_POST["grade"];
		    $grower_id = $_POST["grower_id"];
		    $ddm = $_POST["ddm"];
		    $adf = $_POST["adf"];
		    $wsc = $_POST["wsc"];
		    $ndf = $_POST["ndf"];
		    $cp = $_POST["cp"];

	    	$sql = "INSERT INTO qa (qa, contracted_weight, grade, grower_id, ddm, adf, wsc, ndf, cp)
			VALUES ('$qa', $contracted_weight, '$grade', $grower_id, $ddm, $adf, $wsc, $ndf, $cp);";

			if ($conn->query($sql) === TRUE) {
			    echo "QA successfully added";
			    //Get id
		        $sql2 = "SELECT id FROM qa ORDER BY id DESC LIMIT 1";
				$result = $conn->query($sql2);
				$row = mysqli_fetch_assoc($result);
				$qa_id = $row["id"];
				//Create lot
				$sql3 = "INSERT INTO lot (parent_qa, weight, pressed_weight, location, status, offered_to, note)
						 VALUES ('$qa_id', $contracted_weight, 0, 0, 0, 0, 'Empty');";
				if ($conn->query($sql3) === TRUE) {
					//Lot added successfully
					$date = new DateTime();
					$timestamp = $date->getTimestamp();
					header('Location: qa_view.php?id=' . $qa_id. "&status=new&t=" . $timestamp);
				}
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}

		} elseif ($form == "qa_update") {
		    echo "updating a qa!";

		    $qa_id = $_POST["qa_id"];
		    $qa = $_POST["qa"];
		    $contracted_weight = $_POST["contracted_weight"];
		    $grade = $_POST["grade"];
		    $grower_id = $_POST["grower_id"];
		    $ddm = $_POST["ddm"];
		    $adf = $_POST["adf"];
		    $wsc = $_POST["wsc"];
		    $ndf = $_POST["ndf"];
		    $cp = $_POST["cp"];

	    	$sql = "UPDATE qa 
	    			SET qa = '$qa', 
    				    contracted_weight = $contracted_weight, 
    				    grade = '$grade', 
    				    grower_id = $grower_id, 
    				    ddm = $ddm, 
    				    adf = $adf, 
    				    wsc = $wsc, 
    				    ndf = $ndf, 
    				    cp = $cp
					WHERE id = " . $qa_id;

			if ($conn->query($sql) === TRUE) {
			    echo "QA successfully updated";
				header('Location: qa_view.php?id=' . $qa_id . "&status=updated");
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}

		} elseif ($form == "location_add") {
		    echo "adding a location!";

		    $name = $_POST["name"];
		    $max_capacity = $_POST["max_capacity"];

		    if($_POST["on_site"] == "1"){
		    	$on_site = 1;
		    	$off_site = 0;
		    } else {
		    	$on_site = 0;
		    	$off_site = 1;
		    }
		    $colour = $_POST["colour"];


	    	$sql = "INSERT INTO location (name, on_site, off_site, colour, max_capacity)
			VALUES ('$name', $on_site, $off_site, '$colour', $max_capacity);";

			if ($conn->query($sql) === TRUE) {
			    echo "Location successfully added";
				header('Location: location_list.php?name=' . urlencode($name) . "&status=new");
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else if ($form == "location_update"){
			echo "updating a location!";

			$location_id = $_POST["location_id"];
		    $name = $_POST["name"];
		    $max_capacity = $_POST["max_capacity"];

		    if($_POST["on_site"] == "1"){
		    	$on_site = 1;
		    	$off_site = 0;
		    } else {
		    	$on_site = 0;
		    	$off_site = 1;
		    }
		    $colour = $_POST["colour"];

	    	$sql = "UPDATE location 
	    			SET name = '$name', 
    				    on_site = $on_site, 
    				    off_site = $off_site, 
    				    colour = '$colour', 
    				    max_capacity = $max_capacity
					WHERE id = " . $location_id;

			if ($conn->query($sql) === TRUE) {
			    echo "Location successfully updated";
				header('Location: location_list.php?name=' . urlencode($name) . "&status=updated");
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}

		} elseif ($form == "grower_add") {
		    echo "adding a grower!";

		    $name = $_POST["name"];



	    	$sql = "INSERT INTO grower (name) VALUES ('$name');";

			if ($conn->query($sql) === TRUE) {
			    echo "Grower successfully added";
			    //Get id
				header('Location: grower_list.php?name=' . urlencode($name) . "&status=new");
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else if ($form == "grower_update"){
			echo "updating a grower!";

			$grower_id = $_POST["grower_id"];
		    $name = $_POST["name"];

	    	$sql = "UPDATE grower 
	    			SET name = '$name'
					WHERE id = " . $grower_id;

			if ($conn->query($sql) === TRUE) {
			    echo "Grower successfully updated";
				header('Location: grower_list.php?name=' . urlencode($name) . "&status=updated");
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}

		} elseif ($form == "client_add") {
		    echo "adding a client!";

		    $name = $_POST["name"];



	    	$sql = "INSERT INTO client (name) VALUES ('$name');";

			if ($conn->query($sql) === TRUE) {
			    echo "Client successfully added";
			    //Get id
				header('Location: client_list.php?name=' . urlencode($name) . "&status=new");
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else if ($form == "client_update"){
			echo "updating a client!";

			$client_id = $_POST["client_id"];
		    $name = $_POST["name"];

	    	$sql = "UPDATE client 
	    			SET name = '$name'
					WHERE id = " . $client_id;

			if ($conn->query($sql) === TRUE) {
			    echo "Client successfully updated";
				header('Location: client_list.php?name=' . urlencode($name) . "&status=updated");
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}

		} else if ($form == "lot_move"){
			echo "moving a lot!";

			//var_dump($_POST);

			$lot_id = $_POST["lot_id"];
			$total_weight = intval($_POST["total_weight"]);
			$move_weight = intval($_POST["move_weight"]);
			$move_location = $_POST["move_location"];
			$parent_qa = $_POST["parent_qa"];
			$status = $_POST["status_id"];
			$note = mysql_real_escape_string($_POST["move_note"]);

			$new_weight = $total_weight - $move_weight;

			$sql = "UPDATE lot 
	    			SET weight = '$new_weight'
					WHERE id = " . $lot_id;

			if ($conn->query($sql) === TRUE) {
			    echo "original lot weight successfully reduced";


			    if($status == "0"){
			    	$sql2 = "INSERT INTO lot (parent_qa, weight, pressed_weight, location, status, offered_to, sold_to, note)
				    		 SELECT  lot.parent_qa, $move_weight, lot.pressed_weight, $move_location, 1, lot.offered_to, lot.sold_to, \"$note\"
							 FROM    lot
							 WHERE   lot.id = " . $lot_id;
				} else {
					$sql2 = "INSERT INTO lot (parent_qa, weight, pressed_weight, location, status, offered_to, sold_to, note)
		    		 SELECT  lot.parent_qa, $move_weight, lot.pressed_weight, $move_location, lot.status, lot.offered_to, lot.sold_to, \"$note\"
					 FROM    lot
					 WHERE   lot.id = " . $lot_id;
				}
			    

				if ($conn->query($sql2) === TRUE) {
				    echo "new lot successfully added";
				    $date = new DateTime();
					$timestamp = $date->getTimestamp();
				    header('Location: qa_view.php?id=' . $parent_qa. "&status=move&weight=" . $move_weight . "&t=" . $timestamp);
				}

			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else if ($form == "lot_sold"){
			echo "selling a lot!";

			$lot_id = $_POST["lot_id"];
			$total_weight = intval($_POST["total_weight"]);
			$sold_weight = intval($_POST["sold_weight"]);
			$sold_client = $_POST["sold_client"];
			$parent_qa = $_POST["parent_qa"];
			$note = mysql_real_escape_string($_POST["sold_note"]);
			$status = 3; //sold

			$new_weight = $total_weight - $sold_weight;

			$sql = "UPDATE lot 
	    			SET weight = '$new_weight'
					WHERE id = " . $lot_id;

			if ($conn->query($sql) === TRUE) {
			    echo "original lot weight successfully reduced";


			    //$sql2 = "INSERT INTO lot (parent_qa, weight, pressed_weight, location, status, sold_to, note)
						 //VALUES ($parent_qa, $sold_weight, 0, $location_id, $status, $sold_client, '$note');";

			    $sql2 = "INSERT INTO lot (parent_qa, weight, pressed_weight, location, status, offered_to, sold_to, note)
			    		 SELECT  lot.parent_qa, $sold_weight, lot.pressed_weight, lot.location, $status, lot.offered_to, \"$sold_client\", \"$note\"
						 FROM    lot
						 WHERE   lot.id = " . $lot_id;

				if ($conn->query($sql2) === TRUE) {
				    echo "new lot successfully added";
				    $date = new DateTime();
					$timestamp = $date->getTimestamp();
				    header('Location: qa_view.php?id=' . $parent_qa. "&status=sold&weight=" . $sold_weight . "&t=" . $timestamp);
				}

			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else if ($form == "lot_offered"){
			echo "offering a lot!";

			$lot_id = $_POST["lot_id"];
			$total_weight = intval($_POST["total_weight"]);
			$offered_weight = intval($_POST["offered_weight"]);
			$offered_client = $_POST["offered_client"];
			$parent_qa = $_POST["parent_qa"];
			$note = mysql_real_escape_string($_POST["offered_note"]);
			$status = 2; //offered

			$new_weight = $total_weight - $offered_weight;

			$sql = "UPDATE lot 
	    			SET weight = '$new_weight'
					WHERE id = " . $lot_id;

			if ($conn->query($sql) === TRUE) {
			    echo "original lot weight successfully reduced";


			    //$sql2 = "INSERT INTO lot (parent_qa, weight, pressed_weight, location, status, sold_to, note)
						 //VALUES ($parent_qa, $sold_weight, 0, $location_id, $status, $sold_client, '$note');";

			    $sql2 = "INSERT INTO lot (parent_qa, weight, pressed_weight, location, status, offered_to, sold_to, note)
			    		 SELECT  lot.parent_qa, $offered_weight, lot.pressed_weight, lot.location, $status, \"$offered_client\", lot.sold_to, \"$note\"
						 FROM    lot
						 WHERE   lot.id = " . $lot_id;

				if ($conn->query($sql2) === TRUE) {
				    echo "new lot successfully added";
				    $date = new DateTime();
					$timestamp = $date->getTimestamp();
				    header('Location: qa_view.php?id=' . $parent_qa. "&status=offered&weight=" . $sold_weight . "&t=" . $timestamp);
				}

			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else if ($form == "lot_pressed"){
			echo "pressing a lot!";

			$lot_id = $_POST["lot_id"];
			$total_weight = intval($_POST["total_weight"]);
			$pressed_weight = intval($_POST["pressed_weight"]);
			$pressed_weight_result = $_POST["pressed_weight_result"];
			$parent_qa = $_POST["parent_qa"];
			$note = mysql_real_escape_string($_POST["pressed_note"]);
			$status = 4; //pressed

			$new_weight = $total_weight - $pressed_weight;

			$sql = "UPDATE lot 
	    			SET weight = '$new_weight'
					WHERE id = " . $lot_id;

			if ($conn->query($sql) === TRUE) {
			    echo "original lot weight successfully reduced";


			    //$sql2 = "INSERT INTO lot (parent_qa, weight, pressed_weight, location, status, sold_to, note)
						 //VALUES ($parent_qa, $sold_weight, 0, $location_id, $status, $sold_client, '$note');";

			    $sql2 = "INSERT INTO lot (parent_qa, weight, pressed_weight, location, status, offered_to, sold_to, note)
			    		 SELECT  lot.parent_qa, 0, $pressed_weight_result, lot.location, $status, lot.offered_to, lot.sold_to, \"$note\"
						 FROM    lot
						 WHERE   lot.id = " . $lot_id;

				if ($conn->query($sql2) === TRUE) {
				    echo "new lot successfully added";
				    $date = new DateTime();
					$timestamp = $date->getTimestamp();
				    header('Location: qa_view.php?id=' . $parent_qa. "&status=pressed&weight=" . $pressed_weight . "&t=" . $timestamp);
				}

			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else if ($form == "lot_ship"){
			echo "shipping a lot!";

			$lot_id = $_POST["lot_id"];
			$total_weight = intval($_POST["ship_total_weight"]);
			$ship_weight = intval($_POST["ship_weight"]);
			$parent_qa = $_POST["parent_qa"];
			$note = mysql_real_escape_string($_POST["ship_note"]);
			$status = 5; //shipped

			$new_weight = $total_weight - $ship_weight;

			$sql = "UPDATE lot 
	    			SET pressed_weight = '$new_weight'
					WHERE id = " . $lot_id;

			if ($conn->query($sql) === TRUE) {
			    echo "original lot weight successfully reduced";


			    $sql2 = "INSERT INTO lot (parent_qa, weight, pressed_weight, location, status, offered_to, sold_to, note)
			    		 SELECT  lot.parent_qa, lot.weight, $ship_weight, lot.location, $status, lot.offered_to, lot.sold_to, \"$note\"
						 FROM    lot
						 WHERE   lot.id = " . $lot_id;

				if ($conn->query($sql2) === TRUE) {
				    echo "new lot successfully added";
				    $date = new DateTime();
					$timestamp = $date->getTimestamp();
				    header('Location: qa_view.php?id=' . $parent_qa. "&status=shipped&weight=" . $pressed_weight . "&t=" . $timestamp);
				}

			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else if ($form == "user_add") {
		    echo "adding a user!";

		    $email = $_POST["email"];
		    $admin = $_POST["admin"];

		    $passwords = randomPassword(10,1,"lower_case,numbers");
		    $password = $passwords[0];

	    	$sql = "INSERT INTO users (email, password, admin) VALUES ('$email','$password', $admin);";

			if ($conn->query($sql) === TRUE) {
			    echo "User successfully added";
			    //email user
			    // the message
				$msg = "Your AGH password is:\n" . $password;

				// use wordwrap() if lines are longer than 70 characters
				$msg = wordwrap($msg,70);

				// send email
				mail($email,"Log in to AGH",$msg);

				header('Location: user_list.php?email=' . urlencode($email) . "&status=new");
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}

	}

	function printStatus($status_id){
		if ($status_id == "0"){
			return "Off site";
		} else if ($status_id == "1"){
			return "In stock";
		} else if ($status_id == "2"){
			return "Offered";
		} else if ($status_id == "3"){
			return "Sold";
		} else if ($status_id == "4"){
			return "Pressed";
		} else if ($status_id == "5"){
			return "Shipped";
		}
	}

	function randomPassword($length,$count, $characters) {
 
	// $length - the length of the generated password
	// $count - number of passwords to be generated
	// $characters - types of characters to be used in the password
	 
	// define variables used within the function    
	    $symbols = array();
	    $passwords = array();
	    $used_symbols = '';
	    $pass = '';
	 
	// an array of different character types    
	    $symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
	    $symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $symbols["numbers"] = '1234567890';
	    $symbols["special_symbols"] = '!?~@#-_+<>[]{}';
	 
	    $characters = split(",",$characters); // get characters types to be used for the passsword
	    foreach ($characters as $key=>$value) {
	        $used_symbols .= $symbols[$value]; // build a string with all characters
	    }
	    $symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1
	     
	    for ($p = 0; $p < $count; $p++) {
	        $pass = '';
	        for ($i = 0; $i < $length; $i++) {
	            $n = rand(0, $symbols_length); // get a random character from the string with all characters
	            $pass .= $used_symbols[$n]; // add the character to the password string
	        }
	        $passwords[] = $pass;
	    }
	     
	    return $passwords; // return the generated password
	}
	 
	//$my_passwords = randomPassword(10,1,"lower_case,upper_case,numbers,special_symbols");
	 
	//print_r($my_passwords);


	//$conn->close();

?>