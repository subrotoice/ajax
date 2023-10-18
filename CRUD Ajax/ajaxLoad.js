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

// Show Value Search
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
