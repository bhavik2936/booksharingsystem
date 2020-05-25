<?php
    session_start();
    // if($_SESSION['name']=="user")
    //     echo "hello";
unset($_SESSION['name']);
?>
                                   <!--<script>alert($_SESSION['name']) </script>-->
<?php

    // if($_SESSION['name']=="user")
    //     echo "hello";
    session_unset();
    session_destroy();
    ?>
    <script>    window.location.href="index.php"; </script>