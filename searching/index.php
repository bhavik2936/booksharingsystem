<?php

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
            $name= strtolower($data->book_title);
            $name1= ucwords($name);
            // echo $name1;
            $query="SELECT DISTINCT (book_id) FROM book_details WHERE book_title= '$name1'";
            $stmt=$conn->prepare($query);
            $stmt->execute();
            $counter=$stmt->rowCount();
            for($i=0; $i<$counter; $i++)
            {
                    $roww= $stmt->fetch(PDO::FETCH_ASSOC);
                    $abc=$roww['book_id'];
                    $query="SELECT * FROM book_details WHERE book_id = '$abc'";
                    $stmt=$conn->prepare($query);
                    $stmt->execute();
                    $row_ins= $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    $bid=$row_ins['owner_id'];
                
                    $stmt_mail = $conn->prepare("SELECT * FROM user_details WHERE user_id = ?");
                    $stmt_mail->bindParam(1, $bid);
                    $stmt_mail->execute();
                    $row_mail = $stmt_mail->fetch(PDO::FETCH_ASSOC);
                    
                    $file_dir='https://booksharingsystem.000webhostapp.com/images/' . $row_mail['email_id'] . '/' . $row_ins['book_id'];
                    
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
                    
                    array_push($row, $row_ins);
            }
            $commasep=explode(" ",$name1);
            $cnt= sizeof($commasep);
            $query="SELECT DISTINCT (book_id) FROM book_details WHERE ";
            // print_r($commasep);
            $query=$query."book_title like '%$commasep[0]%'";
            for($i=1; $i<$cnt; $i++)
            {
                $query=$query." OR book_title like '%$commasep[$i]%'";
            }
            // echo $query;
            $stmt_id = $conn->prepare($query);
            $stmt_id->execute();
            $count=0;
            
            for ($i=0; $i< $stmt_id->rowCount(); $i++)
            {
                $row_id = $stmt_id->fetch(PDO::FETCH_ASSOC);
                //echo "hi".$row_id['owner_id'];
                if(!in_array($row_id['book_id'], $row)){
                    
                    $abc=$row_id['book_id'];
                    $query="SELECT * FROM book_details WHERE book_id = '$abc'";
                    $stmt=$conn->prepare($query);
                    $stmt->execute();
                    $row_inse= $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    $bid=$row_inse['owner_id'];
                
                    $stmt_mail = $conn->prepare("SELECT * FROM user_details WHERE user_id = ?");
                    $stmt_mail->bindParam(1, $bid);
                    $stmt_mail->execute();
                    $row_mail = $stmt_mail->fetch(PDO::FETCH_ASSOC);
                    
                    $file_dir='https://booksharingsystem.000webhostapp.com/images/' . $row_mail['email_id'] . '/' . $row_inse['book_id'];
                    
                    if(!empty($row_inse['photo_path1']))
                    {
                        $path1 = $row_inse['photo_path1'];
                        // echo $path1;
                        // echo $file_dir;
                        $row_inse['photo_path1'] = $file_dir . '/' . $path1;
                    }
                    if(!empty($row_inse['photo_path2']))
                    {
                        $path2 = $row_inse['photo_path2'];
                        $row_inse['photo_path2'] = $file_dir . '/' . $path2;
                    }
                    if(!empty($row_inse['photo_path3']))
                    {
                        $path3 = $row_inse['photo_path3'];
                        $row_inse['photo_path3'] = $file_dir . '/' . $path3;
                    }
                    if(!empty($row_inse['photo_path4']))
                    {
                        $path4 = $row_inse['photo_path4'];
                        $row_inse['photo_path4'] = $file_dir . '/' . $path4;
                    }
                    
                    array_push($row, $row_inse);
                    
                    //array_push($row, $row_id);
                    $count++;
                }
            }
            $count=sizeof($row);
                        // $counter=$stmt->rowCount();
            // for($i=0; $i<$counter; $i++)
            // {
            //     $row1 = $stmt->fetch(PDO::FETCH_ASSOC);
            //     array_push($final, $row1);
            // }
            $final = $row;
            $final['no_records'] = $count;
            $final['is_error'] = false;
            $final['message'] = "Fetched books sucessfully";
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