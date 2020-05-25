<?php
session_start();
    if(isset($_SESSION['name']))
    {
        if($_SESSION['name']=="user")
        {
            require "../DBConnection.php";
            
            if(isset($_GET['id1'])){
                $id=$_GET['id1'];
                $query="update book_details set is_approved='1' where book_id=$id";
                $get2=$conn->prepare($query);
                $get2->execute();
            }
            
            if(isset($_GET['id2'])){
                $id=$_GET['id2'];
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
                    <a class="active" href="books.php" >Book Checking</a>
                    <a href="acceptbooks.php">Accepted Books</a>
                    <a href="rejectbooks.php">Rejected Books</a>
                    <a href="secondpage.php">Home</a>
                    <a href="logout.php" style="float:right;">Log Out</a>
                    </div><br><br>
                    <div style="overflow-x:auto;">
                    <table>
                     
                    <?php
                        $query2="select * from book_details where is_approved is null order by added_date ASC";
                        $get2=$conn->prepare($query2);
                        $get2->execute();
                        $count=$get2->rowCount();
                        if($count==0){
                            echo "<script>alert('No new books added...')</script>";
                        }
                        else
                        {  ?>
                            <tr>
                                    <th>Book-Name</th>
                                    <th>Description</th>
                                    <th>Accept</th>
                                    <th>Reject</th>
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
                                <td><a href="bookdetail.php?id=<?php echo "$id";?>" style="text-color:black;"><?php echo $name; ?></a></td>
                                <td><?php echo $file; ?></td>
                                <td><a href="books.php?id1=<?php echo "$id";?>"><button>Accept</button></a></td>
                                <td><a href="books.php?id2=<?php echo "$id";?>"><button>Reject</button></a></td>
                                <!--<td><button type="button">Accept</button></td>-->
                                <!--<td><button type="button">Reject</button></td>-->
                    
                                </tr> <?php 
                            }
                        } ?>           
                    </table>
                    </div>
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