<?php
    //session_start();
    require('header.php');
    if(!isset($_SESSION['name'])){
        echo "<script>window.open('login.php','_self')</script>";
    }
    else{
        require "../DBConnection.php";
    
?>

 <html>
      <head>
          <title>Book Sharing System</title>
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
          <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
    
<!--<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">-->
                
  <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>


      </head>
  <body>
      
      <?php
     /*
     if(isset($_GET['id'])){
         $id1=$_GET['id'];
            $query2="select * from user_area where id=$id1";
            //echo "$query2";
            $get2=$conn->prepare($query2);
            $get2->execute();
            $row=$get2->fetch(PDO::FETCH_ASSOC);
            $area=$row['area_name'];
            $city=$row['city'];
       ?>  
       <div class="row">
           <div class="col-sm-3"></div>
           <div class="col-sm-6">
         <form action="area.php" method="post">
  <h3 class="text-center text-dark">Edit Area</h3>
  <div class="form-group">
    <label for="use">Area:</label>
    <input type="text" class="form-control" placeholder="Enter Username" value="<?php echo "$area"; ?>" name="user">
    </div>
    <div class="form-group">
        <label for="use">City:</label>
    <input type="text" class="form-control" placeholder="Enter Username" value="<?php echo "$city"; ?>" name="city">
    </div>
    <input type="hidden" class="form-control" placeholder="Enter Username" value="<?php echo "$id1"; ?>" name="id">
  
  <div align="center">
  <input type="submit" class="btn btn-primary" name="submit">
  </div>
  
</form>
</div>
</div>
<?php
     }
     
     if(isset($_POST['submit'])){
        $area=$_POST['user'];
        $city=$_POST['city'];
        $id=$_POST['id'];
        $query2="update user_area set area_name='$area',city='$city' where id=$id";
        $get2=$conn->prepare($query2);
        $get2->execute();
         echo "<script>alert('Successfully Updated')</script>";
      echo "<script>window.open('area.php','_self')</script>";
     }
     
     
*/     ?>
          <!--<div class="row"><br><div class="col-md-12 col-sm-12 col-lg-12 "><center><h1>Rajkot Municipal Corporation</h1></center></div><br></div>-->
          
          <?php 
          
          
     if(isset($_POST['add'])){
       ?>  
       <div class="row">
           <div class="col-sm-3"></div>
           <div class="col-sm-6">
         <form action="area.php" method="post">
  <h3 class="text-center text-dark">Add Area</h3>
  <div class="form-group">
    <label for="use">Area:</label>
    <input type="text" class="form-control" placeholder="Enter Area" name="area">
  </div>
  <div class="form-group">
    <label for="use">City:</label>
    <input type="text" class="form-control" placeholder="Enter City" name="city">
  </div>
  <div align="center">
  <input style="margin-right:180; margin-left:5;"type="submit" class="btn btn-primary" name="submit1">
  <input type="button" class="btn btn-primary" name="Cancel" value="cancel" onClick="window.location='area.php';">
  </div>
</form>
</div>
</div>
<?php
     }
     
     if(isset($_POST['submit1'])){
         $area=$_POST['area'];
         $city=$_POST['city'];
         
         $area1=strtolower($area);
         $city1=strtolower($city);
         
         $area2=ucwords($area1);
         $city2=ucwords($city1);
         $query2="select * from user_area where area_name='$area2' and city='$city2'";
        $get2=$conn->prepare($query2);
        $get2->execute();
        $count=$get2->rowCount();
        
        if($count>0){
            echo "<script>alert('Area name and city name existed')</script>";
            echo "<script>window.open('area.php','_self')</script>";   
        }
        else{
   //      echo "$genre";
        $query2="insert into user_area (`area_name`,`city`) values ('".$area2."','".$city2."')";
     //   echo "$query2";
        $get2=$conn->prepare($query2);
        $get2->execute();
         echo "<script>alert('Successfully Inserted')</script>";
      echo "<script>window.open('area.php','_self')</script>";
     }
     
     }
     ?>
      
        
              <?php
                        $query2="select * from user_area";
                        $get2=$conn->prepare($query2);
                        $get2->execute();
                        $count=$get2->rowCount();
                        if($count==0)
                        {
                            echo "<script>alert('No Complaints available...')</script>";
                        }
                        else
                        { 
              ?>
              <div class="col-md-12 col-sm-12 col-lg-12">
                  <table border="2" id="myTable" class="table table-striped table-bordered" >
  <thead>
    <tr>
        <th>Number</th>
      <th>Area</th>
      <th>City</th>
      
      <!--<th>Date of Upload</th>-->
      <!--<th>Edit</th>
      <th>Edit</th>-->
    </tr>
  </thead>
  <tbody>
    <?php
       $number='1';
        for($i=0;$i<$count;$i++)
        {
            $row=$get2->fetch(PDO::FETCH_ASSOC);
            $area=$row['area_name'];
            $city=$row['city'];
            $id=$row['id'];
            // $date=$row['complaint_date'];
    ?>
          <tr>
            <td><?php echo"$number"?></td>
            <td><?php echo"$area" ?></td>
          <td><?php echo "$city" ?></td>
          <!--<td align='center'><a href='area.php?id=<?php echo "$id" ?>' name='edit'><button class='btn btn-primary'><i class='icon-edit'></i></button></a></td>-->
          <!--<td align='center'><a href='area.php?id2=<?php echo "$id" ?>'><button class='btn btn-primary'align='center'><i class='icon-fixed-width icon-trash'></i></button></a></td></tr> -->
         
     <?php   $number++; }  ?>
     
  </tbody>
</table>
          </div>

<script>
    $(document).ready( function () { $('#myTable').DataTable();} );
</script>
</body>
         <div class="row" style="margin-top:10px">
        <div align="center">
        <form action="area.php" method="post">
            <button class="btn btn-primary" style="margin-bottom:10px;" name="add">Add Area</button>
        </form>
        </div>
    
</html>

<?php

    }
}

?>