<?php

// PHP code to validate the counts obtained by the book owner and the book reader

require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw);
$final;

session_start();

if(!empty($_SESSION)) 
{
    if (!empty($_SESSION['user_email']) && !empty($data))
    {
        $row = Array();
        try 
        {
            // $stmt_id = $conn->prepare("SELECT book_id from book_transaction WHERE book_id = '$data->book_id' order by ASC");
            
            $stmt="SELECT * FROM book_transaction order by return_date ASC";
            $stmt_id=$conn->prepare($stmt);
            $stmt_id->execute();
            
            $row_id = $stmt_id->fetch(PDO::FETCH_ASSOC);
            $row_id['is_point_approved'] = "1";
            // array_push($row, $row_id);
            
            $bbb = $row_id['borrower_id'];
            $p1 = "SELECT points, user_id FROM user_details WHERE user_id = $bbb";
            $p1_id=$conn->prepare($p1);
            $p1_id->execute();
            $bpoint= $p1_id->fetch(PDO::FETCH_ASSOC);
            $bpoint['points'] = "3";
            array_push($row,$bpoint);
            
            $ooo = $row_id['owner_id'];
            $p2 = "SELECT points, user_id FROM user_details WHERE user_id = $ooo"; 
            $p2_id=$conn->prepare($p2);
            $p2_id->execute();
            $opoint= $p2_id->fetch(PDO::FETCH_ASSOC);
            $opoint['points'] = "10";
            array_push($row,$opoint);
            
            // $row['no_records'] = $stmt_id->rowCount();
            $row['is_error'] = false;
            $row['message'] = "Points approved successfully !";
            
            $final = $row;
            
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

