<?php
    session_start();
?>
<html lang="en">
<head>
  <title>Admin Panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
	<link rel="stylesheet" href="style.css">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
          <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
          
  <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>
</head>
<body>
<div class="container" style="background-color: white">
  <div class="row">
    <!--<div class="col-sm-2">-->
    <!--  <img src="logo.png" width="150" height="150">-->
    <!--</div>-->
    <!--<div class="col-sm-10" align="center">-->
    <div align="center">
      <h1 style="padding-bottom:20px;"><u>Book Sharing System</u></h1>
      <!--<h2>Rajkot Municipal Corporation</h2>-->
    </div>
  </div>

  <nav class="navbar navbar-inverse">
  <!--<nav class="navbar navbar-dark">-->
  <div class="">
    <ul class="nav navbar-nav">
      <li><a href="books.php" id="bookcheck"style="color:white;">Verify Books</a></li>
      <li><a href="acceptedbooks.php" id="accbook"style="color:white;">Accepted Books</a></li>
      <li><a href="rejectedbooks.php" id="rejbook"style="color:white;">Rejected Book</a></li>
      <li><a href="complaints.php" id="complaints"style="color:white;">Complaints</a></li>
       <li><a href="genre.php" id="genre"style="color:white;">Edit Genre</a></li>
      <li><a href="area.php" id="area"style="color:white;">Edit Area</a></li>
      <li><a href="logout.php" id="logout"style="color:white;">Logout</a></li>
    </ul>
  </div>
</nav>

<script>
				var pathname = window.location.pathname;
				var path_arr = pathname.split("/");
				var rev_arr = path_arr.reverse()
				var dot_explode = rev_arr[0].split(".");
				var file = dot_explode[0];
				var current_file = '';
				
				if (file === "books" || file === "view") {
					file = 'bookcheck';
				} 
				if (file === "acceptedbooks" || file === "view_accept" ) {
					file = 'accbook';
				}
				if (file === "rejectedbooks" || file === "view_reject") {
					file = 'rejbook';
				}
				if (file === "complaints")
				{
					file = 'complaints';
				}
				if (file === "genre" ) {
					file = 'genre';
				} 
				if (file === "area") {
					file = "area";
				}
				if (file === "logout") {
					file = "logout";
				}
				$('#'+file).addClass('nav-link-active');
				// var array=pathname.split("/");
			</script>

