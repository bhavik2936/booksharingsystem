<?php

// PHP code to Fetch All the Book details from the Database and send it as JSON to Front-End

require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw);
$final;

session_start();

// book_id

if(!empty($_SESSION)) 
{
    if (!empty($_SESSION['user_email']) && !empty($data)) 
    {
        $row = Array();
        try 
        {
            $stmt_id = $conn->prepare("SELECT * FROM book_details WHERE book_id = '$data->book_id' AND is_approved = 1 AND owner_id IN (SELECT user_id FROM user_details WHERE activated_user = 1)");
            // $stmt_id = $conn->prepare("SELECT b.* from book_details b, user_details u WHERE u.user_id = b.owner_id and u.activated_user=1");
            
            $stmt_id->execute();
    
            // for ($i=0; $i< $stmt_id->rowCount(); $i++) 
            // {
                $row_id = $stmt_id->fetch(PDO::FETCH_ASSOC);
                //array_push($row,$row_id);
            // }

            $temp =  $_SESSION['user_email'];
            
            $comment = $conn->prepare("SELECT * from book_transaction where book_id = $data->book_id AND borrower_id = $temp");
            $comment->execute();
            
            if($comment->rowCount()!=0)
                $final['can_comment'] = 1;
            else
                $final['can_comment'] = 0;
            
            $rt= $conn->prepare("SELECT * FROM book_details WHERE book_id = $data->book_id");
            $rt->execute();
            $mail=$rt->fetch(PDO::FETCH_ASSOC);
            $mid=$mail['owner_id'];
            
            
            $pic=$conn->prepare("SELECT * FROM user_details WHERE user_id = '$mid'");
            $pic->execute();
            $r=$pic->fetch(PDO::FETCH_ASSOC);
            $name=$r['first_name']." ".$r['last_name'];
            $row_id['name'] = $name;
            $dp_dir='https://booksharingsystem.000webhostapp.com/images/';
            if(!empty($r['display_picture']))
            {
                $pt = $r['display_picture'];
                $row_id['display_picture'] = $dp_dir.$r['email_id']."/".$pt;
            }
            else
            {
                $row_id['display_picture'] = $dp_dir."person.png";
            }
            
            $file_dir='https://booksharingsystem.000webhostapp.com/images/' . $temp . '/' . $data->book_id;
            if(!empty($row_id['photo_path1']))
            {
                $path1 = $row_id['photo_path1'];
                // echo $path1;
                // echo $file_dir;
                $row_id['photo_path1'] = $file_dir . '/' . $path1;
            }
            if(!empty($row_id['photo_path2']))
            {
                $path2 = $row_id['photo_path2'];
                $row_id['photo_path2'] = $file_dir . '/' . $path2;
            }
            if(!empty($row_id['photo_path3']))
            {
                $path3 = $row_id['photo_path3'];
                $row_id['photo_path3'] = $file_dir . '/' . $path3;
            }
            if(!empty($row_id['photo_path4']))
            {
                $path4 = $row_id['photo_path4'];
                $row_id['photo_path4'] = $file_dir . '/' . $path4;
            }
            
            $row_id['no_records'] = $stmt_id->rowCount();
            $row_id['is_error'] = false;
            $row_id['message'] = "Fetched book details sucessfully";
            
            $final = $row_id;
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