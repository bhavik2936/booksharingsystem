<?php

// PHP code to Initiate the Session 

    session_start();
    header("Content-Type: application/json; charset=UTF-8");

    if(!empty($_SESSION)) 
    {
        if (!empty($_SESSION['user_email'])) 
        {
            $final = array("is_error"=>false, "message"=>"You're successfully logged in");
        }
    } 
    else 
    {
        $final = array("is_error"=>true, "message"=>"Please Sign In");
        // echo "hi";
    }
    
    echo json_encode($final);
    
?>