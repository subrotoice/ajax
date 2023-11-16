# AJAX CRUD

```javascript
// Smart Way
<form id="myForm"> 
  <label for="name">Name:</label>
  <input type="text" id="name" name="name" />
  <label for="email">Email:</label>
  <input type="email" id="email" name="email" />
  <button type="button" onclick="submitForm()">Submit</button>
</form>

<script>
  function submitForm() {
    var formDataManually = {
      name: $("#name").val(), // Get form data
      email: $("#email").val(),
    }; // var formData = $("#myForm").serialize(); or var formData = $(this).serialize();
    $.ajax({
      url: "test.php",
      type: "POST",
      data: formDataManually,
      dataType: "json",
      encode: true,
      success: function (response) {
        console.log("Success:", response); // Handle success
      },
      error: function (error) {
        console.error("Error:", error); // Handle error
      },
    });
  }
</script>
```

ajaxLoad.js

```javascript
// POST; inserting data
$(".myForm").submit(function (evt) {
  evt.preventDefault();
  var formData = $(this).serialize();
  $.ajax({
    url: "ajaxAPI.php",
    type: "POST",
    data: $(this).serialize(), // data: formData
    dataType: "html",
  })
    .done(function (response) {
      var obj = jQuery.parseJSON(response); // maek JSON to JS Object
      var name = obj.name;
      var message = obj.message;
      alert(message);
      $(".dataStatus").css("display", "block");
    })
    .fail(function () {
      alert("Ajax Submit Failed ...");
    });
  $("form.studentEntry").trigger("reset");
});

// POST without form data
var formData = {
name: "Subroto",
email: "subroto.iu@gmail.com",
};
$.ajax({
url: "ajaxAPI.php",
type: "POST",
data: formData,
dataType: "html",
})
.done(function (response) {
  var obj = jQuery.parseJSON(response); // maek JSON to JS Object
  console.log(response);
});
// GET request, Show Value Search
$("input.search").blur(function () {
  var searchValue = $(this).val();
  var rateOrPromo = "Test";
  var url =
    "ajaxAPI.php?searchValue=" + searchValue + "&rateOrValue=" + rateOrPromo;
  //   alert(url);
  $.get(url, function (response) {
    var obj = jQuery.parseJSON(response);
    alert(obj.name);
  });
});

// Form Data Submit (Another Example)
var formData = $("#forma").serialize();
$.ajax({
        url: "grabar_evento2.php",
        type: "POST",
        data: formData,
        dataType: "html",
    })
    .done(function(response) {
        var responseObj = jQuery.parseJSON(response);
        $('.response').html('<div class="alert alert-success" role="alert">' + responseObj.message + '</div>').fadeTo('slow', 1);
        $('<tr><td>' + responseObj.date + '</td><td>' + responseObj.time + '</td><td>' + responseObj.type + '</td><td>' + responseObj.text + '</td><td> </td><td> </td><td> </td></tr>').prependTo('table.infoTable>tbody');
        // alert(response);
    })
    .fail(function() {
        alert("Ajax Submit Failed ...");
    });
```

ajaxAPI.php

```php
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

```

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

```
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
```

# Vioniko ecommerce

