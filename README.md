# AJAX Code. Here 3 Project Included

Demos are here <br />
http://edeves.com/ajax/student <br />
http://edeves.com/ajax/employee <br />
http://edeves.com/ajax/contact <br />

seba.edeves.com <br />
food.edeves.com <br />
voca.edeves.com <br />

```
// PHP feedback
  echo json_encode( array('amount' => $amount, 'message'=> $htmlMessage) ); // Simple
  
  /* Condition Select queries return a resultset */
  if (   $regex==0 ) {
      echo json_encode( array('status' => 'wrongFormat', 'message'=> 'Wrong Format User Exist') );
  }
  elseif ( $result->num_rows ) {<br />
      echo json_encode( array('status' => 'exist', 'message'=> 'User Exist') );<br />
  } else {
    echo json_encode( array('status' => 'notexist', 'message'=> 'User Not Exist') );
  }
  
// Js File
$.get( url, function( data ) {
    var objData = jQuery.parseJSON( data ); // jQuery after feedback come
    var status= objData.status; // to get value
  });
});
```
# File Dynamic Upload (Ajax)
<form id="form1" action="ajaxload.php" method="post" enctype="multipart/form-data">
    <div class="row form-group h-50">
      <div class="col-md-3"><input id="uploadImage" class="fileupload" type="file" accept="image/*" name="ecommerceLogo" /></div>
      <input type="hidden" name="presentor_id" value="<?= $usuario?>">
      <div class="col-md-2"><input class="btn btn-success" type="submit" value="Upload Logo"></div>
      <div class="col-md-7">
        <?php
          $target_dir = "ecommerceLogo/";
          $logoFileNameJpg = $target_dir . $usuario . '.jpg';
          $logoFileNamePng = $target_dir . $usuario . '.png'; 
          $finalFileName = file_exists($logoFileNameJpg)?$logoFileNameJpg:$logoFileNamePng;
          // var_dump($finalFileName);
        ?>
          <a href="<?=$finalFileName?>" target="_blank" rel="noopener noreferrer">
            <img width="50px" src="<?=$finalFileName?>" alt="">
          </a>
        </div>
    </div>
</form>
<div class="saveRateInfo"></div>
// Js || E-Commerce Logo Upload
$( document ).on( 'submit', 'form#form1', function(evt) {
  evt.preventDefault();
  $.ajax({
    url: 'ajaxload.php',
    type: 'POST',
    data:  new FormData(this),
    contentType: false,
          cache: false,
    processData:false
  })
  .done(function(data){
    var objData = jQuery.parseJSON( data );
    // alert(objData.message);
    message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
    $( ".saveRateInfo" ).html( message );
  })
  .fail(function(){
    alert('Ajax Submit Failed ...');
  });
});
// PHP
if(isset($_POST['presentor_id'])) {
  $presentor_id = $_POST['presentor_id'];
  // echo $_FILES["ecommerceLogo"]["name"];
  $target_dir = "ecommerceLogo/";
  $logoFileNameJpg = $target_dir . $presentor_id . '.jpg';
  $logoFileNamePng = $target_dir . $presentor_id . '.png';
  $target_file = $target_dir . basename($_FILES["ecommerceLogo"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $finalUploadFile = $word . '.' . $imageFileType;

  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["ecommerceLogo"]["tmp_name"]);
      if($check !== false) {
          $message = "File is an image - " . $check["mime"] . ".";
          echo json_encode( array('rateOrPromo' => $target_file, 'message'=> $message) );
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }
  }
  // Check if file already exists
  if (file_exists($logoFileNameJpg)) {
      unlink($logoFileNameJpg);
  }
  if (file_exists($logoFileNamePng)) {
      unlink($logoFileNamePng);
  }
  // Check file size
  if ($_FILES["ecommerceLogo"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
      $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      echo json_encode( array('rateOrPromo' => $target_file, 'message'=> $message) );
      $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      $message = "Sorry, your file was not uploaded.";
      echo json_encode( array('rateOrPromo' => $target_file, 'message'=> $message) );
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["ecommerceLogo"]["tmp_name"], 'ecommerceLogo/' . $presentor_id. '.' . $imageFileType)) {
          $logoNameWithExtension = $presentor_id . "." . $imageFileType ;
          echo json_encode( array('rateOrPromo' => $target_file, 'message'=> $logoNameWithExtension) );
      } else {
          echo json_encode( array('rateOrPromo' => $target_file, 'message'=> "Sorry, there was an error uploading your file.") );
      }
  }
}
