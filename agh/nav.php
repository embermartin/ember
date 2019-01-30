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
		<a class="nav-link" href="sales.php">Sales</a>
	  </li>
	  <?php
	  	if ($_SESSION["admin"] == "1"){
	  ?>
		  <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  Admin
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
			  <a class="dropdown-item" href="location_list.php">Manage Sheds/Locations</a>
			  <a class="dropdown-item" href="client_list.php">Manage Clients</a>
			  <a class="dropdown-item" href="grower_list.php">Manage Growers</a>
			  <a class="dropdown-item" href="user_list.php">Manage Users</a>
			</div>
		  </li>
	  <?php } ?>
	</ul>

	<ul class="navbar-nav float-right">
		<li class="nav-item">
		<a class="nav-link" href="login.php?logout">Log out</a>
	  </li>
	</ul>
  </div>
</nav>