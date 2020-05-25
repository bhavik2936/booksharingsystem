<?php

// PHP code to Fetch All the Book details from the Database and send it as JSON to Front-End

require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw);
$final;
$row=Array();
session_start();

if(!empty($_SESSION)) 
{
    if (!empty($_SESSION['user_email'])) 
    {
        try 
        {
            $id=$_SESSION['user_email'];
            
            $stmt = $conn->prepare("SELECT * FROM user_details WHERE email_id = '$id'");
            $stmt->execute();
            $row1= $stmt->fetch(PDO::FETCH_ASSOC);
            // print_r($row1);
            $abcd= $row1['user_id'];
            
            $stmt_insert = $conn->prepare("SELECT * FROM user_wishlist WHERE user_id = '$abcd' AND in_wishlist = 1");
            $stmt_insert->execute();
            $count=0;
            for($i=0; $i<$stmt_insert->rowCount(); $i++)
            {
                $row_id = $stmt_insert->fetch(PDO::FETCH_ASSOC);
                array_push($row, $row_id);
                $count++;
            }
            $row['count']=$count;
            $row['is_error'] = false;
            $row['message'] = "Book displayed Sucessfully ! ";
            $final = $row;
        } 
        catch(PDOException $e) 
        {
            $final['is_error'] = true;
            $final['message'] = $e->getMessage();
        }
        catch(Exception $e) 
        {
            $final['is_error'] = true;
            $final['message'] = $e->getMessage();
        } 
    } 
    else 
    {
        $final = array("is_error"=>true, "message"=>"Values not inserted properly");
    }
} 
else 
{
    $final = array("is_error"=>true, "message"=>"Please Sign In");
}

echo json_encode($final);

?>