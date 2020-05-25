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
        try 
        {
            $id=$_SESSION['user_email'];
            
            $key = '';
	        list($usec, $sec) = explode(' ', microtime());
        	mt_srand((float) $sec + ((float) $usec * 100000));
           	$inputs = array_merge(range('z','a'),range(0,9),range('A','Z'));
           	for($i=0; $i<6; $i++)
        	{
           	    $key .= $inputs{mt_rand(0,61)};
        	}
        	
        	$gtime=date("Y-m-d H:i:s");
        	$etime=date("Y-m-d H:i:s", strtotime("+1 hours"));
        	$query1=$conn->prepare("SELECT * FROM user_details WHERE email_id='$id' AND activated_user=1");
        	$query1->execute();
        	$row=$query1->fetch(PDO::FETCH_ASSOC);
        	$temp=$row['user_id'];
        	$query=$conn->prepare("SELECT * FROM book_request WHERE owner_id='$temp' AND book_id='$data->book_id' AND is_transaction_started=0");
            $query->execute();
            
            $query12=$conn->prepare("SELECT * FROM book_request WHERE borrower_id='$temp' AND book_id='$data->book_id' AND is_transaction_started=1");
            $query12->execute();
            $type="";
            
            if($query->rowCount()>0)
            {
               $type="exchange" ;
            }
            else if($query12->rowCount()>0){
                $type="return";
            }
            
            if($type="exchange")
            {
                $querry=$conn->prepare("UPDATE books_details SET no_of_day = '$data->no_of_day' WHERE book_id = '$data->book_id'");
                $querry->execute();
            }
            
            $qry=$conn->prepare("SELECT * FROM key_generation WHERE book_id = '$data->book_id' AND user_id = '$temp' ORDER BY expired_time DESC");
            $qry->execute();
            $rowww=$qry->fetch(PDO::FETCH_ASSOC);
            if($qry->rowCount()>0){
                $time=$rowww['expired_time'];
                // echo "gtime".$gtime."\n";
                // echo "time:".$time;
                if(strtotime($gtime)>strtotime($time)){
                    if($type == "exchange" || $type == "return"){
                    $query3="INSERT INTO key_generation (book_id,user_id,key_generate,generated_time,expired_time,key_type) VALUES ('$data->book_id','$temp','$key','$gtime','$etime','$type')";
                    
                    $stmt_insert=$conn->prepare($query3);
                    $stmt_insert->execute();
                    $final['key'] = $key;
                    $final['is_error'] = false;
                    $final['message'] = "Key generated sucessfully";
                    }
                    else
                    {
                        $final['is_error'] = true;
                        $final['message'] = "You cannot generate key!";
                    }
                }
                else
                {
                    $final['key'] = $rowww['key_generate'];
                    $final['is_error'] = false;
                    $final['message'] = "Key generated sucessfully";
                }
            
            }
            else
            {
                if($type == "exchange" || $type == "return"){
                    $query3="INSERT INTO key_generation (book_id,user_id,key_generate,generated_time,expired_time,key_type) VALUES ('$data->book_id','$temp','$key','$gtime','$etime','$type')";
                    
                    $stmt_insert=$conn->prepare($query3);
                    $stmt_insert->execute();
                    $final['key'] = $key;
                    $final['is_error'] = false;
                    $final['message'] = "Key generated sucessfully";
                }
                else
                {
                    $final['is_error'] = true;
                    $final['message'] = "You cannot generate key!";
                }
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