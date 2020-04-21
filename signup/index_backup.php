<?php
require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw);

$final;

if ($data != null) {
    try {
        $stmt_select = $conn->prepare("SELECT * FROM user_details WHERE email_id = '$data->email_id' AND activated_user = 1");
        $stmt_select->execute();
        $row_select = $stmt_select->fetch(PDO::FETCH_ASSOC);
        
        unset($row_select['password']);
        $row_select['no_records'] = $stmt_select->rowCount();
        
        if ($row_select['no_records'] == 0) {
            // $stmt = $conn->prepare("INSERT INTO user_details (email_id, password, first_name, last_name, mobile_num, address, area, city) VALUES (:email_id, :password, :first_name, :last_name, :mobile_num, :address, :area, :city)");
            // $stmt->bindParam(':email_id', $email_id);
            
            $stmt_insert = $conn->prepare("INSERT INTO user_details (email_id, password, first_name, last_name, mobile_num, address, area, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_insert->bindParam(1, $data->email_id);
            $stmt_insert->bindParam(2, $data->password);
            $stmt_insert->bindParam(3, $data->first_name);
            $stmt_insert->bindParam(4, $data->last_name);
            $stmt_insert->bindParam(5, $data->mobile_num);
            $stmt_insert->bindParam(6, $data->address);
            $stmt_insert->bindParam(7, $data->area);
            $stmt_insert->bindParam(8, $data->city);
            $stmt_insert->execute();
            
            $row_insert['no_records'] = $stmt_insert->rowCount();
            if ($row_insert['no_records'] != 0) {
                $row_insert['is_error'] = false;
                $row_insert['message'] = "User Registered Sucessfully";
                $final = $row_insert;
            } else {
                $row_insert['is_error'] = true;
                $row_insert['message'] = "Couldn't Register, Please try again";
                $final = $row_insert;
            }
        } else {
            $final['no_records'] = $row_select['no_records'];
            $final['is_error'] = true;
            $final['message'] = "User Already Registered";
        }
    } catch(PDOException $e) {
        $final['is_error'] = true;
        $final['message'] = $e->getMessage();
    }
    // print_r($row);
} else {
    $final['is_error'] = true; 
    $final['message'] = "Values not inserted properly";
}

echo json_encode($final);

// $email_id = $_POST['email_id'];
?>