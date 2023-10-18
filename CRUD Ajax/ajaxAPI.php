<?php
// MySqli Connection
$host = "localhost";
$username = "root";
$password = "";
$database = "karkhana";
$conn = new mysqli($host, $username, $password, $database);

// HTTP/Ajax request handel
// Insert
if (isset($_POST["name"])) { 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sql = "INSERT INTO contact (name, email, msg) VALUES ( '$name', '$email', 'my test msg')";
    $result = $conn->query($sql);
    if($result){
        echo json_encode( array('status' => $result, 'message'=> $sql) );
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
