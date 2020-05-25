<?php

// PHP code to Fetch All the reviews written on the given book_id

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
    if (!empty($_SESSION['user_email']) && !empty($data))
    {
        $final = Array();
        // get = stmt_id
        
        try 
        {
            $get = $conn->prepare("SELECT * from book_review WHERE book_id = $data->book_id");
            $get->execute();
            // $row = $get->fetch(PDO::FETCH_ASSOC);
            
            // $final['no_records'] = $get->rowCount();
            // $count = $get->rowCount();
            // echo $count;
            
            // $count = $get->rowCount();
            $row['no_records'] = $get->rowCount();
            // $row['is_error'] = false;
            // $row['message'] = "Fetched Review sucessfully";
            
            for($i=0; $i < $row['no_records'] ; $i++)
            {
                $row_id = $row;
                $row_id = $get->fetch(PDO::FETCH_ASSOC);
                // $row_id['user_id'] = $row['user_id'];
                // $row_id['book_rating'] = $row['book_rating'];
                // $row_id['review'] = $row['review'];
                // $row_id['review_date'] = $row['review_date'];
                
                $name = $row_id['user_id'];
                $query = $conn->prepare("SELECT * FROM user_details WHERE user_id = $name");
                $query->execute();
                $roww = $query->fetch(PDO::FETCH_ASSOC);

                $row_id['first_name'] = $roww['first_name'];
                if ($roww['display_picture'] == NULL) {
                    $row_id['display_picture'] = "https://booksharingsystem.000webhostapp.com/images/person.png";
                } else {
                    $row_id['display_picture'] = "https://booksharingsystem.000webhostapp.com/images/" . $roww['email_id'] . "/" . "user.jpg";
                }
                // $row_id['display_picture'] = $roww['display_picture'];
                
                array_push($row, $row_id);
                
                // $name1 = $sum['first_name'];
                // $fname = 'first_name'.$i;
                // $final[$fname] = $sum['first_name'];
                // $name2 = $sum['display_picture'];
                // $dp = 'picture'.$i;
                // $final[$dp] = $sum['display_picture'];
                // $name = $row['user_id'];
                // $user = 'user'.$i;
                // $final[$user] = $row['user_id'];
                // $a = $row['book_rating'];
                // $rating = 'rating'.$i;
                // $final[$rating] = $row['book_rating'];
                // $b = $row['review'];
                // $review = 'review'.$i;
                // $final[$review] = $row['review'];
                // $c = $row['review_date'];
                // $rdt = 'review_date'.$i;
                // $final[$rdt] = $row['review_date'];
                // $query = $conn->prepare("SELECT first_name , display_picture FROM user_details WHERE user_id = $name");
                // $query->execute();
                // $sum = $query->rowCount();
                // $details = $get->fetch(PDO::FETCH_ASSOC);
                // $name1 = $sum['first_name'];
                // $fname = 'first_name'.$i;
                // $final[$fname] = $sum['first_name'];
                // $name2 = $sum['display_picture'];
                // $dp = 'picture'.$i;
                // $final[$dp] = $sum['display_picture'];
                // $user = 'user'.$i;
                // $final[$user] = $row['user_id'];
            }
            
            $final = $row;
            $final['is_error'] = false;
            $final['message'] = "Fetched Review sucessfully";
            
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



