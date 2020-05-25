<?php

// PHP code to update user profile including password

require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw);
$final;

session_start();

// old_password
// new_password
// first_name
// last_name
// mobile_num
// address
// area
// city
// display_picture

if(!empty($_SESSION)) 
{
    if (!empty($_SESSION['user_email']) && !empty($data)) 
    {
        try {
            $stmt_select = $conn->prepare("SELECT * FROM user_details WHERE email_id = ? AND activated_user = 1");
            $stmt_select->bindParam(1, $_SESSION['user_email']);
            $stmt_select->execute();
            $row_select = $stmt_select->fetch(PDO::FETCH_ASSOC);
            
            $row_select['no_records'] = $stmt_select->rowCount();
            
            if ($row_select['no_records'] != 0) {
                // if (empty($data->old_password) || empty($data->new_password) || empty($data->first_name) || empty($data->mobile_num) || empty($data->address) || empty($data->area) || empty($data->city)) {
                if (empty($data->first_name) || empty($data->mobile_num) || empty($data->address) || empty($data->area) || empty($data->city)) {
                    $final = array("is_error"=>true, "message"=>"Values not inserted properly");
                } else {
                // } else if ($data->old_password == $row_select['password']){
                    // $stmt_update = $conn->prepare("UPDATE user_details SET password = ?, first_name = ?, last_name = ?, mobile_num = ?, address = ?, area = ?, city = ?, display_picture = ? WHERE user_id = ?");
                    $stmt_update = $conn->prepare("UPDATE user_details SET first_name = ?, last_name = ?, mobile_num = ?, address = ?, area = ?, city = ?, display_picture = ? WHERE user_id = ?");
                    // $stmt_update->bindParam(1, $data->new_password);
                    $stmt_update->bindParam(1, $data->first_name);
                    $stmt_update->bindParam(2, $data->last_name);
                    $stmt_update->bindParam(3, $data->mobile_num);
                    $stmt_update->bindParam(4, $data->address);
                    $stmt_update->bindParam(5, $data->area);
                    $stmt_update->bindParam(6, $data->city);
                    $stmt_update->bindParam(7, $data->display_picture);
                    $stmt_update->bindParam(8, $row_select['user_id']);
                    $stmt_update->execute();
                    $row_update = $stmt_update->fetch(PDO::FETCH_ASSOC);
                    
                    $file_dir='../images/' . $row_select['email_id'];
                    $realImage = base64_decode($data->display_picture);
                    file_put_contents($file_dir . '/' . "user.jpg", $realImage);
                    
                    $row_update['is_error'] = false;
                    $row_update['message'] = "User updated successfully";
                    $final = $row_update;
                // } else {
                //     $final = array("is_error"=>true, "message"=>"Wrong credentials");
                }
            } else {
                $final = array("is_error"=>true, "message"=>"User not registered");
            }
            
        } catch(PDOException $e) 
        {
            $final['is_error'] = true;
            $final['message'] = $e->getMessage();
        } catch(Exception $e) 
        {
            $final['is_error'] = true;
            $final['message'] = $e->getMessage();
        } 
    } else 
    {
        $final = array("is_error"=>true, "message"=>"Values not inserted properly");
    }
} else 
{
    $final = array("is_error"=>true, "message"=>"Please Sign In");
}

echo json_encode($final);
?>
