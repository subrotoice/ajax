// Suggestion js
$( "#name" ).keyup(function () {
  if ($(this).val().length == 0) {
      $('#txtHint').text("Nothing....");
      return;
  } else {
      var url = "suggestion.php?q=" + $(this).val();
      $.get( url, function( data ) {
        $( "#txtHint" ).html( data );
      });
  }
});

// Voca Details will show on button click
$( document ).on( 'click', 'a#studentDetails', function(evt) { // For Dynamic Updated DOM you have to use this way to work jQuery
  evt.preventDefault();
  var values = $(this).data('studentid');
  var url = "vocaDetails.php?q=" + values;
  //alert(url);
  $.get( url, function( data ) {
    $('.studentEntry').hide();
    $( ".studentDetails" ).show( );
    $( ".studentDetails" ).html( data );
  });
});

// Add Student Button click
$(".addStudent").click(function(evt){
  evt.preventDefault();
  $('.studentDetails').fadeToggle( 0, 0, function() {
    $('.studentEntry').fadeToggle( 0, 0 );
  });
});

// Add Student Button click
$("form.studentEntry").submit(function(evt){
  evt.preventDefault();
  $.ajax({
    url: 'process.php',
    type: 'POST',
    data: $(this).serialize(), // it will serialize the form data
    dataType: 'html'
  })
  .done(function( data ){
    $('form.studentEntry').hide(50, 0, function() {
      $('.studentDetails').html( data ).fadeTo('slow', 1);
    });
  })
  .fail(function(){
    alert('Ajax Submit Failed ...');
  });
  $('form.studentEntry').trigger("reset");
});

// OnClick Edit Button
$( document ).on( 'click', '.edit, .editForm .form-control', function(evt) {
  evt.preventDefault();
  var values = $(this).data('studentid');
  if($("input[value='Save']").length == 0 )         // Check If submit is added or not
   {
     $(".editTable").append('<input type="submit" value="Save" class="pull-right btn btn-success" />');
   }
});

// Edit Student Info
$( document ).on( 'submit', 'form.editForm', function(evt) {
  evt.preventDefault();
  $.ajax({
    url: 'editvoca.php',
    type: 'POST',
    data:  new FormData(this),
    contentType: false,
          cache: false,
    processData:false
  })
  .done(function(data){
     $('.statusInfo').html(data).fadeTo("slow" , 1, function() {
       $('.statusInfo').fadeTo(4000 , 0);
     });
  })
  .fail(function(){
    alert('Ajax Submit Failed ...');
  });
});

// Delete Student
$( document ).on( 'click', 'a.delete', function(evt) { // For Dynamic Updated DOM you have to use this way to work jQuery
  evt.preventDefault();
  $('.editForm').fadeTo(10 , .5);
  var url = $("a.delete").attr("href");
  $.get(url, function(data) {
    $('.statusInfo').html(data).fadeTo("fast" , 1, function() {
      $('.statusInfo').fadeTo(600 , 0);
      $('.editForm').fadeTo(500 , 0);
    });
  });
});
