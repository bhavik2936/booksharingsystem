<?php

// PHP code to validate the Sign-Up Procedure

require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw);
$final;

// echo $data->email_id;

if ($data != null) 
{
    $emailErr = "Valid Email Format";
    $passwordErr = "Valid Password";
    $fnameErr = "Valid First Name";
    $lnameErr = "Valid Last Name";
    $numberErr = "Valid Mobile Number";
    $addressErr = "Valid Address";
    $areaErr = "Valid Area";
    $cityErr = "Valid City";
    
    try 
    {
        $stmt_select = $conn->prepare("SELECT * FROM user_details WHERE email_id = '$data->email_id' AND activated_user = 1");
        $stmt_select->execute();
        $row_select = $stmt_select->fetch(PDO::FETCH_ASSOC);
        
        unset($row_select['password']);
        $row_select['no_records'] = $stmt_select->rowCount();
        
        if ($row_select['no_records'] == 0) 
        {
            if (!filter_var($data->email_id, FILTER_VALIDATE_EMAIL)) 
            {
                $emailErr = "Invalid Email";
            }
            
            if(strlen(trim($data->password)) < 8) 
            {
                $passwordErr = "Invalid Password";
            }
            
            if (!preg_match("/^[a-zA-Z ]*$/",$data->first_name) || (empty($data->first_name))) 
            {
              $fnameErr = "Invalid First Name";
            }
            if(!empty($data->last_name))
            {
                if (!preg_match("/^[a-zA-Z ]*$/",$data->last_name)) 
                {
                  $lnameErr = "Invalid Last Name";
                }
            }
            
            $uppercase = preg_match('@[A-Z]@', $data->mobile_num);
            $lowercase = preg_match('@[a-z]@', $data->mobile_num);
            $specialChars = preg_match('@[^\w]@', $data->mobile_num);
            
            if($uppercase || $lowercase || $specialChars || strlen($data->mobile_num)!=10) 
            {
                $numberErr = "Invalid Mobile Number";
            }
            
            if (empty($data->address))
            {
                $addressErr= "Invalid Address";
            }
            
            if (empty($data->area))
            {
                $areaErr= "Invalid Area";
            }
            
            if (empty($data->city))
            {
                $cityErr= "Invalid City";
            }
            
            if($emailErr == "Invalid Email" || $passwordErr == "Invalid Password" || $fnameErr == "Invalid First Name" || $lnameErr == "Invalid Last Name" || $numberErr == "Invalid Mobile Number" || $addressErr == "Invalid Address" || $areaErr == "Invalid Area" || $cityErr == "Invalid City")
            {
                $final['is_error']=true;
                $flag = 0; 
                if($emailErr == "Invalid Email")
                {
                    $final['message']="Invalid Email";
                }
                else if($passwordErr == "Invalid Password")
                {
                    $final['message']="Invalid Password";
                }
                else if($fnameErr == "Invalid First name")
                {
                    $final['message']="Invalid First name";
                }
                else if($lnameErr == "Invalid Last name")
                {
                    $final['message']="Invalid Last name";
                }
                else if($numberErr == "Invalid Mobile Number")
                {
                    $final['message']="Invalid Mobile Number";
                }
                else if($addressErr == "Invalid Address")
                {
                    $final['message']="Invalid Address";
                }
                else if($areaErr == "Invalid Area")
                {
                    $final['message']="Invalid Area";
                }
                else if($cityErr == "Invalid City")
                {
                    $final['message']="Invalid City";
                }
            }
            else
            {
                // echo "dp".$data->display_picture;
                $stmt_insert = $conn->prepare("INSERT INTO user_details (email_id, password, first_name, last_name, mobile_num, address, area, city, display_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                
                $stmt_insert->bindParam(1, $data->email_id);
                $stmt_insert->bindParam(2, $data->password);
                $stmt_insert->bindParam(3, $data->first_name);
                $stmt_insert->bindParam(4, $data->last_name);
                $stmt_insert->bindParam(5, $data->mobile_num);
                $stmt_insert->bindParam(6, $data->address);
                $stmt_insert->bindParam(7, $data->area);
                $stmt_insert->bindParam(8, $data->city);
                $stmt_insert->bindParam(9, $data->photo_name);
                $stmt_insert->execute();
                
                // echo $stmt_insert->rowCount();
                
                $row_insert['no_records'] = $stmt_insert->rowCount();
                if ($row_insert['no_records'] != 0) 
                {
                    $file_dir='../images/'.$data->email_id;
                    mkdir($file_dir);
                    if(!empty($display_picture))
                    {
                        $realImage = base64_decode($data->display_picture);
                        file_put_contents($file_dir.'/'.$data->photo_name, $realimage);
                    }
                    $row_insert['is_error'] = false;
                    $row_insert['message'] = "User Registered Sucessfully ! ";
                    $final = $row_insert;
                } 
                else 
                {
                    $row_insert['is_error'] = true;
                    $row_insert['message'] = "Register Failed, Please try again ! ";
                    $final = $row_insert;
                }
            }
        } 
        else 
        {
            $final['no_records'] = $row_select['no_records'];
            $final['is_error'] = true;
            $final['message'] = "User Already Registered ! ";
        }
    } 
    catch(PDOException $e) 
    {
        $final['is_error'] = true;
        $final['message'] = $e->getMessage();
    }
}
else 
{
    $final['is_error'] = true; 
    $final['message'] = "Values might not Inserted Properly !";
}

echo json_encode($final);

?>