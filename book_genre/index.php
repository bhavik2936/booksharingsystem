<?php

// PHP code to Send all the possible genre of the Books to the User for genre selection

require "../DBConnection.php";
header("Content-Type: application/json; charset=UTF-8");

    $query = "SELECT genre_name FROM book_genre";
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
        $name=$row['genre_name'];
        $genre='genre'.$i;
        $final[$genre]=$row['genre_name'];
    }
    echo json_encode($final);
    
    
?>