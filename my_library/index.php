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
            // echo $abcd;
            $stmt=$conn->prepare("SELECT * FROM book_details WHERE owner_id = '$abcd' AND is_approved = 1");
            $stmt->execute();
            for($i=0; $i<$stmt->rowCount(); $i++)
            {
                $roww=$stmt->fetch(PDO::FETCH_ASSOC);
                
                $file_dir="https://booksharingsystem.000webhostapp.com/images/".$id."/"."$roww[book_id]";
                
                if(!empty($roww['photo_path1']))
                {
                    $path1 = $roww['photo_path1'];
                    // echo $path1;
                    // echo $file_dir;
                    $roww['photo_path1'] = $file_dir . '/' . $path1;
                }
                if(!empty($roww['photo_path2']))
                {
                    $path2 = $roww['photo_path2'];
                    $roww['photo_path2'] = $file_dir . '/' . $path2;
                }
                if(!empty($roww['photo_path3']))
                {
                    $path3 = $roww['photo_path3'];
                    $roww['photo_path3'] = $file_dir . '/' . $path3;
                }
                if(!empty($roww['photo_path4']))
                {
                    $path4 = $roww['photo_path4'];
                    $roww['photo_path4'] = $file_dir . '/' . $path4;
                }
                
                // print_r($roww);
                array_push($final, $roww);
            }
            $final['count']=$stmt->rowCount();
            $final['is_error'] = false;
            $final['message'] = "Book displayed Sucessfully ! ";
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