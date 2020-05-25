<?php
include('header.php');
    if(!isset($_SESSION['name'])){
        echo "<script>window.open('login.php','_self')</script>";
    }
    else{
        
?>
</div>
</body>
</html>
<?php 
}
?>