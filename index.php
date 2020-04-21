<?php
// require "./DBConnection.php";
$sql = "SELECT * FROM user_details";

// $result = $conn->query($sql);

// if (mysqli_num_rows($result) > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {
//         echo "id: " . $row["user_id"]. " - Email: " . $row["email_id"]. " - Password: " . $row["password"]. "<br>";
//     }
// } else {
//     echo "0 results";
// }

$myObj = array("Site Name"=>"Book Sharing System");

$myJSON = json_encode($myObj);

echo $myJSON;

// $conn->close();
?>