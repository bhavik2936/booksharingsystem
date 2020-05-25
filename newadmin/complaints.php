<?php
    //session_start();
    require('header.php');
     require "../DBConnection.php";
    
    if(!isset($_SESSION['name'])){
        echo "<script>window.open('login.php','_self')</script>";
    }
    else{
        extract($_POST);
        if(isset($Complainer))
        {
            
                
                $desc=$_POST['fnum'];
                $id=$_POST['complainer_id'];
                $query1="update user_complaint set is_reviewed='1' where complainer_id=$id";
                $get1=$conn->prepare($query1);
                $get1->execute();
                $query2="update user_details set activated_user='0' where user_id=$id";
                $get2=$conn->prepare($query2);
                $get2->execute();
                $query3="update book_details set is_approved='-1', is_available='0' where owner_id=$id";
                $get3=$conn->prepare($query3);
                $get3->execute();
                
                 $qu="select * from user_complaint where complainer_id=$id";
                $g=$conn->prepare($qu);
                $g->execute();
                $row=$g->fetch(PDO::FETCH_ASSOC);
                $bid=$row['book_id'];
                
                // echo "$bid\n";
                
                $str="complainerblocked";
                $query4="INSERT INTO user_notifications (book_id,user_id,description,notification_type) VALUES ('$bid', '$id', '$desc' ,'$str')";
                // echo $query4;
                $get4=$conn->prepare($query4);
                $get4->execute();
                
                
                echo "<script>alert('Successfully blocked the complainer')</script>";
                echo "<script>window.open('complaints.php','_self')</script>";

            }
         if(isset($Complainee)){
                
                // echo $_POST['fnum'];
                $desc=$_POST['fnum'];
                  $id=$_POST['complainee_id'];
                $query1="update user_complaint set is_reviewed='1' where complainee_id=$id";
                $get1=$conn->prepare($query1);
                $get1->execute();
                $query2="update user_details set activated_user='0' where user_id=$id";
                $get2=$conn->prepare($query2);
                $get2->execute();
                $query3="update book_details set is_approved='-1', is_available='0' where owner_id=$id";
                $get3=$conn->prepare($query3);
                $get3->execute();
                
                 $qu="select * from user_complaint where complainee_id=$id";
                $g=$conn->prepare($qu);
                $g->execute();
                $row=$g->fetch(PDO::FETCH_ASSOC);
                $bid=$row['book_id'];
                
                // echo "$bid\n";
                
                $str="complaineeblocked";
                $query4="INSERT INTO user_notifications (book_id,user_id,description,notification_type) VALUES('$bid', '$id', '$desc' ,'$str')";
                // echo $query4;
                $get4=$conn->prepare($query4);
                $get4->execute();
                
                
                echo "<script>alert('Successfully blocked the complainee')</script>";
                echo "<script>window.open('complaints.php','_self')</script>";


            }
         if(isset($Book)){
                
                // echo $_POST['fnum'];
                $desc=$_POST['fnum'];
                $id=$_POST['book_id'];
                $query1="update user_complaint set is_reviewed='1' where book_id=$id";
                $get1=$conn->prepare($query1);
                $get1->execute();
                $query2="update book_details set is_approved='-1', is_available='0' where book_id=$id";
                $get2=$conn->prepare($query2);
                $get2->execute();
                
                $query3="select * from book_details where book_id=$id";
                $get3=$conn->prepare($query3);
                $get3->execute();
                $row=$get3->fetch(PDO::FETCH_ASSOC);
                $oid=$row['owner_id'];
                $str="Bookblocked";
                
               $query4="INSERT INTO user_notifications (book_id,user_id,description,notification_type) VALUES ('$id', '$oid', '$desc' ,'$str')";
                $get4=$conn->prepare($query4);
                $get4->execute();
            
                echo "<script>alert('Successfully blocked the book')</script>";
                echo "<script>window.open('complaints.php','_self')</script>";
                
            }
        if(isset($No))
            {
                $id=$_POST['book_id'];
                $query1="update user_complaint set is_reviewed='1' where book_id=$id";
                $get1=$conn->prepare($query1);
                $get1->execute();   
            }

       
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
          
              <?php
                        $query2="select * from user_complaint where is_reviewed='0' order by complaint_date ASC";
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
      <th>Complaint Description</th>
      <th>Complaint Date</th>
      <th>Complainer</th>
      <th>Complainee</th>
      <th>Book Complained</th>
      <th>No_Action</th>
      <th>Remarks</th>
    </tr>
  </thead>
  <tbody>
    <?php
       $number=1;
        for($i=0;$i<$count;$i++)
        {
            $row=$get2->fetch(PDO::FETCH_ASSOC);
            $des=$row['complaint_description'];
            $id=$row['book_id'];
            $id1=$row['complainer_id'];
            $id2=$row['complainee_id'];
            $date=$row['complaint_date'];
    ?>
          <form method="post">
          <tr>
                <td><?php echo"$number" ?></td>
                <td><?php echo"$des" ?></td>
                <td><?php echo "$date" ?></td>
                <input type="hidden" name="complainer_id" value="<?php echo $id1?>">
                <input type="hidden" name="complainee_id" value="<?php echo $id2?>">
                 <input type="hidden" name="book_id" value="<?php echo $id?>">
                 
        <td colspan="4" align="center">
                  
        <input style="margin:20px ; " class='btn btn-primary' type="submit" value="Block" name="Complainer"/>
        		    
        <input style=" margin:20px ;" class='btn btn-primary' type="submit" value="Block" name="Complainee"/>
        		   
        <input style=" margin:20px ;" class='btn btn-primary' type="submit" value="Block" name="Book"/>
        <input  class='btn btn-primary' type="submit" value="Ignore" name="No" /></td>
                <td align="center">
                    <input type="text" name="fnum"/></td>
                    
              
             </tr>  
             </form>
     <?php  $number++; }  ?>
     
  </tbody>
</table>
          </div>

<script>
    $(document).ready( function () { $('#myTable').DataTable();} );
</script>
</body>
</html>

<?php

    }
}

?>