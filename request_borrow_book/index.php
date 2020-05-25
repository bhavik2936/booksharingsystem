<?php

// PHP code to request the book for borrowing purpose only
// work in progress
// nothing done in this php 
// ready to be edited

require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw);
$final;

session_start();

// email_id
// no_of_books

if(!empty($_SESSION)) 
{
    if (!empty($_SESSION['user_email']) && !empty($data)) 
    {
        try 
        {
            $stmt_ = $conn->prepare("SELECT * FROM user_details WHERE activated_user = 1");
            $stmt_id = $conn->prepare("SELECT * FROM book_details WHERE owner_id IN (SELECT user_id FROM user_details WHERE activated_user = 1) ORDER BY added_date DESC LIMIT $data->no_of_books");
            $stmt_id->execute();
    
            $row['no_records'] = $stmt_id->rowCount();
            $row['is_error'] = false;
            $row['message'] = "Fetched books sucessfully";
            
            for ($i=0; $i< $stmt_id->rowCount(); $i++) 
            {
                $row_id = $stmt_id->fetch(PDO::FETCH_ASSOC);
                array_push($row, $row_id);
            }
            
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