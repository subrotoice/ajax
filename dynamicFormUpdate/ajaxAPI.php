<?php
session_start();
include_once('../lib.php');
include_once('../conexion.php');

// HTTP/Ajax request handel
// Insert
if (isset($_POST["email"])) { 
    $userId = $_POST['userId'];
    $email = $_POST['email'];
    $secretKey = $_POST['secretKey'];
    $clientId = $_POST['clientId'];
    $clientSecret = $_POST['clientSecret'];
    $refreshToken = $_POST['refresh_token'];
    $messages = $_POST['messages'];

    // Insert or Update
    $sql = "SELECT * FROM calenderapi WHERE userid=$userId";
    $result = mysql_query($sql, $conexion);
    $num_rows = mysql_num_rows($result);
    if($num_rows<=0) {
      $sql = "INSERT INTO calenderapi (userid, email, secretkey, clientid, clientsecret, refreshtoken, message) VALUES ( '$userId', '$email', '$secretKey', '$clientId', '$clientSecret', '$refreshToken', '$messages')";
    } else {
      $sql = "UPDATE calenderapi set email='$email', secretkey='$secretKey', clientid='$clientId', clientsecret='$clientSecret', refreshtoken='$refreshToken', message='$messages' WHERE userid=$userId";
    }
    $result = mysql_query($sql , $conexion);
    if($result) {
      if($num_rows<=0) {
        echo json_encode( array('status' => 'insert', 'message'=> 'Inserted') );
      } else {
        echo json_encode( array('status' => 'update', 'message'=> 'Updated') );
      }
    } else {
        echo json_encode( array('status' => $result, 'message'=> 'Not Inserted') );
    }
}

// Show
// $_GET["searchValue"]=1; // It is for direct access from url
if (isset($_GET["searchValue"])) { 
    $searchValue = $_GET["searchValue"];
    $sql = "SELECT * FROM contact WHERE id=$searchValue";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo json_encode($row);
      }
    } else {
      echo "0 results";
    }
}
