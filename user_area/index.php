<?php

// PHP code to Fetch the Name of the Areas from Database and send it as JSON to Front-End 

require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

    $query = "SELECT area_name FROM user_area ORDER BY area_name ASC";
    $get = $conn->prepare($query);
    $get->execute();
    $count=$get->rowCount();
    $final;
    
    // echo "\n$query";
    // echo "\n$count";
    
    $final['count']=$count;
    
    for($i=0; $i<$count; $i++)
    {
        $row = $get->fetch(PDO::FETCH_ASSOC);
        $name=$row['area_name'];
        $area='area'.$i;
        $final[$area]=$row['area_name'];
    }
    echo json_encode($final);
?>