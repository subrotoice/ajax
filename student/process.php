<?php
if (isset($_GET['todo']) && $_GET['todo'] == 'delete') { // Request for Delete Code
  $data = array();
  // Highly Secure input handling for SQL Injection
  $id = trim(filter_input(INPUT_GET,"id",FILTER_SANITIZE_NUMBER_INT));

  require_once('config.php');
  $sql = "DELETE FROM student WHERE StudentID=:id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);

  if ( $stmt->execute() ) {
    $data['success'] = $id . " Deleted";
  } else {
    $data['fail'] = "Fail To Delete";
  }
  echo json_encode($data);
  exit;
} else { // Request for Updated Code
  // Highly Secure input handling for SQL Injection
  $name = trim(filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING));
  $age = trim(filter_input(INPUT_POST,"age",FILTER_SANITIZE_NUMBER_INT));
  $sex = trim(filter_input(INPUT_POST,"sex",FILTER_SANITIZE_STRING));
  $contact = trim(filter_input(INPUT_POST,"contact",FILTER_SANITIZE_STRING));
  $address = trim(filter_input(INPUT_POST,"address",FILTER_SANITIZE_STRING));
  $country = trim(filter_input(INPUT_POST,"country",FILTER_SANITIZE_STRING));

  if ($name == "" || $country == "") {
      $error_message = "Please fill in the required fields: Name, Country";
  }

  require_once('config.php');
  $sql = "INSERT INTO student(name,
              age,
              sex,
              contact,
              address,
              country) VALUES (
              :name,
              :age,
              :sex,
              :contact,
              :address,
              :country)";

  $stmt = $pdo->prepare($sql);

  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':age', $age, PDO::PARAM_INT);
  $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
  // use PARAM_STR although a number
  $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
  $stmt->bindParam(':address', $address, PDO::PARAM_STR);
  $stmt->bindParam(':country', $country, PDO::PARAM_STR);

  if ($stmt->execute()) {
    $newId = $pdo->lastInsertId();
    $returnText = '<div class="alert alert-dismissible alert-success" style="margin-top:10px;">' . $name . " Inserted Succefully With ID " . $newId . '</div>';
    echo $returnText;
  } else {
    echo "Failed To Insert.";
  }
}
