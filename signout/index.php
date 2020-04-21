<?php

// PHP code to Perform SignOut operation on the User

    session_start();
    unset($_SESSION["email_id"]);
    //unset($_SESSION["password"]);
   
    $final = array("is_error"=>true, "message"=>" You have Successfully Logged Out !");
    echo json_encode($final);
   
    // echo 'You have cleaned session';
    // header('Refresh: 2; URL = login.php');
?>