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
          <title>Book Sharing System</title>
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
          <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
          
  <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
      </head>
  <body>
          <!--<div class="row"><br><div class="col-md-12 col-sm-12 col-lg-12 "><center><h1>Rajkot Municipal Corporation</h1></center></div><br></div>-->
        
              <?php
                        $query2="select * from book_details where is_approved is null order by added_date ASC";
                        $get2=$conn->prepare($query2);
                        $get2->execute();
                        $count=$get2->rowCount();
                        if($count==0)
                        {
                            echo "<script>alert('No new books added...')</script>";
                        }
                        else
                        { 
              ?>
              <div class="col-md-12 col-sm-12 col-lg-12">
                  <table border="2" id="myTable" class="table table-striped table-bordered" >
  <thead>
    <tr>
        
      <th>Book Name</th>
      <th>Author Name</th>
      
      <th>Date of Upload</th>
      <th>View</th>
      
    </tr>
  </thead>
  <tbody>
    <?php
       
        for($i=0;$i<$count;$i++)
        {
            $row=$get2->fetch(PDO::FETCH_ASSOC);
            $bname=$row['book_title'];
            $aname=$row['author_name'];
            $date=$row['added_date'];
            $id=$row['book_id'];
            
            
          echo "<tr><td>$bname</td>
          <td>$aname</td>
          <td>$date</td>
          <td align='center'><a href='view.php?id=$id'><button class='btn btn-primary'align='center'>View</button></a></td></tr>";
          
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
</body>
</html>

<?php
}
}
?>
