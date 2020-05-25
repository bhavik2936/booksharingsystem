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
            //echo $id;
            
            // $query="SELECT DISTINCT (book_id) FROM book_details WHERE book_title= '$name1'";
            // $stmt=$conn->prepare($query);
            // $stmt->execute();
            
            $stmt = $conn->prepare("SELECT * FROM user_details WHERE email_id = '$id'");
            $stmt->execute();
            $row1= $stmt->fetch(PDO::FETCH_ASSOC);
            // print_r($row1);
            $abcd= $row1['user_id'];
            // echo $abcd;
            $stmt=$conn->prepare("SELECT * FROM user_wishlist WHERE user_id = '$abcd'");
            $stmt->execute();
            $flag=0;
            for($i=0; $i<$stmt->rowCount(); $i++)
            {
                $roww=$stmt->fetch(PDO::FETCH_ASSOC);
                if($roww['book_title']==$data->book_title && $roww['book_author']==$data->book_author)
                {
                    $flag=1;
                }
            }
            if($flag == 0){
                $temp_book_title = strtolower($data->book_title);
                $data->book_title = ucwords($temp_book_title);
            
            $stmt_insert = $conn->prepare("INSERT INTO user_wishlist (user_id, book_title, book_author) VALUES (?, ?, ?)");
            // echo $row1['user_id']." ".$data->book_title."   ".$data->book_author;
            $stmt_insert->bindParam(1, $row1['user_id']);
            $stmt_insert->bindParam(2, $data->book_title);
            $stmt_insert->bindParam(3, $data->book_author);
            $stmt_insert->execute();
            $final['is_error'] = false;
            $final['message'] = "Book added in wishlist Sucessfully ! ";
            } 
            else
            {
                $final['is_error'] = true;
                $final['message'] = "Book already added in wishlist! ";
            }
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