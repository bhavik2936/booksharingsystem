<?php

// PHP code fetch the transaction details of a user

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
    if (!empty($_SESSION['user_email'])) 
    {
        $row = Array();
        try 
        {
            $stmt_select = $conn->prepare("SELECT * FROM user_details WHERE email_id = ?");
            $stmt_select->bindParam(1, $_SESSION['user_email']);
            $stmt_select->execute();
            $row_select = $stmt_select->fetch(PDO::FETCH_ASSOC);
            $row_select['no_records'] = $stmt_select->rowCount();
            
            if ($row_select['no_records'] != 0) {
                $stmt_trans = $conn->prepare("SELECT * FROM book_transaction WHERE owner_id = ? OR borrower_id = ?");
                $stmt_trans->bindParam(1, $row_select['user_id']);
                $stmt_trans->bindParam(2, $row_select['user_id']);
                $stmt_trans->execute();
                
                $final['count'] = $stmt_trans->rowCount();
                
                for ($i=0; $i<$stmt_trans->rowCount(); $i++) {
                    $row_trans = $stmt_trans->fetch(PDO::FETCH_ASSOC);
                    
                    $stmt_book = $conn->prepare("SELECT * FROM book_details WHERE book_id = ?");
                    $stmt_book->bindParam(1, $row_trans['book_id']);
                    $stmt_book->execute();
                    $row_book = $stmt_book->fetch(PDO::FETCH_ASSOC);
                    
                    $row['trans_id'] = $row_trans['id'];
                    $row['book_id'] = $row_book['book_id'];
                    $row['book_name'] = $row_book['book_title'];
                    $row['borrow_date'] = $row_trans['borrow_date'];
                    $row['return_date'] = $row_trans['return_date'];

                    $stmt_bor = $conn->prepare("SELECT * FROM user_details WHERE user_id = ?");

                    if ($row_trans['owner_id'] == $row_select['user_id']) {
                        $row['owner_id'] = $row_trans['owner_id'];
                        $row['owner_name'] = $row_select['first_name'];
                        if (!empty($row['display_picture'])) {
                            $row['owner_dp'] = "http://52.236.33.218/booksharingsystem/images/" . $row['email_id'] . "/" . $row['display_picture'];
                        } else {
                            $row['owner_dp'] = "http://52.236.33.218/booksharingsystem/images/person.png";
                        }

                        $stmt_bor->bindParam(1, $row_trans['borrower_id']);
                        $stmt_bor->execute();
                        $row_bor = $stmt_bor->fetch(PDO::FETCH_ASSOC);

                        $row['borrower_id'] = $row_bor['user_id'];
                        $row['borrower_name'] = $row_bor['first_name'];
                        if (!empty($row_bor['display_picture'])) {
                            $row['borrower_dp'] = "http://52.236.33.218/booksharingsystem/images/" . $row_bor['email_id'] . "/" . $row_bor['display_picture'];
                        } else {
                            $row['borrower_dp'] = "http://52.236.33.218/booksharingsystem/images/person.png";
                        }
                    } else {
                        $stmt_bor->bindParam(1, $row_trans['owner_id']);
                        $stmt_bor->execute();
                        $row_bor = $stmt_bor->fetch(PDO::FETCH_ASSOC);

                        $row['owner_id'] = $row_trans['owner_id'];
                        $row['owner_name'] = $row_bor['first_name'];
                        if (!empty($row['display_picture'])) {
                            $row['owner_dp'] = "http://52.236.33.218/booksharingsystem/images/" . $row_bor['email_id'] . "/" . $row_bor['display_picture'];
                        } else {
                            $row['owner_dp'] = "http://52.236.33.218/booksharingsystem/images/person.png";
                        }

                        // $stmt_bor->bindParam(1, $row_trans['borrower_id']);
                        // $stmt_bor->execute();
                        $row['borrower_id'] = $row_select['user_id'];
                        $row['borrower_name'] = $row_select['first_name'];
                        if (!empty($row_select['display_picture'])) {
                            $row['borrower_dp'] = "http://52.236.33.218/booksharingsystem/images/" . $row_select['email_id'] . "/" . $row_select['display_picture'];
                        } else {
                            $row['borrower_dp'] = "http://52.236.33.218/booksharingsystem/images/person.png";
                        }
                    }
                    
                    // $final = array();
                    array_push($final, $row);
                }
                if ($stmt_trans->rowCount() == 0) {
                    $final = array("count"=>0, "is_error"=>false, "message"=>"Transaction history fetched sucessfully");
                } else {
                    // $final['count'] = $stmt_trans->rowCount();
                    $final['is_error'] = false;
                    $final['message'] = "Transaction history fetched sucessfully";
                }
            } else {
                $final = array("is_error"=>true, "message"=>"User not Found");
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