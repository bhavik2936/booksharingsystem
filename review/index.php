<?php

// PHP code to Fetch All the Book details from the Database and send it as JSON to Front-End

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
            $id=$_SESSION['user_email'];
            // echo $id;
            $stmt = $conn->prepare("SELECT * FROM user_details WHERE email_id = '$id' AND activated_user = 1");
            $stmt->execute();
            $row1= $stmt->fetch(PDO::FETCH_ASSOC);
            // print_r($row1);
            $abcd= $row1['user_id'];
            // echo $abcd;
            // $stmt=$conn->prepare("SELECT * FROM book_details WHERE book_id = '$data->book_id' AND is_approved = 1");
            // $stmt->execute();
            // $roww=$stmt->fetch(PDO::FETCH_ASSOC);
            // for($i=0; $i<$stmt->rowCount(); $i++)
            // {
            //     $roww=$stmt->fetch(PDO::FETCH_ASSOC);
            // }
            $stmt_insert = $conn->prepare("INSERT INTO book_review (book_id, user_id, book_rating, review) VALUES (?, ?, ?, ?)");
            // echo $row1['user_id']." ".$data->book_title."   ".$data->book_author;
            $stmt_insert->bindParam(1, $data->book_id);
            $stmt_insert->bindParam(2, $abcd);
            $stmt_insert->bindParam(3, $data->book_rating);
            $stmt_insert->bindParam(4, $data->review);
            $stmt_insert->execute();
            $final['is_error'] = false;
            $final['message'] = "Review uploaded Sucessfully ! ";
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