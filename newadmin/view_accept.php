<?php
include('header.php');
require "../DBConnection.php"; 
if(!isset($_SESSION['name'])){
        echo "<script>window.open('login.php','_self')</script>";
    }
    else{
             if(isset($_POST['reject'])){
                //$id=$_GET['id1'];
                $id=$_POST['id'];
                $desc=$_POST['demo'];
               // $desc=html_entity_decode($desc1);
                
                
                //echo "$id.$desc";
                $query="select owner_id from book_details where book_id=$id";
                $get2=$conn->prepare($query);
                $get2->execute();
                $row=$get2->fetch(PDO::FETCH_ASSOC);
                $ownerid=$row['owner_id'];
                $str="Book is rejected because ".$desc;
                $query2="insert into user_notifications (`user_id`,`book_id`,`description`,`notification_type`) values ('$ownerid','$id','$str','rejectedbook')";
                //echo $query2;
                $get3=$conn->prepare($query2);
                $get3->execute();
                
                $query3="update book_details set is_approved='0' where book_id=$id";
                $get4=$conn->prepare($query3);
                $get4->execute();
                echo "<script>alert('Successfully Rejected')</script>";
				echo "<script>window.open('books.php','_self')</script>";
            }
    
            
    
            
            ?>



            <div class="row mt-5">
            <div class="col-md-6" style="margin-left:10%;">
                <div class="dept-details-table">
                    <?php
                    if(isset($_GET['id']))
                    {    $id= $_GET['id'];
                    }
                        
                            
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
                            
                            $query2 = "select email_id from user_details where user_id='$owner'";
                            $get3=$conn->prepare($query2);
                            $get3->execute();
                            $row2=$get3->fetch(PDO::FETCH_ASSOC);
                            
                            $email=$row2['email_id'];
                            
                            if($photo1 != null)
                                $file_dir1='../images/'.$email.'/'.$bookid.'/'.$photo1;
                            else
                                $file_dir1=null;
                            
                            if($photo2 != null)
                                $file_dir2='../images/'.$email.'/'.$bookid.'/'.$photo2;
                            else
                                $file_dir2=null;
                            
                            if($photo3 != null)
                                $file_dir3='../images/'.$email.'/'.$bookid.'/'.$photo3;
                            else
                                $file_dir3=null;
                            
                            if($photo4 != null)
                                $file_dir4='../images/'.$email.'/'.$bookid.'/'.$photo4;
                            else
                                $file_dir4=null;
                            
                             
                            if($edition==NULL)
                                $edition="--";
                            if($pub==NULL)
                                $pub="--";
                            if($description==NULL)
                                $description="--";
            

                    ?>

                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>Book Name</th>
                                <td><?php echo"$title";?></td>
                            </tr>
                            <tr>
                                <th>Edition</th>
                                <td><?php echo"$edition";?></td>
                            </tr>
                            <tr>
                                <th>Author Name</th>
                                <td><?php echo" $author";?></td>
                            </tr>
                            <tr>
                                <th>Publication</th>
                                <td><?php echo"$pub";?></td>
                            </tr>
                            <tr>
                                <th>Book id</th>
                                <td><?php echo"$bookid";?></td>
                            </tr>
                            <tr>
                                <th>Book Language</th>
                                <td><?php echo"$lang";?></td>
                            </tr>
                            <tr>
                                <th>Added Date</th>
                                <td><?php echo"$date";?></td>
                            </tr>
                            <tr>
                                <th>Genre</th>
                                <td><?php echo"$genre";?></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td style=" text-align: justify; text-justify: inter-word;"><?php echo " $description"; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-3" style="padding-left:10px;">
                                <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
 <?php
    if($file_dir1!=null && $file_dir2!=null && $file_dir3!=null && $file_dir4!=null){
 ?>
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <img src="<?php echo "$file_dir1";?>" alt="book pic" style="height:60%;">
    </div>

    <div class="item">
      <img src="<?php echo "$file_dir2";?>" alt="book pic" style="height:60%;">
    </div>

    <div class="item">
      <img src="<?php echo "$file_dir3";?>" alt="book pic" style="height:60%;">
    </div>
    <div class="item">
      <img src="<?php echo "$file_dir4";?>" alt="book pic" style="height:60%;">
    </div>
  </div>
<?php } 


   else if($file_dir1!=null && $file_dir2!=null && $file_dir3!=null){
 ?>
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <img src="<?php echo "$file_dir1";?>" alt="book pic" style="height:60%;">
    </div>

    <div class="item">
      <img src="<?php echo "$file_dir2";?>" alt="book pic" style="height:60%;">
    </div>

    <div class="item">
      <img src="<?php echo "$file_dir3";?>" alt="book pic" style="height:60%;">
    </div>
  </div>
<?php }

else if($file_dir1!=null && $file_dir2!=null){
 ?>
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
  </ol>

  <div class="carousel-inner">
    <div class="item active">
      <img src="<?php echo "$file_dir1";?>" alt="book pic" style="height:60%;">
    </div>

    <div class="item">
      <img src="<?php echo "$file_dir2";?>" alt="book pic" style="height:60%;">
    </div>
  </div>
<?php } 

    else if($file_dir1!=null){
 ?>
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
  </ol>

  <div class="carousel-inner">
    <div class="item active">
      <img src="<?php echo "$file_dir1";?>" alt="book pic" style="height:60%;">
    </div>
  </div>
<?php } ?>
 
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
        </div>
        
         <div class="row mt-5">
       <div class="col-md-12" style="margin-left:10%;">
        
        
             <div class="col-sm-4">
        <form action="view_accept.php?id1=<?php echo "$id";?>" method="post"> 
              <div class="form-group"> 
                <label for="comment">Reason:</label> 
                  <textarea class="form-control" rows="6" onkeyup="success()" id="textsend" name="demo"> 
                  </textarea> 
                  <input type="hidden" name="id" value="<?php echo"$id";?>">
              </div> 
              <button class="btn btn-primary" style="margin-bottom:10px;" name="reject" id="button" disabled>Reject</button>
                <script type="text/javascript">
                function success(){
	               if(document.getElementById("textsend").value==="") { 
                        document.getElementById('button').disabled=true; 
                    }
                    else { 
                        document.getElementById('button').disabled=false;
                    }
                }
                </script>
             </form> 
          </div> 
         
          <div class="col-sm-4">
            <form action="books.php" align="center">
                <br><br><br><br><br><br><br><br><br>
                <button class="btn btn-primary" style="margin-bottom:10px;">Back to Page</button>
            </form>
                </div>
         
        <!--    </div>-->
        <!--</div>-->
            
            
            
            
        </div>
    </div>
    <?php 
        
    }
    ?>
    