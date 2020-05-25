<?php
echo "hi";
    if (mail($data->email_id, "Forgot Password", $msg, "From book sharing system")) {
        $final['is_error'] = false;
        $final['message'] = "A New password is sent to your Email Address !";
    } else {
        $final['is_error'] = true;
        $final['message'] = "somehow we counldn't send you Email !";
    }
?>