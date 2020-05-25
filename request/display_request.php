<?php

// PHP code to Fetch All the Book details from the Database and send it as JSON to Front-End

require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw);
$final=Array();

session_start();

// email_id
// no_of_books

if(!empty($_SESSION)) 
{
    if (!empty($_SESSION['user_email'])) 
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
            $stmt_insert = $conn->prepare("SELECT * FROM book_request WHERE owner_id = '$abcd' AND is_borrow_request_approved IS NULL ORDER BY date DESC");
            $stmt_insert->execute();
            // echo "wdesd".$stmt_insert->rowCount();
            for($i=0; $i<$stmt_insert->rowCount(); $i++)
            {
                $roww= $stmt_insert->fetch(PDO::FETCH_ASSOC);
                $bid=$roww['borrower_id'];
                $bookid = $roww['book_id'];
                
                $stmt_mail = $conn->prepare("SELECT * FROM user_details WHERE user_id = ?");
                $stmt_mail->bindParam(1, $bid);
                $stmt_mail->execute();
                $row_mail = $stmt_mail->fetch(PDO::FETCH_ASSOC);
                
                $name=$row_mail['first_name'] . " " . $row_mail['last_name'];
                $roww['borrower_name'] = $name;
                
                if(!empty($row_mail['display_picture'])){
                    $file_dir='https://booksharingsystem.000webhostapp.com/images/' . $row_mail['email_id'] . '/' . $row_mail['display_picture'];
                }
                else
                {
                    $file_dir='https://booksharingsystem.000webhostapp.com/images/person.png';
                }
                
                $stmt_mail = $conn->prepare("SELECT * FROM book_details WHERE book_id = ?");
                $stmt_mail->bindParam(1, $bookid);
                $stmt_mail->execute();
                $row_mail = $stmt_mail->fetch(PDO::FETCH_ASSOC);
                
                $roww['book_title']=$row_mail['book_title'];
                $roww['display_picture']=$file_dir;
                
                
                array_push($final, $roww);
            }
            $final['count']=$stmt_insert->rowCount();
            $final['is_error'] = false;
            $final['message'] = "Request displayed Sucessfully ! ";
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