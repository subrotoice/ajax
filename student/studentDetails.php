<?php
// get the q parameter from URL
$id = $_REQUEST["q"];
$i = 1;

// Connection with Mysql
try {
    require_once('config.php');
    $results = $pdo->prepare(  // $results PDO object statement hoye jay so later you can use $results as object
      "SELECT * FROM student WHERE studentID = ?"
    );
    $results->bindParam(1,$id,PDO::PARAM_INT);
    $results->execute();
    $studentsDetails = $results->fetch(PDO::FETCH_ASSOC); // $studentsDetails and $studentDetails are different
    $studentDetailsText = '<h3>'. $studentsDetails['name'] .' Details '
                        . '<a href="" data-edit-studentid="'. $id .'" class="btn btn-warning edit">Edit</a> '
                        . '<a href="process.php?todo=delete&id=' . $id . '" class="btn btn-danger delete">Delete</a>'
                        . '<div class="statusInfo alert alert-dismissible alert-success"></div>'
                        . '</h3>';
    $studentDetailsText .= '<form class="editForm" method="post" action="editStudent.php">'
                          .'<div class="editTable"><table class="table table-bordered table-hover">';
    foreach($studentsDetails as $key => $studentDetails) {
      $studentDetailsText .= '<tr>'
                        . '<td width="10%">' . $i++ . '</td>'
                        . '<td width="20%">' . ucwords($key) . '</td>'
                        . '<td width="70%" style="padding: 0;"><input type="text" class="form-control" name="' . $key . '" value="'. $studentDetails .'"></td>'
                        . '</tr>';

    }
    $studentDetailsText .= '</table></div></form>';
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

// Output "no suggestion" if no hint was found or output correct values
echo $studentDetailsText;
?>
