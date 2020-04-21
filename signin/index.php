<?php

// PHP code to perform the Sign-In Procedure 

require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw);

$final;

if ($data != null) 
{
    $query = "SELECT * FROM user_details WHERE email_id = '$data->email_id' AND password = '$data->password' AND activated_user = 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    unset($row['password']);
    $row['no_records'] = $stmt->rowCount();
    
    if ($row['no_records'] == 0) 
    {
        $row['is_error'] = true;
        $row['message'] = "Incorrect Username or Password ! ";
        $final = $row;
    } 
    else if ($row['verified_user'] == 0) 
    {
        $final['no_records'] = $row['no_records'];
        $final['is_error'] = true;
        $final['message'] = "Verify Your Email Address !";
    }
    else 
    {
        session_start();
        $_SESSION['user_email'] = $row['email_id'];
        if(!empty($row['display_picture'])){
            $file_dir = 'http://52.236.33.218/booksharingsystem/images/' . $row['email_id'] . '/' . $row['display_picture'];
        } else {
            $file_dir = 'http://52.236.33.218/booksharingsystem/images/person.png';
        }
        $row['display_picture'] = $file_dir;
        $row['is_error'] = false;
        $row['message'] = "You have Logged In Sucessfully !";
        $final = $row;
    }

    // print_r($row);
} 
else 
{
    $final = array("is_error"=>true, "message"=>"No Values Inserted ! ");
}

echo json_encode($final);

// $email_id = $_POST['email_id'];
?>