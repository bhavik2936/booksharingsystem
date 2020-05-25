<?php

// PHP code to Send an Email in case of Forgot Password 

// require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw);

$final;

if ($data != null) 
{
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789$@";
        $new_pwd=substr(str_shuffle($chars),0,8);
        $msg= "Hi " . $data->first_name . ", <br><br>Your new password for email id " . $data->email_id . " is " . $new_pwd;
        mail($data->email_id, "Forgot Password", $msg);
        $final['new_password'] = $new_pwd;
        $final['is_error'] = false;
        $final['message'] = "A New password is sent to your Email Address !";
} 
else 
{
    $final = array("is_error"=>true, "message"=>"Email Id not Inserted !");
}

echo json_encode($final);

?>