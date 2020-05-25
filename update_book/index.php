<?php

// PHP code to update the Book details 

require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw);
$final;

session_start();

// book_id
// owner_id
// book_title
// author_name
// publication_name     (Can be NULL)
// edition              (Can be NULL)
// book_language
// book_description     (Can be NULL)
// isbn                 (Can be NULL)
// address
// city
// price
// no_of_days
// rating               (Can be NULL)
// count_shared
// photo_path1
// photo_path2          (Can be NULL)
// photo_path3          (Can be NULL)
// photo_path4          (Can be NULL)
// genre
// is_available
// is_approved          (Can be NULL)

if(!empty($_SESSION)) 
{
    if (!empty($_SESSION['user_email']) && !empty($data)) 
    {
        try 
        {
            // echo $_SESSION['user_email'];
            $stmt_select = $conn->prepare("SELECT * FROM book_details WHERE book_id = '$data->book_id'");
            $stmt_select->bindParam(1, $_SESSION['user_email']);
            $stmt_select->execute();
            
            $row_select = $stmt_select->fetch(PDO::FETCH_ASSOC);
            $temp =  $_SESSION['user_email'];
            
            $roww= $stmt_select->rowCount();
            
            /*
            $booktitleErr = "Valid book title";
            $authornameErr = "Valid author name";
            $editionErr = "Valid edition";
            $booklanguageErr = "Valid book language";
            $isbnErr = "Valid isbn";
            $addressErr = "Valid address";
            $areaErr = "Valid area";
            $cityErr = "Valid city";
            $priceErr = "Valid price";
            $noofdayErr = "Valid number of day";
            $photopath1Err = "Valid photo path1";
            
            if (!filter_var($data->owner_id, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email";
                }
                
                if (empty($data->book_title)){
                    $booktitleErr= "Invalid book title";
                }
    
                if (!preg_match("/^[a-zA-Z ]*$/",$data->author_name) || (empty($data->author_name))) {
                  $fnameErr = "Invalid author name";
                }
                
                if (!empty($data->edition)){
                    if(!is_numeric($data->edition)){
                        $editionErr= "Invalid edition";
                    }
                }
                
                $number = preg_match('@[0-9]@', $data->book_language);
                $specialChars = preg_match('@[^\w]@', $data->book_language);
                if($number || $specialChars){
                     $booklanguageErr= "Invalid book language";
                }
                
                if(!empty($data->isbn)){
                    if(!is_numeric($data->isbn) || (strlen($data->isbn)!=13 && strlen($data->isbn)!=10)) {
                        $isbnErr = "Invalid isbn";
                    }
                }
                
                if (empty($data->address)){
                    $addressErr= "Invalid address";
                }
                
                if (empty($data->area)){
                    $areaErr= "Invalid area";
                }
                
                if (empty($data->city)){
                    $cityErr= "Invalid city";
                }
                
                if(!is_numeric($data->price) || empty($data->price)) {
                    $priceErr = "Invalid price";
                }
                
                if(!empty($data->no_of_day)){
                    if(!is_numeric($data->no_of_day)) {
                        $noofdayErr = "Invalid no of day";
                    }
                }
                else
                {
                    $data->no_of_day=7;
                }
                
                if (empty($data->photo_path1)){
                    $photopath1Err= "Invalid photo path1";
                }
                
                if($emailErr == "Invalid email" || $booktitleErr == "Invalid book title" || $authornameErr == "Invalid author name" || $editionErr == "Invalid edition" || $booklanguageErr == "Invalid book language" || $isbnErr == "Invalid isbn" || $addressErr == "Invalid address" || $areaErr == "Invalid area" || $cityErr == "Invalid city" || $priceErr == "Invalid price" || $noofdayErr == "Invalid no of day" || $photopath1Err == "Invalid photo path1")
                {
                    $final['is_error']=true;
                    if($emailErr == "Invalid email"){
                        $final['message']="Invalid email";
                    }
                    else if($booktitleErr == "Invalid book title"){
                        $final['message']="Invalid book title";
                    }
                    else if($authornameErr == "Invalid author name"){
                        $final['message']="Invalid author name";
                    }
                    else if($editionErr == "Invalid editon"){
                        $final['message']="Invalid editon";
                    }
                    else if($booklanguageErr == "Invalid book language"){
                        $final['message']="Invalid book language";
                    }
                    else if($isbnErr == "Invalid isbn"){
                        $final['message']="Invalid isbn";
                    }
                    else if($addressErr == "Invalid address"){
                        $final['message']="Invalid address";
                    }
                    else if($areaErr == "Invalid area"){
                        $final['message']="Invalid area";
                    }
                    else if($cityErr == "Invalid city"){
                        $final['message']="Invalid city";
                    }
                    else if($priceErr == "Invalid price"){
                        $final['message']="Invalid price";
                    }
                    else if($noofdayErr == "Invalid no of day"){
                        $final['message']="Invalid no of day";
                    }
                    else if($photopath1Err == "Invalid photo path1"){
                        $final['message']="No photo uploaded";
                    }
            
            
            */
            
            if ($roww!= 0) 
            {
                if(empty($data->book_title) || empty($data->author_name) || empty($data->book_language) || empty($data->address) || empty($data->area) || empty($data->city) || empty($data->price) || empty($data->no_of_day)) 
                {
                    $final = array("is_error"=>true, "message"=>"Values may not be Inserted properly !");
                } 
                else
                {
                    echo $row_select['owner_id'];
                    
                    $stmt_update = $conn->prepare("UPDATE book_details SET book_title = ?, author_name = ?, publication_name = ?, edition = ?, book_language = ?, book_description = ?, isbn = ?, address = ?, area = ?, city = ?, price = ?, no_of_day = ?, photo_path1 = ?, photo_path2 = ?, photo_path3 = ?, photo_path4 = ?, genre = ? WHERE book_id = '$data->book_id'");
                    // $stmt_update = $conn->prepare("UPDATE user_details SET password = ?, first_name = ?, last_name = ?, mobile_num = ?, address = ?, area = ?, city = ? WHERE user_id = ?");
                    $stmt_update->bindParam(1, $data->book_title);
                    $stmt_update->bindParam(2, $data->author_name);
                    $stmt_update->bindParam(3, $data->publication_name);
                    $stmt_update->bindParam(4, $data->edition);
                    $stmt_update->bindParam(5, $data->book_language);
                    $stmt_update->bindParam(6, $data->book_description);
                    $stmt_update->bindParam(7, $data->isbn);
                    $stmt_update->bindParam(8, $data->address);
                    $stmt_update->bindParam(9, $data->area);
                    $stmt_update->bindParam(10, $data->city);
                    $stmt_update->bindParam(11, $data->price);
                    $stmt_update->bindParam(12, $data->no_of_day);
                    $stmt_update->bindParam(13, $data->photo_name1);
                    $stmt_update->bindParam(14, $data->photo_name2);
                    $stmt_update->bindParam(15, $data->photo_name3);
                    $stmt_update->bindParam(16, $data->photo_name4);
                    $stmt_update->bindParam(17, $data->genre);
                    
                    
                    $stmt_update->execute();
                    
                    $row_update = $stmt_update->fetch(PDO::FETCH_ASSOC);
                    
                    $file_dir='../images/' . $temp . '/' . $data->book_id;
                    
                    if(!empty($data->photo_path1))
                    {
                        $realImage1 = base64_decode($data->photo_path1);
                        file_put_contents($file_dir.'/'.$data->photo_name1, $realImage1);
                    }
                    if(!empty($data->photo_path2))
                    {
                        $realImage1 = base64_decode($data->photo_path2);
                        file_put_contents($file_dir.'/'.$data->photo_name2, $realImage1);
                    }
                    if(!empty($data->photo_path3))
                    {
                        $realImage2 = base64_decode($data->photo_path3);
                        file_put_contents($file_dir.'/'.$data->photo_name3, $realImage2);
                    }
                    if(!empty($data->photo_path4))
                    {
                        $realImage3 = base64_decode($data->photo_path4);
                        file_put_contents($file_dir.'/'.$data->photo_name4, $realImage3);
                    }
                    
                    $row_update['is_error'] = false;
                    $row_update['message'] = "Book Details updated successfully";
                    $final = $row_update;
                }
                // else 
                // {
                //     $final = array("is_error"=>true, "message"=>"Wrong credentials");
                // }
            } 
            else
            {
                $final = array("is_error"=>true, "message"=>"User not registered");
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
