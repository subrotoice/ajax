<?php
// get the q parameter from URL
$q = $_REQUEST["q"];
$studentName = "";
$i =5;

// Connection with Mysql
try {
    require_once('config.php');
    $results = $pdo->query("SELECT studentID,name FROM student");
    $studentsName = $results->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($studentsName);
    // lookup all hints from array if $q is different from ""
    if ($q !== "") {
       $q = strtolower($q);
       $len=strlen($q);
       $i = 1;
       foreach($studentsName as $name) {
           if (stristr($q, substr($name['name'], 0, $len))) {
               if ($studentName === "") {
                   $studentName = '<a href="" id="studentDetails" data-studentId="'. $name['studentID'] .'" class="list-group-item">'. $name['name'] .'</a> ';
               } else {
                   $studentName .= '<a href="" id="studentDetails" data-studentId="'. $name['studentID'] .'" class="list-group-item">'. $name['name'] .'</a>';
               }
               $i++;
           }
           if ($i >= 10) {
             break;
           }
       }
    }
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

// Output "no suggestion" if no hint was found or output correct values
echo $studentName === "" ? "no suggestion" : $studentName;
?>
