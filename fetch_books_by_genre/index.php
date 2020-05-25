<?php

// PHP code to Fetch book by genre from Database and send it as JSON to Front-End

require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw);
$final;
$row=Array();

session_start();

if(!empty($_SESSION)) 
{
    if (!empty($_SESSION['user_email']) && !empty($data))
    {
        try 
        {
            // echo $data->genre;
            $commasep=explode(",",$data->genre);
            // print_r ($commasep);
            $cnt= sizeof($commasep);
            // echo "hi".$cnt;
            // print_r ($commasep);
            $query="SELECT DISTINCT (book_id) FROM book_details WHERE is_approved = 1 AND ";
            // $count=0;
            $query=$query."genre LIKE '%$commasep[0]%'";
            for($i=1; $i<$cnt; $i++)
            {
                $query=$query." OR genre LIKE '%$commasep[$i]%'";
            }
            // echo $query;
            $stmt_id = $conn->prepare($query);
            $stmt_id->execute();
            $count=0;
            
            for ($i=0; $i< $stmt_id->rowCount() && $count<$data->no_of_books; $i++)
            {
                $row_id = $stmt_id->fetch(PDO::FETCH_ASSOC);
                
                $abc=$row_id['book_id'];
                $query="SELECT * FROM book_details WHERE book_id = '$abc'";
                $stmt=$conn->prepare($query);
                $stmt->execute();
                $row_ins= $stmt->fetch(PDO::FETCH_ASSOC);
                
                $temp =  $row_ins['owner_id'];
                // echo "temp: ".$temp;
                $comment = $conn->prepare("SELECT * from user_details where user_id = '$temp'");
                $comment->execute();
                $r=$comment->fetch(PDO::FETCH_ASSOC);
                // echo "weds".$r['email_id'];
                $file_dir='https://booksharingsystem.000webhostapp.com/images/' . $r['email_id'] . '/' . $row_id['book_id'];
                
                if(!empty($row_ins['photo_path1']))
                {
                    $path1 = $row_ins['photo_path1'];
                    // echo $path1;
                    // echo $file_dir;
                    $row_ins['photo_path1'] = $file_dir . '/' . $path1;
                }
                if(!empty($row_ins['photo_path2']))
                {
                    $path2 = $row_ins['photo_path2'];
                    $row_ins['photo_path2'] = $file_dir . '/' . $path2;
                }
                if(!empty($row_ins['photo_path3']))
                {
                    $path3 = $row_ins['photo_path3'];
                    $row_ins['photo_path3'] = $file_dir . '/' . $path3;
                }
                if(!empty($row_ins['photo_path4']))
                {
                    $path4 = $row_ins['photo_path4'];
                    $row_ins['photo_path4'] = $file_dir . '/' . $path4;
                }
                //echo "hi".$row_id['owner_id'];
                array_push($row, $row_ins);
                $count++;
            }
            
            $row['no_records'] = $count;
            $row['is_error'] = false;
            $row['message'] = "Fetched books sucessfully";
            $final = $row;
            // for ($i=0; $i< $cnt; $i++)
            // {
            //     $roww = $stmt_id->fetch(PDO::FETCH_ASSOC);
            //     // echo $roww['genre']." and ".in_array($roww['genre'],$commasep);
            //   if($count< $data->no_of_books AND in_array($roww['genre'],$commasep))
            //   {
            //     // print_r($roww);
            //     array_push($row, $roww);
            //     $count++;
            //   }
            // }
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