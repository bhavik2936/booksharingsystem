<?php
session_start();
    if(!empty($_SESSION))
    {
        if(($_SESSION['name'])=="user")
        {

require "../DBConnection.php";
if(isset($_GET['id1'])){
    echo "Complainer";
    $id=$_GET['id1'];
    $query="update user_complaint set is_reviewed='1' where complainer_id=$id";
    $get2=$conn->prepare($query);
    $get2->execute();
    $query3="update user_details set activated_user='0' where user_id=$id";
    $get3=$conn->prepare($query3);
    $get3->execute();
}
if(isset($_GET['id2'])){
    echo "Complainee";
    $id=$_GET['id2'];
    $query="update user_complaint set is_reviewed='1' where complainee_id=$id";
    $get2=$conn->prepare($query);
    $get2->execute();
    $query3="update user_details set activated_user='0' where user_id=$id";
    $get3=$conn->prepare($query3);
    $get3->execute();
}
if(isset($_GET['id3'])){
    echo "Book";
    $id=$_GET['id3'];
    $query="update user_complaint set is_reviewed='1' where book_id=$id";
    $get2=$conn->prepare($query);
    $get2->execute();
    $query3="update book_details set is_approved='0'where book_id=$id";
    $get3=$conn->prepare($query3);
    $get3->execute();
}
if(isset($_GET['id4'])){
    $id=$_GET['id4'];
    $query="update user_complaint set is_reviewed='1' where book_id=$id";
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
            <a class="active" href="complaints.php">Complaints</a>
            <a href="secondpage.php">Home</a>
            <a href="logout.php" style="float:right;">Log Out</a>
        </div><br><br>
        <div style="overflow-x:auto;">
        <table>
             <?php
             $query2="select *from user_complaint where is_reviewed='0'";
             $get4=$conn->prepare($query2);
             $get4->execute();
             $count=$get4->rowCount();
             if($count==0){
                 echo "<script>alert('No Complaints Registered...')</script>";
             }
             else
              {  ?>
                  <tr>
                         <th>Complain</th>
                         <th>Block Complainer</th>
                         <th>Block Complainee</th>
                         <th>Block Book</th>
                         <th>No_Action needed</th>
                 </tr>
<?php 
                 for($i=0; $i<$count; $i++)
                 {
                     $row=$get4->fetch(PDO::FETCH_ASSOC);
                     $description=$row['complaint_description'];
                     $book=$row['book_id'];
                     $compr=$row['complainer_id'];
                     $compe=$row['complainee_id']

?>

                     <tr>
                     <td><?php echo $description; ?></td>
                     <td><a href="complaints.php?id1=<?php echo "$compr";?>"><button>Block</button></a></td>  
                     
                     <td><a href="complaints.php?id2=<?php echo "$compe";?>"><button>Block</button></a></td> 
                     
                     <td><a href="complaints.php?id3=<?php echo "$book";?>"><button>Block</button></a></td>
                     
                     <td><a href="complaints.php?id4=<?php echo "$book";?>"><button>No_Action</button></a></td>
                     
                     
                     </tr> <?php 
                     
                 }
                                 
             } ?>           
        </table>
    
    </body>
</html>
<?php
}
}
else
{
   ?>
    <script>
    alert('Please Login....')
    window.location.href = "index.php";
    </script>
    
<?php
}
?>