```html
<!DOCTYPE html>
<html>
<head>
<title>VIONIKO | Primer Sistema de Marketing Colaborativo en el Mundo </title>
<meta charset="UTF-8">

<body>

    <div class="rightpanel">
		<div class="ecommerce" style="margin: 50px 0 0 50px;">
    			<h4>Current rate:
  		<input type="number" name="rate" id="rate" class="rate form-control" placeholder="New Rate" data-userid="3339">
			<button type="submit" class="button btn btn-primary"> Save </button> $<span class="rateValue">55.00</span></h4> <br>
      <h4>Promo Code: </span>
  		<input type="text" name="promo" id="promo" class="promo form-control" placeholder="Update Promo" data-userid="3339">
      <button type="submit" class="button btn btn-primary"> Save </button> <span class="promoValue">Patrimonio</h4> <br>
      <h4>Duration:
      <select name="duration" placeholder="*Selecciona Month" class="form-control"  id="duration" data-userid="3339">
        <option value="">*Selecciona tu Duration</option>
        <option value="1">1 Month</option>
        <option value="2">2 Months</option>
        <option value="3">3 Months</option>
        <option value="4">4 Months</option>
        <option value="5">5 Months</option>
        <option value="6">6 Months</option>
        <option value="7">7 Months</option>
        <option value="8">8 Months</option>
        <option value="9">9 Months</option>
        <option value="10">10 Months</option>
        <option value="11">11 Months</option>
        <option value="12">1 Year</option>
        <option value="24">2 Years</option>
      </select>
      <button type="submit" class="button btn btn-primary"> Save </button> <span class="durationValue">2 Months</span></h4> <br>
      <h4>PayPal Email:
  		<input type="text" name="paypal" id="paypal" class="paypal form-control" placeholder="Update PayPal Email" data-userid="3339">
      <button type="submit" class="button btn btn-primary"> Save </button> <span class="paypalValue"> sb-bqoez22343014@business.example.com</span></h4><br>
      <h4>Link After Login:
  		<input type="text" name="linkAfterLogin" id="linkAfterLogin" class="linkAfterLogin form-control" placeholder="Link After Login" data-userid="3339">
      <button type="submit" class="button btn btn-primary"> Save </button> <span class="linkAfterLoginValue"> </span>
      <span class="info">( Keep Blank for Default link )</span>
      </h4>      <br>
      <h4>1st Level Commisions:
  		<input type="number" name="firstLevelCommisions" id="firstLevelCommisions" class="firstLevelCommisions form-control" placeholder="ie. 25%" data-userid="3339">
      <button type="submit" class="button btn btn-primary"> Save </button> <span class="firstLevelCommisionsValue"> 40%</span>
      </h4> <br>
      <h4>2nd Level Commisions:
  		<input type="number" name="secondLevelCommisions" id="secondLevelCommisions" class="secondLevelCommisions form-control" placeholder="ie. 25%" data-userid="3339">
      <button type="submit" class="button btn btn-primary"> Save </button> <span class="secondLevelCommisionsValue"> 15%</span>
      </h4> <br>
      <h4>Information Text:
      <textarea name="informationText" id="informationText" rows="4" cols="30"  class="informationText form-control" placeholder="Information Text" data-userid="3339"></textarea>
      <button type="submit" class="button btn btn-primary"> Save </button> <span class="informationTextValue"> Demo Test 22</span>
      </h4> <br >

      <h4>Video Link:
  		<input type="text" name="videoLink" id="videoLink" class="videoLink form-control" placeholder="videoLink Text" data-userid="3339">
      <button type="submit" class="button btn btn-primary"> Save </button> <span class="videoLinkValue"> https://www.youtube.com/watch?v=ZnnJpJoIax8</span>
      </h4> <br >

      <form id="form1" action="ajaxload.php" method="post" enctype="multipart/form-data">
          <div class="row form-group h-50">
            <div class="col-md-3"><input id="uploadImage" class="fileupload" type="file" accept="image/*" name="ecommerceLogo" /></div>
            <input type="hidden" name="presentor_id" value="3339">
            <div class="col-md-2"><input class="btn btn-success" type="submit" value="Upload Logo"></div>
            <div class="col-md-7">
                              <a class="logoClass" href="ecommerceLogo/3339.png" target="_blank" rel="noopener noreferrer">
                  <img width="50px" src="ecommerceLogo/3339.png" alt="">
                </a>
              </div>
          </div>
      </form>

      <div class="saveRateInfo"></div>
		</div>


    </div><!--rightpanel-->

</div>

<!--mainwrapper-->
<script type="text/javascript">
  // Rate Dynamic update
	$("input, select, textarea.informationText").blur(function(){
		var userid = $(this).data('userid');
		var rateValue= $(this).val();
    var rateOrPromo = $(this).attr("id");
    if(rateValue=="" && rateOrPromo!="linkAfterLogin") {
      exit();
    }
		var notificationClass= "saved" + userid;
		var url = "ajaxload.php?userid=" + userid + "&"+ rateOrPromo +"=" + rateValue;
		// alert( url );
		$.get( url, function( data ) {
      var objData = jQuery.parseJSON( data );
      if(objData.rateOrPromo == 'rate') {
        $( ".rateValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else if(objData.rateOrPromo == 'promo') {
        $( ".promoValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else if(objData.rateOrPromo == 'duration') {
        $( ".durationValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else if(objData.rateOrPromo == 'paypal') {
        $( ".paypalValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else if(objData.rateOrPromo == 'linkAfterLogin') {
        $( ".linkAfterLoginValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else if(objData.rateOrPromo == 'firstLevelCommisions') {
        $( ".firstLevelCommisionsValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else if(objData.rateOrPromo == 'secondLevelCommisions') {
        $( ".secondLevelCommisionsValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else if(objData.rateOrPromo == 'informationText') {
        $( ".informationTextValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else if(objData.rateOrPromo == 'videoLink') {
        $( ".videoLinkValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else {
        message = "<p style='color: red; font-weight: bold;'> " + objData.message + "</p>";
        $( ".saveRateInfo" ).html( message );
      }

		});
  	});

    // E-Commerce Logo Upload
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
        var imgName = "https://vioniko.com/ecommerceLogo/" + objData.message;
        // alert(imgName);
        $("a.logoClass").attr("href", imgName);
        $("a.logoClass>img").attr("src", imgName);

      })
      .fail(function(){
        alert('Ajax Submit Failed ...');
      });
    });

</script>
</body>
</html>
```
