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
        if (empty($data->complaint_description))
        {
            $final['is_error'] = true;
            $final['message'] = "Complaint description should not be empty";
        }
        else
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
                // $stmt=$conn->prepare("SELECT * FROM book_details WHERE book_id = '$data->book_id' AND is_approved = 1");
                // $stmt->execute();
                // $roww=$stmt->fetch(PDO::FETCH_ASSOC);
                // for($i=0; $i<$stmt->rowCount(); $i++)
                // {
                //     $roww=$stmt->fetch(PDO::FETCH_ASSOC);
                // }
                
                $stmt1=$conn->prepare("SELECT * FROM book_transaction WHERE id = $data->id");
                $stmt1->execute();
                $row=$stmt1->fetch(PDO::FETCH_ASSOC);
                $id=$row['book_id'];
                $complainer=$abcd;
                $bd=$row['borrow_date'];
                $rd=$row['return_date'];
                if($abcd == $row['owner_id']){
                    $complainee = $row['borrower_id'];
                }
                else{
                    $complainee = $row['owner_id'];
                }
                
                $stmt_insert = $conn->prepare("INSERT INTO user_complaint (complainer_id, complainee_id, book_id, complaint_description, borrow_date, return_date) VALUES (?, ?, ?, ?, ?, ?)");
                // echo $row1['user_id']." ".$data->book_title."   ".$data->book_author;
                $stmt_insert->bindParam(1, $complainer);
                $stmt_insert->bindParam(2, $complainee);
                $stmt_insert->bindParam(3, $id);
                $stmt_insert->bindParam(4, $data->complaint_description);
                $stmt_insert->bindParam(5, $bd);
                $stmt_insert->bindParam(6, $rd);
                $stmt_insert->execute();
                $final['is_error'] = false;
                $final['message'] = "Complaint Submitted Sucessfully ! ";
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