<?php
session_start();
    if(!empty($_SESSION))
    {
        if(!empty($_SESSION['name']))
        {

require "../DBConnection.php";

if(isset($_GET['id'])){
    $id=$_GET['id'];
    $query="update book_details set is_approved='0' where book_id=$id";
    $get2=$conn->prepare($query);
    $get2->execute();
}
?>

<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="short.css" rel="stylesheet">
</head>
    <body>
        <div class="topnav">
        <a href="books.php">Book Checking</a>
        <a class="active" href="acceptbooks.php">Accepted Books</a>
        <a href="rejectbooks.php">Rejected Books</a>
        <a href="secondpage.php">Home</a>
        <a href="logout.php" style="float:right;">Log Out</a>
        </div><br><br>
        <div style="overflow-x:auto;">
        <table>
         <?php
                        $query2="select * from book_details where is_approved='1' order by added_date DESC";
                        $get2=$conn->prepare($query2);
                        $get2->execute();
                        $count=$get2->rowCount();
                        if($count==0){
                            echo "<script>alert('No books available which are approved...')</script>";
                        }
                        else{
    ?>
    <tr>
            <th>Book-Name</th>
            <th>Description</th>
            <th>Reject</th>
            <!--<th>Reject</th>-->
             </tr>
    <?php 
                        for($i=0; $i<$count; $i++)
                        {
                            $row=$get2->fetch(PDO::FETCH_ASSOC);
                            $name=$row['book_title'];
                            $id=$row['book_id'];
                            $file=$row['book_description'];

        ?>
           
            <tr>
            <td><a href="bookdetail.php?id=<?php echo "$id";?>"><?php echo $name; ?></a></td>
            <td><?php echo $file; ?></td>
            <td><a href="acceptbooks.php?id=<?php echo "$id";?>"><button>Reject</button></a></td>
            
            <!--<td><button type="button">Accept</button></td>-->
            <!--<td><button type="button">Reject</button></td>-->

                        </tr> <?php }} ?>           
        </table>
        
        
        </div>
    </body>

    <table>

</html>
<?php
            
        }
}
else
{?>
    <script>
    alert('Please Login....')
    window.location.href = "index.php";
    </script>
    
<?php
    
}
    ?>
