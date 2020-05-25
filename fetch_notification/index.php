<?php

// PHP code to fetch all the notifications generated for particular user of
//     wishlist
//     approved book
//     rejected book
//     contact owner by email

require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw);
$final;

session_start();

if(!empty($_SESSION)) 
{
    if (!empty($_SESSION['user_email'])) 
    {
        try 
        {
            $stmt_id = $conn->prepare("SELECT * FROM user_details WHERE email_id = ?");
            $stmt_id->bindParam(1, $_SESSION['user_email']);
            $stmt_id->execute();
            $row_id = $stmt_id->fetch(PDO::FETCH_ASSOC);
            $row_id['no_records'] = $stmt_id->rowCount();
            
            if ($row_id['no_records'] != 0) {
                $stmt_select = $conn->prepare("SELECT * FROM user_notifications WHERE user_id = ? AND is_fetched = 0");
                $stmt_select->bindParam(1, $row_id['user_id']);
                $stmt_select->execute();
                
                // $stmt_notif = $conn->prepare("UPDATE user_notifications SET is_fetched = 1 WHERE id = ?");
                
                $row['no_records'] = $stmt_select->rowCount();
                $row['is_error'] = false;
                $row['message'] = "Fetched notifications successfully";
                
                for ($i=0; $i< $stmt_select->rowCount(); $i++) 
                {
                    $row_select = $stmt_select->fetch(PDO::FETCH_ASSOC);
                    // $stmt_notif->bindParam(1, $row_select['id']);
                    // $stmt_notif->execute();
                    array_push($row, $row_select);
                }
                
                $final = $row;
            } else {
                $final = array("is_error"=>true, "message"=>"User not found");
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