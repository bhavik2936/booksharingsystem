<?php
session_start();
    if(!empty($_SESSION))
    {
        if(($_SESSION['name'])=="user")
        {
?>
<html >
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <style>   
        body { margin: 0 } /* Removed the default body margin */

        .main-image{
            position: relative;
            height: 100vh;
            width: 100vw;
            background-image: url('BooksPhoto2.jpg');
            background-size: contain;
        }
        .col-centered {
            float: none;
            margin-top: 15%;
            margin-bottom: auto;
            margin-right: auto;
            margin-left: auto;
        }
    </style> 
    </head>

    <body >
          
    <section class="row main-image">
            <div > <a href="logout.php" style="float:right;padding-left:20px;padding-right:20px;padding-bottom:5px; color:white; background-color:black;"><h3>Log Out</h3></a></div>
                
            <div class="container-fluid ">
            <div >
                <div class="col-sm-6 col-centered" style="background-color:black; text-align:center; "> <a href="books.php" style="color:white"><h1>Books</h1></a></div>
                <div class="col-sm-6 col-centered" style="background-color:black; text-align:center;" ><a href="complaints.php" style="color:white"><h1>Complaints</h1></a></div>
            </div>
            </div>
    
    </section>
    
    </body>
<html>
<?php
}
}
else
{
?>
    <script>
        alert("Please Login...");
        window.location.href = "index.php";
    </script>
<?php
}
?>