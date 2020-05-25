<?php
//include('header.php');
  @session_start(); 
//   if(isset($_SESSION['name'])){
//     echo $_SESSION['name'];
//   }
?><html lang="en">
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
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
          <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
          
  <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>

</head>
<body>
<div class="container" style="background-color: white">
  <div class="row">
      <div class="col-sm-2"></div>
    <!--<div class="col-sm-2">-->
    <!--  <img src="logo.png" width="150" height="150">-->
    <!--</div>-->
    <!--<div class="col-sm-6">-->
    <div align="center">
      <h1 style="padding-bottom:20px;"><u>Book Sharing System</u></h1>
      <!--<h2>Rajkot Municipal Corporation</h2>-->
    </div>
  </div>
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
<form action="login.php" method="post">
  <h3 class="text-center text-dark">Login</h3>
  <div class="form-group">
    <label for="use">Username:</label>
    <input type="text" class="form-control" placeholder="Enter Username" id="" name="user">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" placeholder="Enter password" id="pwd" name="password">
  </div>
  <div align="center">
  <input type="submit" class="btn btn-primary" name="submit">
  </div>
</form>
</div>
</div>
</html>

<?php 
  if(isset($_POST['submit'])){
    $user=$_POST['user'];
    $pass=$_POST['password'];

    if($user=="user" && $pass == "123"){
      $_SESSION['name']="Admin";
      echo "<script>alert('Successfully Logged-In !')</script>";
      echo "<script>window.open('books.php','_self')</script>";
    }
    else
    {
      echo "<script>alert('Email Or Password Is Not Correct')</script>";
    }
  }
?>