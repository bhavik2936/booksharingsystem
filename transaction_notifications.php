<?php

require "../DBConnection.php";
session_start();

$email=$_SESSION['user_email'];

$query = $conn->prepare("SELECT * FROM user_details WHERE email_id = '$email'");
$query->execute();
$st=$query->fetch(PDO::FETCH_ASSOC);
$id=$st['user_id'];

$q="SELECT * FROM book_transaction WHERE borrower_id = '$id'";
$q->execute();

for($i=0; $i<$q->rowCount(); $i++)
{
    $row=$q->fetch(PDO::FETCH_ASSOC);
    $bid=$row['book_id'];
    
    $qry=$conn->prepare("SELECT * FROM book_details WHERE book_id = '$bid'");
    $qry->execute();
    $st=$qry->fetch(PDO::FETCH_ASSOC);
    
    $gtime=date("Y-m-d H:i:s");
    $etime=$row['return_date'];
    if(strtotime($etime)-strtotime($gtime)<=172800)
    {
        $qry=$conn->prepare("SELECT * FROM book_transaction WHERE book_id = '$bid' ORDER BY borrow_date DESC");
        $qry->execute();
        $st=$qry->fetch(PDO::FETCH_ASSOC);
        
        $decr="Book borrowed by you with title ".$st['book_title']." is going to expired on ".$etime;
        $query=$conn->prepare("INSERT INTO user_notifications (user_id, book_id, description, notification_type) VALUES (?, ?, ?, ?)");
        $query->bindParam(1, $id);
        $query->bindParam(2, $row['book_id']);
        $query->bindParam(3, $descr);
        $query->bindParam(4, $st);
        $query->execute();
    }
}

$query

?>