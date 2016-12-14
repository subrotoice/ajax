<?php
require_once('config.php');
if (isset($_GET['lastten'])) {
  $i = 1;
  $returnReportText = '<div class="panel panel-success">'
                    . '<div class="list-group">'
                    . '<a href="" class="list-group-item active">Latest Reports</a>';
  $results = $pdo->query("SELECT name, reportTime FROM employee ORDER BY id DESC LIMIT 7");
  $employReports = $results->fetchAll(PDO::FETCH_ASSOC);
  // var_dump($employReports);
  foreach($employReports as $employReport) {
         $returnReportText .= '<a href="" class="list-group-item">'
                             . $i
                             . '. '
                             . $employReport['name'] . ' repoted @ '
                             . date('l - h:i:s A', $employReport['reportTime'])
                             .'</a>';
         $i++;
  }
  $returnReportText .= '</div></div>';
  echo $returnReportText;
} else {
  $date = new DateTime();
  $reportTime = $date->getTimestamp();

  // Highly Secure input handling for SQL Injection
  $name = trim(filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING));

  $sql = "INSERT INTO employee (name, reportTime) VALUES ('$name', '$reportTime')";

  if ($pdo->query($sql)) {
    $output = '<div class="alert alert-dismissible alert-warning">'
            . '<button type="button" class="close" data-dismiss="alert">&times;</button>'
            . '<h4>' . $name . ' @ '. date('l - h:i:s A', $reportTime) .' </h4>'
            . '</div>';
    echo $output;
  } else {
    echo "Failed To Insert.";
  }
}
