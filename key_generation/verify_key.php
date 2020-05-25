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
            $bid=$data->book_id;
            $key=$data->key;
        	
        	$query1=$conn->prepare("SELECT * FROM user_details WHERE email_id='$id' AND activated_user=1");
        	$query1->execute();
        	$row=$query1->fetch(PDO::FETCH_ASSOC);
        	$temp=$row['user_id'];
        	
    		$query=$conn->prepare("SELECT * FROM key_generation WHERE book_id='$data->book_id' ORDER BY expired_time DESC");
            $query->execute();
            $stmt=$query->fetch(PDO::FETCH_ASSOC);
            if($stmt['key_generate']==$data->key)
            {
                $kgid=$stmt['id'];
                
                if($id != $stmt['user_id'])
                {
                    $etime=$stmt['expired_time'];
                    $stime=$stmt['generated_time'];
                	$gtime=date("Y-m-d H:i:s");
                
                    $query=$conn->prepare("SELECT * FROM book_request WHERE owner_id='$temp' AND book_id='$data->book_id' AND is_transaction_started=1");
                    $query->execute();
                    $response=$query->fetch(PDO::FETCH_ASSOC);
                    $query12=$conn->prepare("SELECT * FROM book_request WHERE borrower_id='$temp' AND book_id='$data->book_id' AND is_transaction_started=0");
                    $query12->execute();
                    $response12=$query12->fetch(PDO::FETCH_ASSOC);
                    $role="";
                    if($query->rowCount()>0)
                    {
                       $role="owner" ;
                    }
                    else if($query12->rowCount()>0){
                        $role="borrower";
                    }
                	if(strtotime($gtime)<=strtotime($etime) && strtotime($gtime)-strtotime($stime)>=604800)
                	{
                	    if($role=="borrower"){
                	        $q=$conn->prepare("UPDATE book_request SET is_transaction_started = 1 WHERE book_id = '$data->book_id AND borrower_id = '$id'");
                	        $q->execute();
                	        $oid=$response12['owner_id'];
                	        
                	        $ry=$conn->prepare("SELECT * FROM book_details WHERE book_id = '$data->book_id'");
                	        $ry->execute();
                	        $tm=$ry->fetch(PDO::FETCH_ASSOC);
                	        $a=$tm['no_of_day'];
                	        $add= 24 * $a;
                	        $addon="+".$add." hours";
                	        
                	        $etime=date("Y-m-d H:i:s", strtotime($addon));
                	        $qu=$conn->prepare("INSERT INTO book_transaction (book_id, owner_id, borrower_id, return_date) VALUES ('$bid', '$oid', '$temp', '$etime')");
                            $final['is_error'] = false;
                            $final['message'] = "Transaction started sucessfully";
                	    }
                	    else if($role=="owner")
                	    {
                	        $oid=$response['borrower_id'];
                	        $qu=$conn->prepare("UPDATE book_transaction SET is_point_approved = 1 WHERE book_id = '$bid' AND borrower_id = '$oid'");
                	        
                	        $quer=$conn->prepare("SELECT points FROM user_details WHERE user_id ='$oid'");
                	        $quer->execute();
                	        $rp=$quer->fetch(PDO::FETCH_ASSOC);
                	        $poi=$rp['points'];
                	        $newpoi=$poi+3;
                	        
                	        $quer=$conn->prepare("UPDATE user_details SET points = '$newpoi' WHERE user_id = '$oid'");
                	        $quer->execute();
                	        
                	        $quer1=$conn->prepare("SELECT points FROM user_details WHERE user_id ='$temp'");
                	        $quer1->execute();
                	        $rp=$quer1->fetch(PDO::FETCH_ASSOC);
                	        $poi=$rp['points'];
                	        $newpoi=$poi+10;
                	        
                	        $quer=$conn->prepare("UPDATE user_details SET points = '$newpoi' WHERE user_id = '$temp'");
                	        $quer->execute();
                	        
                            $final['is_error'] = false;
                            $final['message'] = "Transaction completed sucessfully";
                	    }
                	    else
                	    {
                            $final['is_error'] = true;
                            $final['message'] = "Cannot verify key!!";
                	    }
                	}
                    else if(strtotime($gtime)>strtotime($etime))
                    {
                        $final['is_error'] = true;
                        $final['message'] = "Key has been expired, Generate a new key!";
                    }
                    else
                    {
                        $final['is_error'] = true;
                        $final['message'] = "Cannot verify a new key before 7 days!";
                    }
                }
                else
                {
                    $final['is_error'] = true;
                    $final['message'] = "User cannot verify own key!";
                }
            }
            else
            {
                $final['is_error'] = true;
                $final['message'] = "Cannot verify key!";
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