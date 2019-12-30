<?php
// get the q parameter from URL
$id = $_REQUEST["q"];
$vocaDetailsText = "";
$i = 1;

// Connection with Mysql
try {
    require_once('config.php');
    $results = $pdo->prepare(  // $results PDO object statement hoye jay so later you can use $results as object
      "SELECT * FROM vocabulary WHERE id = ?"
    );
    $results->bindParam(1,$id,PDO::PARAM_INT);
    $results->execute();
    $vocaDetails = $results->fetch(PDO::FETCH_ASSOC);

    $vocaDetailsText .= '<form class="editForm" method="post" action="editvoca.php" enctype="multipart/form-data"><input type="hidden" name="id" value="' . $vocaDetails['id'] .                      '"> <input type="hidden" name="word" value="' . $vocaDetails['word'] . '">'
                        .'<div class="editTable"><table class="table table-bordered">';

    $vocaDetailsText .= '<tr>'
                        . '<td width="45%"><b>' . $vocaDetails['word'] . '</b>
                        <a href="https://www.bdword.com/?q='. $vocaDetails['word'] .'" target="_blank"><img src="images/logo/1.png" alt="english-bangla.com" height="25" width="25"></a>
                        <a href="https://translate.google.com/?hl=en#en/bn/'. $vocaDetails['word'] .'" target="_blank"><img src="images/logo/2.png" alt="translate.google.com" height="25" width="25"></a>
                        <a href="https://www.vocabulary.com/dictionary/'. $vocaDetails['word'] .'" target="_blank"><img src="images/logo/5.png" alt="en.oxforddictionaries.com" height="25" width="25"></a>
                        <a href="https://www.google.com/search?q=define+'. $vocaDetails['word'] .'" target="_blank"><img src="images/logo/3.png" alt="google.com" height="25" width="25"></a>
                        <a href="https://www.merriam-webster.com/dictionary/'. $vocaDetails['word'] .'" target="_blank"><img src="images/logo/4.png" alt="merriam-webster.com" height="25" width="25"></a>
                        <a href="https://dictionary.cambridge.org/dictionary/english/'. $vocaDetails['word'] .'" target="_blank"><img src="images/logo/6.png" alt="dictionary.cambridge.org" height="25" width="25"></a>
                        <a href="https://www.google.com/search?tbm=isch&q='. $vocaDetails['word'] .'" target="_blank"><img src="images/logo/7.png" alt="images.google.com" height="25" width="25"></a>
                        <a href="https://www.yourdictionary.com/'. $vocaDetails['word'] .'" target="_blank"><img src="images/logo/8.jpg" alt="workschoolenglish.com" height="25" width="25"></a>
                        </td>'
                        . '<td width="60%" style="padding: 0;"><input type="text" class="form-control" name="meaning" value="'. $vocaDetails['meaning'] .'"></td>'
                        . '</tr>'
                        . '<tr>'
                        . '<td width="40%" style="padding: 0;"><input type="text" class="form-control" name="synonym" value="'. $vocaDetails['synonym'] .'"></td>'
                        . '<td width="60%" style="padding: 0;"><input type="text" class="form-control" name="antonym" value="'. $vocaDetails['antonym'] .'"></td>'
                        . '<tr>'
                        . '<td width="40%">
                        <div class="word-img">
                            <img src="images/' . $vocaDetails['image'] . '" alt="' . $vocaDetails['word'] . '" class="img-responsive" >
                            <div class="top-right">'. $vocaDetails['word'] .'</div>
                        </div>
                        <input type="file" name="fileToUpload" id="fileToUpload" >
                        </td>'
                        . '<td width="60%" style="padding: 0;"><textarea name="sentence" style="width: 100%; border: none; height: auto;" rows="4" class="form-control">' . $vocaDetails['sentence'] . '</textarea> '. $vocaDetails['type'] .' </td>'
                        . '</tr>';

    $vocaDetailsText .= '</table></div>';
    $vocaDetailsText .= '<P>' . date('d / M / Y', $vocaDetails['lastUpdate']) . '</P></form>';
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

// Output "no suggestion" if no hint was found or output correct values
echo "$vocaDetailsText";
?>
