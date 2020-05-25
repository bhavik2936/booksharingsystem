<?php

    session_start();
    if(!isset($_SESSION["name"]))
    {
        header("Location: index.php");
    }
?>
<html>
<body>
<p>hii</p>
<body>
</html>