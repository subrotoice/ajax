<?php
$letter = 'g';
if(isset($_GET["q"])){
  $letter = $_GET["q"];
}
$i=1;
$tempOld = 0;
require_once('config.php');
try {
    // $sql = 'SELECT * FROM vocabulary WHERE type="PSC" and lastUpdate>0 and id!=400 limit 100';
    $sql = 'SELECT * FROM vocabulary WHERE lastUpdate>0 and id!=400 and word like"'. $letter .'%" ORDER BY word DESC limit 100';
    $q = $pdo->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
<?php while ($row = $q->fetch()): ?>
<?php $tempCurrent = $row['lastUpdate'];
      $timeNeeded = $tempCurrent - $tempOld;
 ?>
    <div class="row">
      <div class="col-4 p-0 m-0 b-r">
        <div class="word-img">
          <img src="images/<?php echo $row['image']; ?>" alt="Apathy" class="img-responsive">
          <div class="top-left"><?php echo $i . ". "; ?><?php echo $row['word']; ?></div>
        </div>
      </div>
      <div class="col-3 b-r">
        <div class="sentence">
          <p><?php echo nl2br($row['sentence']); ?></p>
          <div class="bottom-right"><i><?php echo $i++ . ". (" . $row['type'] . ")"; ?></i></div>
        </div>
      </div>
      <div class="col-3 b-r">
        <ul>
          <li><b>S: </b><?php echo $row['synonym']; ?></li>
          <li><b>A: </b><?php echo $row['antonym']; ?></li>
        </ul>
      </div>
      <div class="col-2">
        <?php echo $row['word']; ?> - <?php echo $row['meaning']; ?>
      </div>
    </div>
    <?php $tempOld = $row['lastUpdate'] ?>
<?php endwhile; ?>
