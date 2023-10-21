<h1>Input Google Calender API Details</h1>
<h5 class="response"></h5>
<hr>
<div class="row">
<div class="col-md-7">
<?php
    $sql = "SELECT * FROM calenderapi WHERE userid=$usu_valido";
    $result = mysql_query($sql, $conexion);
    $row=mysql_fetch_array($result);
?>
<form method="post" class="form-horizontal" id="calenderAPI" action="agenda/ajaxAPI.php">
	<div class="form-group">
        <label class="col-md-4">Email:</label>
        <div  class="col-md-8">
        	<input type="email" name="email" class="form-control" value="<?=$row['email']?>" required>
    	</div>
    </div>
	<div class="form-group">
        <label class="col-md-4">Secret Key</label>
        <div  class="col-md-8">
	        <input type="text" name="secretKey" class="form-control" value="<?=$row['secretkey']?>">
        </div>
    </div>
	<div class="form-group">
        <label class="col-md-4">Client ID</label>
        <div  class="col-md-8">
	        <input type="text" name="clientId" class="form-control" value="<?=$row['clientid']?>">
        </div>
    </div>
	<div class="form-group">
        <label class="col-md-4">Client Secret</label>
        <div  class="col-md-8">
	        <input type="text" name="clientSecret" class="form-control" value="<?=$row['clientsecret']?>">
        </div>
    </div>
	<div class="form-group">
        <label class="col-md-4">Refresh Token</label>
        <div  class="col-md-8">
	        <textarea name="refresh_token" class="form-control" rows="4"><?=$row['refreshtoken']?></textarea>
        </div>
    </div>
	<div class="form-group">
        <label class="col-md-4">Message</label>
        <div  class="col-md-8">
	        <textarea name="messages" class="form-control" rows="4"><?=$row['message']?></textarea>
        </div>
    </div>
    <input type="hidden" name="userId" value="33638">
    <input type="submit" class="btn btn-primary" value="Save" >
</form>

<script>
// POST; inserting data
$("#calenderAPI").submit(function (evt) {
  evt.preventDefault();
  $.ajax({
    url: "agenda/ajaxAPI.php",
    type: "POST",
    data: $(this).serialize(), // data: formData
    dataType: "html",
  })
    .done(function (response) {
      console.log(response);
      var obj = jQuery.parseJSON(response); // maek JSON to JS Object
    //   alert(obj.message);
      $('.response').html( '<div class="alert alert-success" role="alert">'+obj.message+' Successfully</div>' ).fadeTo('slow', 1).fadeOut(1000, 'swing');
    })
    .fail(function () {
      alert("Ajax Submit Failed ...");
    });
});
</script>
</div>
</div>