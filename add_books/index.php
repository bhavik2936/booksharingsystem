<?php

function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' ); 

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp ); 

    return $output_file; 
}

require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw);
$final;

session_start();

// email_id
// book_title
// author_name
// publication_name (NULL)
// edition (NULL)
// book_language
// book_description (NULL)
// isbn (NULL)
// address
// area
// city
// price
// no_of_day
// rating
// count_shared
// photo_name1 (path- by nikhil) photo_path1 (image)
// photo_path2 (NULL)
// photo_path3 (NULL)
// photo_path4 (NULL)
// genre (NULL)

if (!empty($_SESSION)) {
    if (!empty($_SESSION['user_email']) && !empty($data)) {
        $stmt=$conn->prepare("SELECT * FROM user_details where email_id = '$data->owner_id' AND activated_user = 1");
        $stmt->execute();
        $row_select = $stmt->fetch(PDO::FETCH_ASSOC);
        $row = $stmt->rowCount();
        $emailErr = "Invalid email";
        $id = 0;    // should not be zero : is set only to resolve error on select query line no 57
        if($row == 1) {
            $id = $row_select['user_id'];
            $emailErr = "Valid email";
        }
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
        try {
            $stmt_select = $conn->prepare("SELECT * FROM book_details WHERE owner_id = '$id' AND book_title = '$data->book_title'");
            $stmt_select->execute();
            $row_select = $stmt_select->fetch(PDO::FETCH_ASSOC);
            $row_select['no_records'] = $stmt_select->rowCount();
            // echo "no_records".$row_select['no_records'];
            if ($row_select['no_records'] == 0) {
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
                }
                else
                {
                    // echo "owner_id ".$id;
                    // echo "owner_id ".$data->book_title;
                    // echo "owner_id ".$data->author_name;
                    // echo "owner_id ".$data->publication_name;
                    // echo "owner_id ".$data->edition;
                    // echo "owner_id ".$data->book_language;
                    // echo "owner_id ".$data->book_description;
                    // echo "owner_id ".$data->isbn;
                    // echo "owner_id ".$data->address;
                    // echo "owner_id ".$data->area;
                    // echo "owner_id ".$data->city;
                    // echo "owner_id ".$data->price;
                    // echo "owner_id ".$data->no_of_day;
                    // echo "owner_id ".$data->photo_path1;
                    // echo "owner_id ".$data->photo_path2;
                    // echo "owner_id ".$data->photo_path3;
                    // echo "owner_id ".$data->photo_path4;
                    // echo "owner_id ".$data->genre;
                    
                    $name=strtolower($data->book_title);
                    $name1=ucwords($name);
                    $stmt_insert = $conn->prepare("INSERT INTO book_details (owner_id, book_title, author_name, publication_name, edition, book_language, book_description, isbn, address, area, city, price, no_of_day, photo_path1, photo_path2, photo_path3, photo_path4, genre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt_insert->bindParam(1, $id);
                    $stmt_insert->bindParam(2, $name1);
                    $stmt_insert->bindParam(3, $data->author_name);
                    $stmt_insert->bindParam(4, $data->publication_name);
                    $stmt_insert->bindParam(5, $data->edition);
                    $stmt_insert->bindParam(6, $data->book_language);
                    $stmt_insert->bindParam(7, $data->book_description);
                    $stmt_insert->bindParam(8, $data->isbn);
                    $stmt_insert->bindParam(9, $data->address);
                    $stmt_insert->bindParam(10, $data->area);
                    $stmt_insert->bindParam(11, $data->city);
                    $stmt_insert->bindParam(12, $data->price);
                    $stmt_insert->bindParam(13, $data->no_of_day);
                    $stmt_insert->bindParam(14, $data->photo_name1);
                    $stmt_insert->bindParam(15, $data->photo_name2);
                    $stmt_insert->bindParam(16, $data->photo_name3);
                    $stmt_insert->bindParam(17, $data->photo_name4);
                    $stmt_insert->bindParam(18, $data->genre);
                    $stmt_insert->execute();
                    // echo $stmt_insert->rowCount();
                    $row_insert['no_records'] = $stmt_insert->rowCount();
                    if ($row_insert['no_records'] != 0) {
                        $query = "SELECT * FROM book_details WHERE owner_id = '$id' AND book_title = '$data->book_title'";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $file_dir='../images/'.$data->owner_id.'/'.$row['book_id'];
                        mkdir($file_dir);
                        
                        $realImage = base64_decode($data->photo_path1);
                        file_put_contents($file_dir . '/' . $data->photo_name1, $realImage);
                        
                        // $realImage = $_FILES[$data->photo_path1]["tmp_name"];
                        // $realImage = file_get_contents($data->photo_path1);
                        // base64_to_jpeg($data->photo_path1, $file_dir . '/' . $data->photo_name1);
                    
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
                        
                        $stmt_wish = $conn->prepare("SELECT * FROM user_wishlist WHERE book_title = ? AND book_author = ? AND in_wishlist = 1");
                        $stmt_wish->bindParam(1, $row['book_title']);
                        $stmt_wish->bindParam(2, $row['author_name']);
                        // $stmt_wish->bindParam(3, $row['$']);
                        $stmt_wish->execute();
                        $row_wish = $stmt_wish->fetch(PDO::FETCH_ASSOC);
                        $row_wish['no_records'] = $stmt_wish->rowCount();
                        
                        // echo $row['book_author'];
                        // echo $row_wish['no_records'];
                        
                        for ($i=0; $i < $row_wish['no_records']; $i++) {
                            $stmt_notif = $conn->prepare("INSERT INTO user_notifications (user_id, book_id, description, notification_type) VALUES (?, ?, ?, ?)");
                            $desc = $row_wish['book_title'] . ' book added in your wishlist is now available';
                            $notification_type = "wishlist";
                            
                            $stmt_notif->bindParam(1, $row_wish['user_id']);
                            $stmt_notif->bindParam(2, $row['book_id']);
                            $stmt_notif->bindParam(3, $desc);
                            $stmt_notif->bindParam(4, $notification_type);
                            
                            $stmt_notif->execute();
                        }
                        
                        $row_insert['is_error'] = false;
                        $row_insert['message'] = "Book Registered Sucessfully";
                        $final = $row_insert;
                    } else {
                        $row_insert['is_error'] = true;
                        $row_insert['message'] = "Couldn't Register, Please try again";
                        $final = $row_insert;
                    }
                }
            } else {
                $final['no_records'] = $row_select['no_records'];
                $final['is_error'] = true;
                $final['message'] = "Book Already Registered";
            }
        } catch(PDOException $e) {
            $final['is_error'] = true;
            $final['message'] = "catch " . $e->getMessage();
        }
    } else {
        $final = array("is_error"=>true, "message"=>"Values not inserted properly");
    }
} else {
    $final = array("is_error"=>true, "message"=>"Please Sign In");
}

echo json_encode($final);

?>