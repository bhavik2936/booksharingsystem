<?php

// PHP code to Fetch All the Latest Book from the Database and send it as JSON to Front-End

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
    if (!empty($_SESSION['user_email'])) 
    {
        try 
        {
            $stmt = $conn->prepare("SELECT * FROM user_details WHERE email_id = ?");
            $stmt->bindParam(1, $_SESSION['user_email']);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(!empty($row['display_picture'])){
                $file_dir = 'https://booksharingsystem.000webhostapp.com/images/' . $row['email_id'] . '/' . $row['display_picture'];
            } else {
                $file_dir = 'https://booksharingsystem.000webhostapp.com/images/person.png';
            }
            
            $final['display_picture'] = $file_dir;
            $final['is_error'] = false;
            $final['message'] = "Fetched display picture sucessfully";
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
