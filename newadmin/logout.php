<?php
    session_start();
    if(isset($_SESSION['name'])){
        session_destroy();    
        echo "<script>window.open('login.php','_self')</script>";
    }
    else{
        echo "<script>window.open('login.php','_self')</script>";
    }
?>