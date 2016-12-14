<?php
require_once('config.php');
// Highly Secure input handling for SQL Injection
$id = trim(filter_input(INPUT_POST,"StudentID",FILTER_SANITIZE_NUMBER_INT));
$name = trim(filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING));
$age = trim(filter_input(INPUT_POST,"age",FILTER_SANITIZE_NUMBER_INT));
$sex = trim(filter_input(INPUT_POST,"sex",FILTER_SANITIZE_STRING));
$contact = trim(filter_input(INPUT_POST,"contact",FILTER_SANITIZE_STRING));
$address = trim(filter_input(INPUT_POST,"address",FILTER_SANITIZE_STRING));
$country = trim(filter_input(INPUT_POST,"country",FILTER_SANITIZE_STRING));

$sql = "UPDATE student SET
            name=:name,
            age=:age,
            sex=:sex,
            contact=:contact,
            address=:address,
            country=:country
            WHERE StudentID=:id";

$stmt = $pdo->prepare($sql); // Here $stmt is object (Statement Object)

$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':age', $age, PDO::PARAM_INT);
$stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
$stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
$stmt->bindParam(':address', $address, PDO::PARAM_STR);
$stmt->bindParam(':country', $country, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
  echo "Succefully Updated";
} else {
  echo "Fail To Update";
}
?>
