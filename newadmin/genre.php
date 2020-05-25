<?php
    include('header.php');
    if(!isset($_SESSION['name'])){
        echo "<script>window.open('login.php','_self')</script>";
    }
    else{
        require "../DBConnection.php";
?>

 <html>
      <head>
          <!--<title>Book Sharing System</title>-->
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
          <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
          
  <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>

<!--<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">-->
      </head>
  <body>
      <?php
     /*if(isset($_GET['id2'])){
         $id1=$_GET['id2'];
            $query2="update book_genre set is_approved='0' where id='$id1'";
            $get2=$conn->prepare($query2);
            $get2->execute();
            echo "<script>alert('Successfully Updated')</script>";
            echo "<script>window.open('genre.php','_self')</script>";    
     }*/
     
     if(isset($_POST['add'])){
       ?>  
       <div class="row">
           <div class="col-sm-3"></div>
           <div class="col-sm-6">
         <form action="genre.php" method="post">
  <h3 class="text-center text-dark">Add Genre</h3>
  <div class="form-group">
    <label for="use">Genre:</label>
    <input type="text" class="form-control" placeholder="Enter Genre" name="user">
  </div>
  <div>
  <input style='margin-right:200px; margin-left:100px' type="submit" class="btn btn-primary" name="submit1">
  <input type="button" class="btn btn-primary" name="Cancel" value="cancel" onClick="window.location='genre.php';">
  
  </div>
</form>
</div>
</div>
<?php
     }
     
     if(isset($_POST['submit1'])){
         $genre=$_POST['user'];
   //      echo "$genre";
        $query2="insert into book_genre (`genre_name`) values ('".$genre."')";
     //   echo "$query2";
        $get2=$conn->prepare($query2);
        $get2->execute();
         echo "<script>alert('Successfully Inserted')</script>";
      echo "<script>window.open('genre.php','_self')</script>";
     }
     
     
     ?>
      
      
      
     <?php
     
   /*  if(isset($_GET['id'])){
         $id1=$_GET['id'];
            $query2="select * from book_genre where id=$id1";
                        $get2=$conn->prepare($query2);
                        $get2->execute();
            $row=$get2->fetch(PDO::FETCH_ASSOC);
            $gen=$row['genre_name']; 
       ?>  
       <div class="row">
           <div class="col-sm-3"></div>
           <div class="col-sm-6">
         <form action="genre.php" method="post">
  <h3 class="text-center text-dark">Edit Genre</h3>
  <div class="form-group">
    <label for="use">Genre:</label>
    <input type="text" class="form-control" placeholder="Enter Username" value="<?php echo "$gen"; ?>" name="user">
    <input type="hidden" class="form-control" placeholder="Enter Username" value="<?php echo "$id1"; ?>" name="id">
  </div>
  <div align="center">
  <input type="submit" class="btn btn-primary" name="submit">
  </div>
</form>
</div>
</div>
<?php
     }
     
     if(isset($_POST['submit'])){
         $genre=$_POST['user'];
         $id=$_POST['id'];
        $query2="update book_genre set genre_name='$genre' where id=$id";
        $get2=$conn->prepare($query2);
        $get2->execute();
         echo "<script>alert('Successfully Updated')</script>";
      echo "<script>window.open('genre.php','_self')</script>";
     }
     
     */
     ?>
      
              <?php
                        $query2="select * from book_genre where is_approved='1'";
                        $get2=$conn->prepare($query2);
                        $get2->execute();
                        $count=$get2->rowCount();
                        if($count==0)
                        {
                            echo "<script>alert('No Book Genre available...')</script>";
                        }
                        else
                        { 
              ?>
              <div>
                  
              </div>
              <div class="col-md-12 col-sm-12 col-lg-12">
                  <table border="2" id="myTable" class="table table-striped table-bordered" >
  <thead>
    <tr>
        
      <th>Number</th>
      <th>Book Genre</th>
      
      <!--<th>Date of Upload</th>-->
    <!--  <th>Edit</th>
      <th>Delete</th>
-->      
    </tr>
  </thead>
  <tbody>
    <?php
       $number=1;
        for($i=0;$i<$count;$i++)
        {
            $row=$get2->fetch(PDO::FETCH_ASSOC);
            $gen=$row['genre_name'];
            $id=$row['id'];
            
            
          echo "<tr><td>$number</td>
          <td>$gen</td>";
      /*<td align='center'><a href='genre.php?id=$id' name='edit'><button class='btn btn-primary'><i class='icon-edit'></i></button></a></td>
          <td align='center'><a href='genre.php?id2=$id'><button class='btn btn-primary'align='center'><i class='icon-fixed-width icon-trash'></i></button></a></td></tr>";*/
          $number++;
        }
      
    ?>
  </tbody>
</table>
          </div>

<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>

        <div class="row" style="margin-top:10px">
                <div align="center">
                <form action="genre.php" method="post">
                    <button class="btn btn-primary" style="margin-bottom:10px;" name="add">Add Genre</button>
                </form>
                </div>

</body>
</html>

<?php
}
        
    }
?>  