<?php
// get the q parameter from URL
$q = $_REQUEST["q"];
$studentName = "";
$i =5;

// Connection with Mysql
try {
    require_once('config.php');
    $results = $pdo->query("SELECT id, word, lastUpdate, type FROM vocabulary order by lastUpdate asc, id asc");
    $vocabularies = $results->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($studentsName);
    // lookup all hints from array if $q is different from ""
    if ($q !== "") {
       $q = strtolower($q);
       $len=strlen($q);
       $i = 1;
       foreach($vocabularies as $vocabulary) {
           if (stristr($q, substr($vocabulary['word'], 0, $len))) {
            if($vocabulary['lastUpdate']>0) {
               if ($studentName === "") {
                   $studentName = '<a href="" id="studentDetails" data-studentId="'. $vocabulary['id'] .'" class="btna btn-success">'. $vocabulary['word'] .'</a> ';
               } else {
                   $studentName .= '<a href="" id="studentDetails" data-studentId="'. $vocabulary['id'] .'" class="btna btn-success">'. $vocabulary['word'] .'</a>';
               }
               $i++;
            } else {
                if ($studentName === "") {
                    $studentName = '<a href="" id="studentDetails" data-studentId="'. $vocabulary['id'] .'" class="btna btn-outline-success">'. $vocabulary['word'] .'</a> ';
                } else {
                    $studentName .= '<a href="" id="studentDetails" data-studentId="'. $vocabulary['id'] .'" class="btna btn-outline-success">'. $vocabulary['word'] .'</a>';
                }
                $i++;
            }
           } // End
           if ($i >= 100) {
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
