<?php
session_start();
    if(!empty($_SESSION['name']))
    {
        if($_SESSION['name']=="user")
        {
require "../DBConnection.php";

if(isset($_GET['id']))
{    $id= $_GET['id'];}
                        $query = "select book_id, book_title, author_name, publication_name, edition, book_language, book_description, genre,owner_id, added_date, photo_path1 ,photo_path2,photo_path3,photo_path4 from book_details where book_id='$id'";
                        
                            $get2=$conn->prepare($query);
                            $get2->execute();
                            $row=$get2->fetch(PDO::FETCH_ASSOC);
                            $bookid = $row['book_id'];
                            $title = $row['book_title'];
                            $author = $row['author_name'];
                            $pub = $row['publication_name'];
                            $edition = $row['edition'];
                            $lang=$row['book_language'];
                            $description=$row['book_description'];
                            $genre=$row['genre'];
                            $date=$row['added_date'];
                            $owner = $row['owner_id'];
                            $photo1=$row['photo_path1'];
                            $photo2=$row['photo_path2'];
                            $photo3=$row['photo_path3'];
                            $photo4=$row['photo_path4'];
                            
                             $file_dir1='../images/'.$owner.'/'.$bookid.'/'.$photo1;
                             $file_dir2='../images/'.$owner.'/'.$bookid.'/'.$photo2;
                            $file_dir3='../images/'.$owner.'/'.$bookid.'/'.$photo3;
                             $file_dir4='../images/'.$owner.'/'.$bookid.'/'.$photo4;
                            if($edition==NULL)
                                $edition="--";
                    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
                    <div style="background-color:gray; height=70%; width=100%;border-radius: 5px;text-align:center;
                    text-colour:white;">
                        <h2>Book Details</h2>
                        
                    </div>
                    
                    <table width=80%>
                        <tbody>
                            
                            <tr>
                                <th style="text-style:bold;text-align:left"><h3>Book id : </h3></th>
                                <td><h4><?php echo"$bookid";?></h4></td>
                            </tr>
                            <tr>
                                <th style="text-style:bold;text-align:left"><h3>Title : </h3></th>
                                <td><h4><?php echo"$title";?></h4></td>
                            </tr>
                            <tr>
                                <th style="text-style:bold;text-align:left"><h3>Author : </h3></th>
                                <td><h4><?php echo"$author";?></h4></td>
                            </tr>
                            <tr>
                                <th style="text-style:bold;text-align:left"><h3>Publication : </h3></th>
                                <td><h4><?php echo"$pub";?></h4></td>
                            </tr>
                            <tr>
                                <th style="text-style:bold;text-align:left"><h3>Edition : </h3></th>
                                <td><h4><?php echo"$edition";?></h4></td>
                            </tr>
                            <tr>
                                <th style="text-style:bold;text-align:left"><h3>Language : </h3></th>
                                <td><h4><?php echo"$lang";?> </h4></td>
                            </tr>
                            <tr>
                                <th style="text-style:bold;text-align:left"><h3>Genre : </h3></th>
                                <td><h4><?php echo"$genre";?></h4></td>
                            </tr>
                            <tr>
                                <th style="text-style:bold;text-align:left"><h3>Added Date : </h3></th>
                                <td><h4><?php echo"$date";?></h4></td>
                            </tr>
                            <tr>
                                <th style="text-style:bold;text-align:left"><h3>Description : </h3></th>
                                <td><h4><?php echo "$description"; ?></h4></td>
                            </tr>
                        </tbody>
                    </table>
                    
                
<div class="container">
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <?php if($photo1 !=NULL)
            { ?>
                 <div class="item active">
                <img src="<?php echo $file_dir1?>" alt="Los Angeles" style="width:100%;">
                </div>
     <?php } ?>
        
        <?php if($photo2 !=NULL)
            { ?>
                 <div class="item active">
                <img src="<?php echo $file_dir2?>" alt="Los Angeles" style="width:100%;">
                </div>
     <?php } ?>
        
        <?php if($photo3 !=NULL)
            { ?>
                 <div class="item active">
                <img src="<?php echo $file_dir3?>" alt="Los Angeles" style="width:100%;">
                </div>
     <?php } ?>
        
        <?php if($photo4 !=NULL)
            { ?>
                 <div class="item active">
                <img src="<?php echo $file_dir4?>" alt="Los Angeles" style="width:100%;">
                </div>
     <?php } ?>
    <!--  <div class="item">-->
    <!--    <img src="img.jpg" alt="Chicago" style="width:100%;">-->
    <!--  </div>-->
    
    <!--  <div class="item">-->
    <!--    <img src="img.jpg" alt="New york" style="width:100%;">-->
    <!--  </div>-->
    <!--</div>-->

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

</body>
</html>
<?php
}
}
else
{ ?>
    <script>
        alert('Please Login....')
        window.location.href = "index.php";
    </script>
   <?php 
}
?>



